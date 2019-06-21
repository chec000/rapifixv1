<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\CountryTraslationModel;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use View;
use Auth;
use Validator;
use Illuminate\Http\Request;
//use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Libraries\Builder\FormMessage;
use Illuminate\Support\Facades\DB;

class CountriesController extends Controller {

    public function getIndex() {
        $countryList = Country::with('languages')->where('delete', 0)->orderBy('active', 'desc')->get();

        $this->layoutData['modals']  = View::make('admin::shopping.pool.modals.confirm');
        $this->layoutData['content'] = View::make('admin::settings.countries.list', array('countries' => $countryList,
                    'can_add' => Auth::action('countries.add'),
                    'can_delete' => Auth::action('countries.active'),
                    'can_remove' => Auth::action('countries.delete'),
                    'can_edit' => Auth::action('countries.edit')));
    }

    public function getAdd($mensage = "", $validacion = "") {
        $languagesList = Language::where('active', '=', 1)->get();
        $this->layoutData['content'] = View::make('admin::settings.countries.form', array('languages' => $languagesList,
                    'msg' => $mensage,
                    'validacion' => $validacion,
                    'langSelect' => Language::selectArrayActive($languagesList)));
    }

    public function postAdd(Request $request) {
        if ($request->isMethod('post')) {
            if (count($request->languages) > 0) {
                $v = Validator::make($request->all(), array(
                            'country_key' => 'required',
                            'timezone' => 'required',
                            'currency_key' => 'required',
                            'corbiz_key' => 'required', 
                            'default_locale' => 'required',
                            'webservice' => 'required'
                                )
                );
                $attrNamesTrans = array(
                    'dominio' => trans('admin::brand.form_add.url'),
                    'flag' => trans('admin::countries.add_flag')
                );
                $v->setAttributeNames($attrNamesTrans);
                if ($this->validateTraslations($request)) {
                    if ($v->passes()) {
                        try {
                            DB::beginTransaction();
                            $country = new Country;
                            $country->country_key = $request->country_key;
                            $country->corbiz_key = $request->corbiz_key;
                            $country->default_locale = $request->default_locale;
                            $country->currency_key = $request->currency_key;
                            $country->timezone = $request->timezone;
                            $country->shopping_active = (isset($request->shopping_active) == true) ? $request->shopping_active : 0;
                            $country->inscription_active = (isset($request->inscription_active) == true) ? $request->inscription_active : 0;       
                            $country->flag = $request->flag;
                            $country->webservice=$request->webservice;
                            $country->active = 1;
                           $country->customer_active=(isset($request->admirable_customer) == true) ? $request->admirable_customer : 0; 
       
                            $country->save();
                            $country->languages()->createMany($this->getLenguages($request, $country->id));
                            $traslations = $this->getTraslations($request, $country->id);
                            $country->traslations()->createMany($traslations);

                            DB::commit();
//                            AdminLog::new_log('Country ' . $country->country_key . ' added');

                            return redirect()->route('admin.countries.list');
                        } catch (Exception $e) {
                            DB::rollback();

                            $this->getAdd($e->getMessage());
                        }
                    } else {

                        FormMessage::set($v->messages());
                        $this->getAdd();
                    }
                } else {
                    $mensage = trans('admin::menu.traslates_name');
                    $this->getAdd($mensage);
                }
            } else {
                $mensage = trans('admin::countries.validations');
                $this->getAdd('', $mensage);
            }
        }
    }

    private function validateTraslations($request) {
        $totales = count($request->name_lang);
        $cantidad = 0;
        foreach ($request->name_lang as $name) {
            if ($name == null) {
                $cantidad = $cantidad + 1;
            }
        }
        if ($cantidad < $totales) {
            return true;
        } else {
            return false;
        }
    }

    private function getTraslations($request, $country_id) {
        $country_languages = array();
        if (count($request->name_lang) > 0) {
            $index = 0;
            foreach ($request->name_lang as $name) {
                $languageObj = new CountryTraslationModel();
                $languageObj->setName(($name == null) ? '' : $name);
                $languageObj->setCountry_id($country_id);
                $languageObj->setLocale($request->locale[$index]);
                array_push($country_languages, get_object_vars($languageObj));
                $index = $index + 1;
            }
        }
        return $country_languages;
    }

    private function getLenguages($request, $id_country) {
        if (count($request->languages) > 0) {
            foreach ($request->languages as $language_id) {
                $saveLanguajes[] = ['country_id' => $id_country, 'language_id' => $language_id, 'active' => 1];
            }
            return $saveLanguajes;
        } else {
            return array();
        }
    }

    public function postEdit(Request $request) {
        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                $country = Country::find($request->country_id);
                $country->country_key = $request->country_key;
                $country->default_locale = $request->default_locale;
                $country->currency_key = $request->currency_key;
                $country->timezone = $request->timezone;
                $country->shopping_active = (isset($request->shopping_active) == true) ? $request->shopping_active : 0;
                $country->inscription_active = (isset($request->inscription_active) == true) ? $request->inscription_active : 0;
                $country->customer_active=(isset($request->admirable_customer) == true) ? $request->admirable_customer : 0; 
                $country->flag = $request->flag;
                $country->active = 1;
                $country->corbiz_key = $request->corbiz_key;
                $country->webservice=$request->webservice;
                $country->save();
                $country->languages()->delete();
                $country->languages()->createMany($this->getLenguages($request, $request->country_id));
                $traslations = $this->getTraslations($request, $country->id);
                $country->traslations()->delete();
                $country->traslations()->createMany($traslations);
                DB::commit();
//                AdminLog::new_log('Country  updated');

                return redirect()->route('admin.countries.list');
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->route('admin.countries.list');
            }
//               }else{
//                          $mensage = trans('admin::countries.validations');
//                      $this->getAdd('',$mensage);
//               }
        }
        return null;
    }

    private function getLanguageCountry($countryLand) {

        $bransCountry = array();
        foreach ($countryLand as $country) {
            array_push($bransCountry, $country->language);
        }
        return $bransCountry;
    }

    public function getEdit($countryId = 0, $mensage = "") {
        $country = Country::find($countryId);
        $languageSelected = $this->getLanguageCountry($country->languages);
        $languagesList = Language::where('active', '=', 1)->get();
        $languagesList2 = $this->getTraslationsCountry($country->traslations, $languagesList);   
        $this->layoutData['content'] = View::make('admin::settings.countries.edit', array('languages' => $languagesList,
                    'country' => $country,
                    'languageSelected' => $languageSelected,
                    'traslations' => $languagesList2,
                    'msg' => $mensage,
                    'validacion' => $mensage,
                    'langSelect' => Language::selectArrayActive($languagesList)));
    }

    private function getTraslationsCountry($translations, $languagesList) {

        $data = array();

        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {
                if ($lan->locale_key == $t->locale) {
                    $lan['name'] = $t->name;
                }
            }

            array_push($data, $lan);
        }
        return $data;
    }

    public function activeCountry(Request $request) {
        $country = Country::find($request->countryId);
        if ($country !== null) {
            if ($country->active == true) {
                $country->active = 0;
                $country->save();
                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $country->active = 1;
                $country->save();
                $response = array(
                    'status' => 1,
                    'message' => trans('admin::menu.active')
                );
            }
            return $response;
        } else {
            return "";
        }
    }

    public function delete(Request $request, Country $country) {
        $country->active = 0;
        $country->delete = 1;
        $country->update();

        return redirect()->route('admin.countries.list');
    }
}
