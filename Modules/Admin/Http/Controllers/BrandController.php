<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Admin\Entities\BrandModel;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Language;
use Image;
use View;
use Validator;
use Auth;
use Modules\CMS\Libraries\Builder\FormMessage;

/**
 * Description of BrandController
 *
 * @author sergio
 */
class BrandController extends Controller {

    public function indexBrand($message = "", $validacion = "") {
        $countries = Country::selectArrayActive();
        $languagesList = Language::where('active', '=', 1)->get();
        $brands = Brand::selectArrayActive();
        $this->layoutData['content'] = View::make('admin::settings.brands.forms.add', array('countries' => $countries,
                    'languages' => $languagesList,
                    'brands' => $brands,
                    'msg' => $message,
                    'can_add' => Auth::action('brand.add'),
                    'can_delete' => Auth::action('bread.activeBrand'),
                    'can_edit' => Auth::action('brand.editBrand'),
                    'validacion' => $validacion,
                    'add' => 1));
    }

    public function showListBrands() {
        $brands = Brand::preloadArray();
        $this->layoutData['modals']  = View::make('admin::shopping.pool.modals.confirm');
        $this->layoutData['content'] = View::make('admin::settings.brands.list', array('brands' => $brands,
                    'can_add' => Auth::action('brand.add'),
                    'can_delete' => Auth::action('bread.activeBrand'),
                    'can_edit' => Auth::action('brand.editBrand'),
                    'can_remove' => Auth::action('brand.delete'),
        ));
    }

//    public function getListBrands() {
//        return json_encode($this->getBrandTraslations());
//    }

