<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use Modules\Admin\Entities\BrandCountry;
use View;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\ACL\User;
use Modules\Shopping\Entities\GroupCountry;
use Modules\Shopping\Entities\Legal;
use Modules\Shopping\Entities\LegalTranslation;
use Illuminate\Support\Facades\DB;
use Validator;

use Modules\Admin\Http\Controllers\AdminController as Controller;

class LegalsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        //4 = kiosco_purpose
        $legals = Legal::where(['delete' => 0])->where('purpose_id', '!=', 4)->orWhere('purpose_id', null)->get();
        $this->layoutData['content'] = View::make('admin::shopping.legals.index', compact('legals'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $countriesUser = Auth::user()->countries;
        $countries = [];
        foreach ($countriesUser as $uc){

            $countries[$uc->id] = $uc->name;


        }
        $locale     = Auth::user()->language->locale_key;
        $title      = trans('admin::shopping.legals.add.view.form-countries');

       //$countriesUser = \GuzzleHttp\json_encode($countriesUser);


        $this->layoutData['modals']  = View::make('admin::shopping.legals.modals.country', compact('countriesUser', 'title'));
        $this->layoutData['content'] = View::make('admin::shopping.legals.create', compact('locale', 'countriesUser'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        //dd($request->all());

            //Se almacena en la tabla principal
            try{
                DB::beginTransaction();




                foreach (Auth::user()->countries as $uC) {


                    $active       = "active_".$uC->id;
                    $activecontract       = "activecontract_".$uC->id;
                    $activedisclaimer     = "activedisclaimer_".$uC->id;
                    $activepolicies = "activepolicies_".$uC->id;
                    $acontract = isset($request->$activecontract)    ? 1 : 0;
                    $adisclaimer = isset($request->$activedisclaimer)  ? 1 : 0;
                    $apolicies = isset($request->$activepolicies)  ? 1 : 0;



                    if ($request->$active != null) {

                        $idLeg = $this->saveLegalsCountry($uC->id,$acontract,$adisclaimer,$apolicies,$request->$active);

                        if ($idLeg > 0) {

                            $resTransLegal = $this->saveTranslationLegals($uC->id, $idLeg, $request,$request->$active);

                            if ($resTransLegal != 1) {
                                return back()->withInput()->withErrors(array('msg' => $resTransLegal));
                            }


                        } else {
                            return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.legals.add.error.controller-country')));
                        }
                    }
                }
                DB::commit();

                return redirect()->route('admin.legals.index')->with('msg', trans('admin::shopping.legals.add.error.controller-success'));

            }

            catch (Exception $e){
                DB::rollback();
                return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.legals.add.error.controller-country')));

            }

          return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.legals.add.error.empty-params')));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id) {

        $legalsByCountry = Legal::where('id',$id)->first();
        //dd($legalsByCountry);
        $identifier = $id;

        $this->layoutData['content'] = View::make('admin::shopping.legals.edit', compact('legalsByCountry','identifier'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {



            try{
                DB::beginTransaction();
                foreach (Auth::user()->countries as $uC)
                {

                    $active       = "active_".$uC->id;
                    $activecontract       = "activecontract_".$uC->id;
                    $activedisclaimer     = "activedisclaimer_".$uC->id;
                    $activepolicies = "activepolicies_".$uC->id;
                    $acontract = isset($request->$activecontract)    ? 1 : 0;
                    $adisclaimer = isset($request->$activedisclaimer)  ? 1 : 0;
                    $apolicies = isset($request->$activepolicies)  ? 1 : 0;

                    $infoLegal = Legal::where(['id' => $request->id,'country_id' => $uC->id])->first();

                    if (isset($infoLegal)) {
                        //Actualizamos la tabla confirmation banner
                        //dd($request->$activecontract,$acontract,$adisclaimer,$apolicies);
                        Legal::where('id', $infoLegal->id)->update(['active_contract' => $acontract, 'active_disclaimer' => $adisclaimer,'active_policies' => $apolicies, 'active' => $request->$active]);


                        foreach ($uC->languages as $countryLang) {


                            $contract = 'contract_'.$uC->id.'_'.$countryLang->language->id;
                            $contractpdf = 'contractpdf_'.$uC->id.'_'.$countryLang->language->id;
                            $disclaimer = 'disclaimer_'.$uC->id.'_'.$countryLang->language->id;
                            $terms_pdf = 'termspdf_'.$uC->id.'_'.$countryLang->language->id;

                            $contractvalid = 'contractpdf_'.$uC->id.'_'.$countryLang->language->id;
                            $termsvalid = 'termspdf_'.$uC->id.'_'.$countryLang->language->id;

                            /* $validator = Validator::make($request->all(), [
                                $contractpdf   => 'required|mimes:pdf|max:10000',
                                $terms_pdf      => 'required|mimes:pdf|max:10000',
                            ]);

                            //dd($request->all(),$request->$contract,$request->$contractpdf,$request->$disclaimer,$request->$terms_pdf);
                            if($validator->passes()) { */

                                if (!empty($request->$contract) && !empty($request->$contractpdf)) {
                                    $infoLegal->translateOrNew($countryLang->language->locale_key)->contract_html = $request->$contract;
                                    $infoLegal->translateOrNew($countryLang->language->locale_key)->contract_pdf = $request->$contractpdf;
                                    $infoLegal->translateOrNew($countryLang->language->locale_key)->disclaimer_html = $request->$disclaimer;
                                    $infoLegal->translateOrNew($countryLang->language->locale_key)->policies_pdf            = $request->$terms_pdf;
                                    $infoLegal->translateOrNew($countryLang->language->locale_key)->active = $active;
                                }
                            /* }
                            else{
                                $resTransLegal = trans('admin::shopping.legals.edit.error.controller-pdfextension');;
                                return back()->withInput()->withErrors(array('msg' => $resTransLegal));
                            } */
                        }

                        $infoLegal->update();
                    }
                }
                DB::commit();
                return redirect()->route('admin.legals.index')->with('msg', trans('admin::shopping.legals.edit.error.controller-success'));
            }catch(Exception $e){
                DB::rollback();
                return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.legals.add.error.controller-country')));
            }


            return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.legals.add.error.empty-params')));
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy(Request $request)
    {
        $legal = Legal::where('id',$request->id)->first();
        if($legal->id > 0){
            $legal->last_modifier_id = Auth::user()->id;
            $legal->active = 0;
            $legal->delete = 1;
            $legal->save();
        }
        return redirect()->route('admin.legals.index')->with('msg', trans('admin::shopping.legals.edit.error.controller-success'));
    }

    public function changeStatus(Request $request) {
        if ($request->has('new-status')) {
            $legal     = Legal::where('id',$request->id)->first();
            $newStatus = 0;

            if ($request->input('new-status') == 'activate') {
                $newStatus = 1;
            }

            if ($legal->id > 0){
                $legal->last_modifier_id = Auth::user()->id;
                $legal->active = $newStatus;
                $legal->save();
            }

            return redirect()->route('admin.legals.index')->with('msg', trans('admin::shopping.legals.edit.error.controller-success'));
        }
    }

    /**
     * @param $idCountry
     * @param $idCountryCategory
     * @param $request
     * @param $active
     * @param $product
     * @return int|string
     */
    private function saveTranslationLegals($idCountry , $idLeg, $request, $active)
    {

        $legalsconf = Legal::find($idLeg);



        //dd($request->all());
        foreach(Auth::user()->getCountryLang($idCountry) as $langCountry) {


            $contract_html  = 'contract_'.$idCountry.'_'.$langCountry->id;
            $contract_pdf = 'contractpdf_'.$idCountry.'_'.$langCountry->id;
            $disclaimer = 'disclaimer_'.$idCountry.'_'.$langCountry->id;
            $terms_pdf = 'termspdf_'.$idCountry.'_'.$langCountry->id;

            $contractvalid = 'contractpdf_'.$idCountry.'_'.$langCountry->id;
            $termsvalid = 'termspdf_'.$idCountry.'_'.$langCountry->id;



                if (!empty($request->$contract_html) && !empty($request->$contract_pdf)) {
                    $legalsconf->translateOrNew($langCountry->locale_key)->contract_html        = $request->$contract_html;
                    $legalsconf->translateOrNew($langCountry->locale_key)->contract_pdf         = $request->$contract_pdf;
                    $legalsconf->translateOrNew($langCountry->locale_key)->disclaimer_html      = $request->$disclaimer;
                    $legalsconf->translateOrNew($langCountry->locale_key)->policies_pdf            = $request->$terms_pdf;
                    $legalsconf->translateOrNew($langCountry->locale_key)->active               = $active;
                    $legalsconf->translateOrNew($langCountry->locale_key)->last_modifier_id     = Auth::user()->id;



                    $idLegalTranslation = $legalsconf->id;
                } else {
                    $idLegalTranslation = 0;
                }

                $legalsconf->save();







        }
        return 1;
    }

    /**
     * @param $countryId
     * @param $active
     * @return int
     */
    private function saveLegalsCountry($countryId, $activecontract,$activedisclaimer,$activepolicies,$active)
    {

        $data = Legal::updateOrCreate(
            ['country_id' => $countryId],
            ['country_id' => $countryId,'active_contract' => $activecontract,'active_disclaimer' => $activedisclaimer,'active_policies' => $activepolicies,'delete' => 0,'active' => $active]
        );

        return $data->id;


    }
}
