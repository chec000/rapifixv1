<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use Mockery\Exception;
use Modules\Admin\Entities\BrandCountry;
use Modules\Shopping\Entities\ConfirmationBanner;
use Modules\Shopping\Entities\ConfirmationBannerCountry;
use Modules\Shopping\Entities\ConfirmationPurpose;
use Modules\Shopping\Entities\ConfirmationType;
use View;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\ACL\User;
use Modules\Shopping\Entities\GroupCountry;
use Illuminate\Support\Facades\DB;

use Modules\Admin\Http\Controllers\AdminController as Controller;

class ConfirmationBannerController extends Controller
{
    const KIOSCO_PURPOSE = 4;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $confirmationbanners  = ConfirmationBanner::where('delete',0)->where('purpose_id', '!=', self::KIOSCO_PURPOSE)
            ->groupBy('global_name')
            ->get();
        $this->layoutData['content'] = View::make('admin::shopping.confirmationbanners.index', compact('confirmationbanners'));
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
        $title      = trans('admin::shopping.confirmationbanners.add.view.form-countries');
        $types= ConfirmationType::where('active',1)->where('delete',0)->get();
        $purposes =  ConfirmationPurpose::where('active',1)->where('delete',0)->get();

       //$countriesUser = \GuzzleHttp\json_encode($countriesUser);