    public function saveBrand(Request $request) {
        if ($request->isMethod('post')) {
            if ($request->is_main == 1) {
                $count = Brand::where('is_main', '=', 1)->get()->count();
                if ($count == 0) {
                    $v = Validator::make($request->all(), array(
                                'dominio' => 'required',
                                //'flag' => 'required',
                                //'parent_brand' => 'required'
                    ));
                } else {
                    $mensage = trans('admin::brand.form_add.validation');
                    return $this->indexBrand('', $mensage);
                }
            } else {

                $v = Validator::make($request->all(), array(
                            'dominio' => 'required',
                            'parent_brand' => 'required_if:isPrincipal,1'
                            //'flag' => 'required'
                                )
                );
            }

            $attrNamesTrans = array(
                'dominio' => trans('admin::menu.icon'),
                'flag' => trans('admin::menu.icon'),
                'parent_brand' => trans('admin::brand.form_add.countries')
            );
            $v->setAttributeNames($attrNamesTrans);
//            return json_encode($this->validateTraslations($request));

            if ($this->validateTraslations($request)) {
                if ($v->passes()) {
                    try {
                        DB::beginTransaction();

                        if ($request->parent_brand != null) {
                            $parent = implode(',', $request->parent_brand);
                            $domain = $request->dominio;
                        } else {
                            $parent = 0;
                            $domain = $request->dominio;
                        }

                        $data = ['active' => '1', 'is_main' => ($request->is_main == null) ? 0 : $request->is_main,
                            'favicon' => ($request->flag!=null)?$request->flag:"",
                            'clave' => $request->clave,
                            'parent_brand_id' => $parent,
                            'domain' => $domain,
                            'nombre' => $request->nombre,
                            'paises' => $request->country_id];
                        $brand = Brand::create($data);
                        foreach ($request->country_id as $country) {
                            $saveBrands[] = ['brand_id' => $brand->id, 'country_id' => $country];
                        }
                        $brand->brandCountry()->createMany($saveBrands);
//                    return $this->setBrandLanguages($request, $brand->id);
                        $brand->brandTraslations()->createMany($this->setBrandLanguages($request, $brand->id));
                        $this->setBrandLanguages($request, $brand->id);
                        DB::commit();
                        return redirect()->route('admin.brand.list');
                    } catch (Exception $ex) {
                        DB::rollback();
                        return redirect()->route('admin.brand.list');
                    }
                } else {
                    FormMessage::set($v->messages());
                    $this->indexBrand();
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                $this->indexBrand($mensage);
            }
        }
    }

    private function validateTraslations($request) {
        $totales = count($request->brand_name);
        $cantidad = 0;
        foreach ($request->brand_name as $name) {
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

    public function updataBrand(Request $request) {

        if ($request->isMethod('post')) {
            if ($request->is_main == 1) {
                $brand_local = Brand::where([['is_main', '=', 1],
                                ['id', '=', $request->id_brand]])->get()->count();
                  if ($brand_local == 1) {
                     $count = 0;
                } else {
                    $count = Brand::where('is_main', '=', 1)->get()->count();
                }
             
                if ($count == 0) {
                    $v = Validator::make($request->all(), array(
                                'dominio' => 'required|url',
                                'isPrincipal' => 'required',
                                'id_brand' => 'required',
                                //'flag' => ''
                                    )
                    );
                    $attrNamesTrans = array(
                        'dominio' => trans('admin::brand.form_add.url'),
                        'flag' => trans('admin::countries.add_flag')
                    );
                    $v->setAttributeNames($attrNamesTrans);
                } else {
                    $mensage = trans('admin::brand.form_add.validation');
                    return $this->getBrand($request->id_brand, '', $mensage);
                }
            } else {
                $v = Validator::make($request->all(), array(
                            'dominio' => 'required|url',
                            'isPrincipal' => 'required',
                            'id_brand' => 'required',
                            'flag' => ''
                                )
                );
                $attrNamesTrans = array(
                    'dominio' => trans('admin::brand.form_add.url'),
                    'flag' => trans('admin::countries.add_flag')
                );
                $v->setAttributeNames($attrNamesTrans);
            }

            if ($this->validateTraslations($request)) {
                if ($v->passes()) {
                    try {
                        DB::beginTransaction();
                        if (!is_null($request->parent_brand) && count($request->parent_brand) > 0) {
                            $parent = implode(',', $request->parent_brand);
                            $domain = $request->dominio;
                        } else {
                            $parent = 0;
                            $domain = $request->dominio;
                        }
                        if ($request->dominio !== null) {
                            $domain = $request->dominio;
                        }
                        $brand = Brand::find($request->id_brand);
                        $brand->name = $request->nombre;
                        $brand->domain = $domain;
                        $brand->alias = $request->clave;
                        $brand->is_main=$request->is_main;
                        $brand->active = 1;
                        if ($request->isPrincipal == 0) {
                            $brand->parent_brand_id = 0;
                        } else {
                            $brand->parent_brand_id = $parent;
                        }

                        foreach ($request->country_id as $country) {
                            $saveBrands[] = ['brand_id' => $brand->id, 'country_id' => $country, 'active' => 1];
                        }

                        # Borrar e insertar las relaciones n:m
                        $brand->brandCountry()->delete();
                        $brand->brandCountry()->createMany($saveBrands);

                        # Actualizar traducciones
                        foreach ($request->brand_locale as $i => $locale) {
                            if ($brand->hasTranslation($locale)) {
                                $brand->translate($locale)->name  = $request->brand_name[$i];
                                $brand->translate($locale)->alias = $request->brand_alias[$i];
                                $brand->translate($locale)->logo  = $request->logo[$i];
                            }
                        }

                        #$brand_languages = $this->setBrandLanguages($request, $brand->id);
                        #$brand->brandCountry()->delete();
                        #$brand->brandCountry()->createMany($saveBrands);
                        #$brand->brandTraslations()->delete();
                        #$brand->brandTraslations()->createMany($brand_languages);

                        $brand->save();

                        DB::commit();
                        return redirect()->route('admin.brand.list');
                    } catch (Exception $e) {
                        DB::rollback();
                       FormMessage::set($v->messages());
                    $this->getBrand($request->id_brand);
                    }
                } else {
                    FormMessage::set($v->messages());
                    $this->getBrand($request->id_brand);
                }
            } else {
                $mensage = trans('admin::menu.traslates_name');
                $this->getBrand($request->id_brand, $mensage);
            }
        }
    }

    private function validateFields($request) {
        $data = ['name' => $request->nombre, 'alias' => $request->clave];
        $v = Validator::make($data, array(
                    'is_principal' => 'required|min:3',
                    'alias' => 'dominio',
                        )
        );
        $attrNamesTrans = array(
            'name' => trans('admin::userTranslations.form_add.user_name'),
            'alias' => trans('admin::userTranslations.form_add.user_role'),
        );
        $v->setAttributeNames($attrNamesTrans);
        return $v->passes();
    }

    private function setBrandLanguages($request, $brand_id) {
        $brand_languages = array();
        if (count($request->brand_name) > 0 && count($request->brand_locale) && count($request->brand_alias)) {
            $index = 0;
            foreach ($request->brand_name as $name) {
                $brandObj = new BrandModel();
                $brandObj->name = ($name == null) ? '' : $name;
                $brandObj->brand_id = $brand_id;
                $brandObj->alias = ($request->brand_alias[$index] == null) ? '' : $request->brand_alias[$index];
                $brandObj->locale = $request->brand_locale[$index];
                $brandObj->logo = $request->logo[$index];
                array_push($brand_languages, get_object_vars($brandObj));
                $index = $index + 1;
            }
        }
        return $brand_languages;
    }

    public function activeBrand(Request $request) {

        $brand = Brand::find($request->brand_id);
        if ($brand != null) {
            if ($brand->active == true) {
                $brand->active = 0;
                $brand->save();
                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $brand->active = 1;
                $brand->save();
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

    public function getBrand($id_brand = 0, $message = "", $validacion = "") {
        $brand = Brand::find($id_brand);
        if ($brand != null) {
            $countries = Country::selectArrayActive();
            $countriesSelected = Brand::find($id_brand)->brandCountry;
            $brandSelected = Brand::whereIn('id', explode(',', $brand->parent_brand_id))->get();
            $brands = Brand::selectArrayActive();
            $languagesList = Language::where('active', '=', 1)->get();
            $languagesList2 = $this->getTraslations($brand->brandTraslations, $languagesList);

            $this->layoutData['content'] = View::make('admin::settings.brands.forms.Update', array(
                        'countriesSelected' => array_pluck(
                                $countriesSelected, 'country_id'),
                        'countries' => $countries,
                        'languages' => $languagesList2,
                        'brands' => $brands,
                        'brand' => $brand,
                        'msg' => $message,
                        'validacion' => $validacion,
                        'brandsDependents' => array_pluck($brandSelected, 'id'),
                        'update' => 1));
        } else {
            return redirect()->route('admin.brand.list');
        }
    }

    private function getCountryBrand($countryBrand) {
        $bransCountry = array();
        foreach ($countryBrand as $country) {
            $data = ['id' => $country->country->id, 'name' => $country->country->name];
            array_push($bransCountry, $data);
        }
        return array_pluck($bransCountry, 'name', 'id');
    }

    private function getTraslations($translations, $languagesList) {
        $data = array();

        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {
                if ($lan->locale_key == $t->locale) {
                    $lan['name'] = $t->name;
                    $lan['alias'] = $t->alias;
                    $lan['logo']=$t->logo;
                }
            }

            array_push($data, $lan);
        }
        return $data;
    }

    public function delete(Request $request, Brand $brand) {
        $brand->active = 0;
        $brand->delete = 1;
        $brand->update();

        return redirect()->route('admin.brand.list');
    }
}
