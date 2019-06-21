<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use Mockery\Exception;
use Modules\Admin\Entities\BrandCountry;
use Modules\Shopping\Entities\ConfirmationBanner;
use Modules\Shopping\Entities\ConfirmationBannerCountry;
use Modules\Shopping\Entities\ConfirmationPurpose;
use Modules\Shopping\Entities\ConfirmationType;
use Modules\Shopping\Entities\Promo;
use Modules\Shopping\Entities\PromoProd;
use View;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\ACL\User;
use Modules\Shopping\Entities\GroupCountry;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\LanguageTranslation;

use Modules\Admin\Http\Controllers\AdminController as Controller;


class PromoProdsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {

        $promos  = Promo::where('delete',0)->get();




        $this->layoutData['content'] = View::make('admin::shopping.promoprods.index', compact('promos'));

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
        $title      = trans('admin::shopping.promoprods.add.view.form-countries');
        $languages = Language::where('delete', 0)->orderBy('active','desc')->get();


        //$countriesUser = \GuzzleHttp\json_encode($countriesUser);



        $this->layoutData['content'] = View::make('admin::shopping.promoprods.create', compact('locale', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {




            if(!empty($request->promo_key)){

                    try{
                                DB::beginTransaction();

                                     $idPromo = $this->savePromo($request->promo_key,$request->active);
                                        if ($idPromo > 0) {

                                            $resTransPromo = $this->saveTranslationPromo($idPromo, $request);

                                            if ($resTransPromo != 1) {
                                                return ['success' => false, 'message' => $resTransPromo, 'data' => ''];
                                            }


                                        } else {
                                            return ['success' => false, 'message' => trans('admin::shopping.promoprods.add.error.controller-fail'), 'data' => ''];
                                        }


                                 DB::commit();


                            return ['success' => true, 'message' => trans('admin::shopping.promoprods.add.error.controller-success'), 'data' => $idPromo];



                    }
                    catch (Exception $e){
                    DB::rollback();
                        return ['success' => false, 'message' => $e->getMessage(), 'data' => ''];

                    }
            }


              return ['success' => false, 'message' => trans('admin::shopping.promoprods.add.error.empty-key'), 'data' => ''];











    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function saveProdPromo(Request $request) {




        if(!empty($request->productcode)){

            try{
                DB::beginTransaction();

                $idPromoProd = $this->savePromoProd($request->promo_id_p,$request->productcode,$request);

                if ($idPromoProd != 1) {
                    return ['success' => false, 'message' => trans('admin::shopping.promoprods.add.error.controller-fail'), 'data' => ''];
                }



                DB::commit();


                return ['success' => true, 'message' => trans('admin::shopping.promoprods.add.error.controller-success'), 'data' => ''];



            }
            catch (Exception $e){
                DB::rollback();
                return ['success' => false, 'message' => $e->getMessage(), 'data' => ''];

            }
        }


        return ['success' => false, 'message' => trans('admin::shopping.promoprods.add.error.empty-key'), 'data' => ''];











    }



    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id) {

        $promo = Promo::where('id',$id)->first();
        $locale     = Auth::user()->language->locale_key;
        $languages = Language::where('delete', 0)->orderBy('active','desc')->get();


        $this->layoutData['content'] = View::make('admin::shopping.promoprods.edit', compact('confirmationsByCountry', 'promo','locale','languages'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {

        if(!empty($request->promo_id)){

            //Se almacena en la tabla principal
            try{
                DB::beginTransaction();




                    $infoPromo = Promo::where('id',$request->promo_id)->first();

                    if ($infoPromo->id > 0) {
                        //Actualizamos la tabla confirmation banner
                            Promo::where('id', $infoPromo->id)->update(['clv_promo' => $request->promo_key, 'active' => $request->active]);

                            $resTransPromo = $this->updateTranslationPromo($infoPromo->id, $request);

                            if ($resTransPromo != 1) {
                                return ['success' => false, 'message' => $resTransPromo, 'data' => ''];
                            }

                    }else{
                        return ['success' => false, 'message' => trans('admin::shopping.promoprods.edit.error.nopromo'), 'data' => ''];
                    }



                DB::commit();
                return ['success' => true, 'message' => trans('admin::shopping.promoprods.edit.error.controller-success'), 'data' => ''];

            }catch(Exception $e){
                DB::rollback();
                return ['success' => false, 'message' => $e->getMessage(), 'data' => ''];
            }
        }else{
            return ['success' => false, 'message' => trans('admin::shopping.promoprods.add.error.empty-key'), 'data' => ''];
        }





    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function updateProdPromo(Request $request) {





        if(!empty($request->productcode)){

            try{
                DB::beginTransaction();
                foreach ($request->productcode as $key => $pc) {

                    $infoPromoProd = PromoProd::where('id', $request->id_pp[$key])->first();

                    if (isset($infoPromoProd->id)) {
                        $deleted = isset($request->deleted[$key]) == null ? 0 : 1;
                        $active = $deleted == 0 ? 1 : 0;
                        PromoProd::where('id', $infoPromoProd->id)->update(['clv_producto' => $request->productcode[$key], 'active' => $active, 'delete' => $deleted]);
                        $resTransPromoProd = $this->updateTranslationPromoProd($infoPromoProd->id,$key,$request);

                        if ($resTransPromoProd != 1) {
                            return ['success' => false, 'message' => trans('admin::shopping.promoprods.edit.error.controller-fail'), 'data' => ''];
                        }

                    }else{
                        //logica para nuevos productos
                        $data = PromoProd::updateOrCreate(
                            ['promo_id' => $request->promo_id,'clv_producto' => $pc],
                            ['clv_promo' => $request->promo_id,'clv_producto' => $pc ,'active' => 1,'delete' => 0]
                        );


                        if($data->id > 0){
                            //inserciones de traducciones


                            $resTransPromo = $this->saveTranslationPromoProd($data->id,$key,$request);



                            if ($resTransPromo != 1) {
                                return ['success' => false, 'message' => $resTransPromo, 'data' => ''];
                            }



                        }

                    }
                }
               DB::commit();


               return ['success' => true, 'message' => trans('admin::shopping.promoprods.edit.error.controller-success'), 'data' => ''];



            }
            catch (Exception $e){
                DB::rollback();
                return ['success' => false, 'message' => $e->getMessage(), 'data' => ''];

            }
        }


        return ['success' => false, 'message' => trans('admin::shopping.promoprods.edit.error.empty-key'), 'data' => ''];

    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy(Request $request)
    {

        $promo = Promo::where('id',$request->id)->get();
        foreach ($promo as $c){
            $c->last_modifier_id = Auth::user()->id;
            $c->active = 0;
            $c->delete = 1;
            $c->save();
        }
        return redirect()->route('admin.promoprods.index')->with('msg', trans('admin::shopping.promoprods.edit.error.controller-success'));
    }


    public function changeStatus(Request $request) {
        if ($request->has('new-status')) {
            $promoProd = Promo::where('id',$request->id)->get();

            $newStatus           = 0;

            if ($request->input('new-status') == 'activate') {
                $newStatus = 1;
            }

            foreach ($promoProd as $c){
                $c->last_modifier_id = Auth::user()->id;
                $c->active = $newStatus;
                $c->save();
            }

            return redirect()->route('admin.promoprods.index')->with('msg', trans('admin::shopping.promoprods.edit.error.controller-success'));
        }
    }

    /** Save promo
     * @param $promo_key
     * @return int
     */
    private function savePromo($promo_key,$active)
    {


        $data = Promo::updateOrCreate(
            ['clv_promo' => $promo_key],
            ['clv_promo' => $promo_key,'active' => $active,'delete' => 0]
        );

        return $data->id;



    }

    /** Save promoProd
     * @param $promo_key,$clv_prod
     * @return int
     */
    private function savePromoProd ($promo_key,$productcode,$request)
    {


        foreach ($productcode as $key => $pc){

            $data = PromoProd::updateOrCreate(
                ['promo_id' => $promo_key,'clv_producto' => $pc],
                ['clv_promo' => $promo_key,'clv_producto' => $pc ,'active' => 1,'delete' => 0]
            );

            if($data->id > 0){
                //inserciones de traducciones


                    $resTransPromo = $this->saveTranslationPromoProd($data->id,$key,$request);



                    if ($resTransPromo != 1) {
                        return ['success' => false, 'message' => $resTransPromo, 'data' => ''];
                    }



            }
        }



        return 1;



    }



    /** Sve promo translations
     * @param $promo_id
     * @param $request
     * @return int|string
     */

    private function saveTranslationPromo($promo_id,$request)
    {

        $promoconf = Promo::find($promo_id);

        //dd($request->all());
        foreach($request->local_key as $key => $langCountry) {




            if (!empty($request->promo_name)) {
                $promoconf->translateOrNew($langCountry)->promo_id         = $promo_id;
                $promoconf->translateOrNew($langCountry)->name_header         = $request->promo_name[$key];
                $promoconf->translateOrNew($langCountry)->description_header         = $request->promo_desc[$key];
                $promoconf->translateOrNew($langCountry)->active         = 1;
                $idPrompranslation = $promoconf->id;
            } else {
                $idPrompranslation = 0;
            }

            $promoconf->save();


        }
        return 1;
    }


    /** upd promo translations
     * @param $promo_id
     * @param $request
     * @return int|string
     */

    private function updateTranslationPromo($promo_id,$request)
    {

        $promoconf = Promo::find($promo_id);

        //dd($request->all());

            foreach($request->local_key as $key => $langCountry) {

                if (!empty($request->promo_name)) {
                    $promoconf->translateOrNew($langCountry)->promo_id         = $promo_id;
                    $promoconf->translateOrNew($langCountry)->name_header         = $request->promo_name[$key];
                    $promoconf->translateOrNew($langCountry)->description_header         = $request->promo_desc[$key];
                    $promoconf->translateOrNew($langCountry)->active         = 1;
                    $idPrompranslation = $promoconf->id;
                } else {
                    $idPrompranslation = 0;
                }

                $promoconf->save();


            }
            return 1;




    }

    /** Sve promoprod translations
     * @param $promo_id
     * @param $request
     * @return int|string
     */

    private function saveTranslationPromoProd($promo_id,$key,$request)
    {

        $promoprodconf = PromoProd::find($promo_id);

        $pos = $request->position[$key];




        foreach($request->local_key as $key => $langCountry) {

            $name = 'nameprod_'.$pos.'_'.$langCountry;;
            $desc = 'descprod_'.$pos.'_'.$langCountry;

            if (!empty($request->$name)) {
                $promoprodconf->translateOrNew($langCountry)->promo_prod_id         = $promo_id;
                $promoprodconf->translateOrNew($langCountry)->name         = $request->$name;
                $promoprodconf->translateOrNew($langCountry)->description         = $request->$desc;
                $promoprodconf->translateOrNew($langCountry)->active         = 1;
                $idPrompranslation = $promoprodconf->id;
            } else {
                $idPrompranslation = 0;
            }

            $promoprodconf->save();



        }
        return 1;
    }


    /** upd promoprod translations
     * @param $promo_id
     * @param $request
     * @return int|string
     */

    private function updateTranslationPromoProd($promo_id,$key,$request)
    {
        //dd($promo_id,$pos,$request->all());
        $promoprodconf = PromoProd::find($promo_id);
        $pos = $request->position[$key];
        //dd($request->all());
        foreach($request->local_key as $key => $langCountry) {

            if($request->deleted[$pos] != 1) {

                $name = 'nameprod_' . $pos . '_' . $langCountry;;
                $desc = 'descprod_' . $pos . '_' . $langCountry;

                if (!empty($request->$name)) {

                    $promoprodconf->translateOrNew($langCountry)->promo_prod_id = $promo_id;
                    $promoprodconf->translateOrNew($langCountry)->name = $request->$name;
                    $promoprodconf->translateOrNew($langCountry)->description = $request->$desc;
                    $promoprodconf->translateOrNew($langCountry)->active = 1;
                    $idPrompranslation = $promoprodconf->id;
                } else {
                    $idPrompranslation = 0;
                }

                $promoprodconf->save();
            }


        }
        return 1;
    }
}