        $this->layoutData['modals']  = View::make('admin::shopping.confirmationbanners.modals.country', compact('countriesUser', 'title'));
        $this->layoutData['content'] = View::make('admin::shopping.confirmationbanners.create', compact('locale', 'countriesUser','types','purposes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        //dd($request->all());

        if(!empty($request->purpose) && !empty($request->type) && !empty($request->global_name)){

            $purpose    = $request->purpose;
            $type       = $request->type;
            $globalName = $request->global_name;

            //Se almacena en la tabla principal
            try{
                DB::beginTransaction();


                    foreach (Auth::user()->countries as $uC) {

                        $link   = "link_".$uC->id;
                        $active     = "active_".$uC->id;




                        if ($request->$active != null) {

                            $idBan = $this->saveConfirmationCountry($globalName, $uC->id,$type,$purpose,$request->$link, $request->$active);
                            if ($idBan > 0) {

                                    $resTransBanner = $this->saveTranslationBanners($uC->id, $idBan, $request,$request->$active);

                                    if ($resTransBanner != 1) {
                                        return back()->withInput()->withErrors(array('msg' => $resTransBanner));
                                    }


                            } else {
                                return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.confirmationbanners.add.error.controller-country')));
                            }
                        }
                    }
                    DB::commit();

                    return redirect()->route('admin.confirmationbanners.index')->with('msg', trans('admin::shopping.confirmationbanners.add.error.controller-success'));

            }

            catch (Exception $e){
                DB::rollback();
                return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.confirmationbanners.add.error.controller-country')));

            }





        }

        return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.confirmationbanners.add.error.empty-params')));




    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($global_name) {

        $global_name = urldecode($global_name);

        $confirmationsByCountry = ConfirmationBanner::where('global_name', $global_name)->whereIn('country_id', User::userCountriesPermission())->get();

        $type       = $confirmationsByCountry[0]->type_id;
        $purpose    = $confirmationsByCountry[0]->purpose_id;
        $globalName = $confirmationsByCountry[0]->global_name;

        $type_list= ConfirmationType::where('active',1)->where('delete',0)->get();
        $purpose_list =  ConfirmationPurpose::where('active',1)->where('delete',0)->get();
        /* $selectedType          = $categoriesByCountry->first()->type;
        $selectedPurpose       = $categoriesByCountry->first()->purpose; */

        $title = trans('admin::shopping.confirmationbanners.add.view.form-countries');

        $countriesTo = [];
        foreach (Auth::user()->countries as $country) {

            $countriesTo[] = $country->id;
        }


        $anotherCountries = Auth::user()->countries;


        $anotherCountries = $anotherCountries->reject(function ($country) use ($confirmationsByCountry, $countriesTo) {
            foreach ($confirmationsByCountry as $confirmationByCountry) {
                if ($country->id == $confirmationByCountry->country_id) {
                    return true;
                }

                if (!in_array($country->id, $countriesTo)) {
                    return true;
                }
            }
        });






        $this->layoutData['modals']  = View::make('admin::shopping.confirmationbanners.modals.countryedit', ['title' => $title, 'confirmationsByCountry' => $confirmationsByCountry, 'anotherCountries' => $anotherCountries]);
        $this->layoutData['content'] = View::make('admin::shopping.confirmationbanners.edit', compact('confirmationsByCountry', 'type', 'globalName', 'purpose','type_list','purpose_list','countriesTo', 'anotherCountries','selectedType','selectedPurpose'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {

        if(!empty($request->purpose) && !empty($request->type) && !empty($request->global_name)){
            $purpose_old   = $request->purpose_old;
            $type_old      = $request->type_old;
            $globalNameOld = $request->global_name_old;

            //Se almacena en la tabla principal
            try{
            DB::beginTransaction();
            foreach (Auth::user()->countries as $uC)
            {

                $active       = "active_".$uC->id;
                $link         = "link_".$uC->id;

                $infoConfirmation = ConfirmationBanner::where('country_id', $uC->id)->where(['type_id' => $type_old, 'purpose_id' => $purpose_old, 'global_name' => $globalNameOld])->first();

                if (isset($infoConfirmation)) {
                    //Actualizamos la tabla confirmation banner
                    ConfirmationBanner::where('id', $infoConfirmation->id)->update(['global_name' => $request->global_name, 'link' => $request->$link, 'type_id' => $request->type,'purpose_id' => $request->purpose, 'active' => $request->$active]);


                    foreach ($uC->languages as $countryLang) {

                        $image = 'image_'.$uC->id.'_'.$countryLang->language->id;

                        if (!empty($request->$image)) {
                            $infoConfirmation->translateOrNew($countryLang->language->locale_key)->image         = $request->$image;
                            $infoConfirmation->translateOrNew($countryLang->language->locale_key)->active        = $active;
                        }
                    }

                    $infoConfirmation->update();
                } else {
                    if ($request->$active != null) {

                        $idBan = $this->saveConfirmationCountry($request->global_name, $uC->id,$request->type,$request->purpose,$request->$link, $request->$active);
                        if ($idBan > 0) {

                            $resTransBanner = $this->saveTranslationBanners($uC->id, $idBan, $request,$request->$active);

                            if ($resTransBanner != 1) {
                                return back()->withInput()->withErrors(array('msg' => $resTransBanner));
                            }


                        } else {
                            return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.confirmationbanners.edit.error.controller-country')));
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.confirmationbanners.index')->with('msg', trans('admin::shopping.confirmationbanners.edit.error.controller-success'));
            }catch(Exception $e){
                DB::rollback();
                return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.confirmationbanners.add.error.controller-country')));
            }
        }

        return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.confirmationbanners.add.error.empty-params')));
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy(Request $request)
    {
        $confirmartionBanner = ConfirmationBanner::where(['type_id' => $request->type,'purpose_id' => $request->purpose])->get();
        foreach ($confirmartionBanner as $c){
            $c->last_modifier_id = Auth::user()->id;
            $c->active = 0;
            $c->delete = 1;
            $c->save();
        }
        return redirect()->route('admin.confirmationbanners.index')->with('msg', trans('admin::shopping.confirmationbanners.edit.error.controller-success'));
    }


    public function changeStatus(Request $request) {
        if ($request->has('new-status')) {
            $confirmartionBanner = ConfirmationBanner::where(['type_id' => $request->type,'purpose_id' => $request->purpose])->get();
            $newStatus           = 0;

            if ($request->input('new-status') == 'activate') {
                $newStatus = 1;
            }

            foreach ($confirmartionBanner as $c){
                $c->last_modifier_id = Auth::user()->id;
                $c->active = $newStatus;
                $c->save();
            }

            return redirect()->route('admin.confirmationbanners.index')->with('msg', trans('admin::shopping.confirmationbanners.edit.error.controller-success'));
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
    private function saveTranslationBanners($idCountry , $idBanner, $request, $active)
    {

        $bannerconf = ConfirmationBanner::find($idBanner);

        //dd($request->all());
        foreach(Auth::user()->getCountryLang($idCountry) as $langCountry) {

            $image        = 'image_'.$idCountry.'_'.$langCountry->id;


            if (!empty($request->$image)) {
                $bannerconf->translateOrNew($langCountry->locale_key)->image         = $request->$image;
                $bannerconf->translateOrNew($langCountry->locale_key)->active         = $active;
                $idBannerTranslation = $bannerconf->id;
            } else {
                $idBannerTranslation = 0;
            }

            $bannerconf->save();


        }
        return 1;
    }



    /**
     * @param $countryId
     * @param $active
     * @return int
     */
    private function saveConfirmationCountry($globalName, $countryId, $type, $purpose, $link, $active)
    {
        $data = ConfirmationBanner::updateOrCreate(
            ['global_name' => $globalName, 'country_id' => $countryId,'purpose_id' => $purpose,'type_id' => $type],
            ['country_id' => $countryId,'purpose_id' => $purpose,'type_id' => $type,'link' => $link,'active' => $active]
        );

        return $data->id;



    }
}
