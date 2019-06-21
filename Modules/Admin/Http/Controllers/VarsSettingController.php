<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Setting;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use View;
use Auth;
use Validator;
use Request;
use Session;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Entities\Country;
use Modules\CMS\Entities\Template;
use Modules\CMS\Entities\BlockSelectOption;
use Modules\CMS\Entities\BlockCategory;
use Modules\Admin\Entities\ACL\AdminAction;
use Modules\Admin\Entities\ACL\AdminController;
use Modules\Admin\Entities\ACL\AdminMenu;
use Modules\CMS\Entities\Block;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\Language;

class VarsSettingController extends Controller {

    public function getSettings() {
        $varsList = Setting::where('active', 1)->get();
        $this->layoutData['content'] = View::make('admin::settings.vars.list', array(
                    'vars' => $varsList,
                    'can_save' => Auth::action('vars.save'),
                    'can_delete' => Auth::action('vars.delete')
        ));
    }

    public function postSettings() {
        $request = Request::all();
        $validator = Validator::make($request, array(
                    'name' => 'required|array',
                    'value' => 'required|array',
                    'label' => 'required|array'
                ));
        if ($validator->passes()) {
            foreach ($request['name'] as $key => $value) {
                for ($i = 0; $i < count($request['name']); $i++) {
                    if ($value == $request['name'][$i] && $request['id'][$key] != $request['id'][$i]) {
                        Session::flash('error', trans('admin::vars.vars_update_error') . $value);
                        return back();
                    }
                }
            }

            for ($i = 0; $i < count($request['id']); $i++) {
                if (isset($request['id'][$i]) && $request['id'][$i] > 0) {
                    $setting = Setting::where('id', $request['id'][$i])->first();
                    $setting->name = $request['name'][$i];
                    $setting->value = $request['value'][$i];
                    $setting->label = $request['label'][$i];
                    $setting->save();
                } else {
                    $name = $request['name'][$i];
                    if (isset($name) && $name !== '') {
                        Setting::create([
                            'name' => $name,
                            'value' => $request['value'][$i],
                            'label' => $request['label'][$i],
                            'editable' => 1,
                            'hidden' => 0,
                            'active' => 1,
                        ]);
                    }
                }
            }
            Session::flash('message', trans('admin::vars.vars_update_success'));
            return back();
        } else {
            FormMessage::set($validator->messages());
        }
    }

    public function deleteSettings() {
        $request = Request::all();
        $setting = Setting::find($request['id']);
        $setting->active = 0;
        $setting->save();
        return response('ok', 200);
    }

    public function uploadFileSVG() {

        try {
            $archivo = getcwd() . "\uploads\documents\Traducciones_Portal_ENG.csv";
            set_time_limit(0);
            if (($fp = fopen($archivo, "r")) !== FALSE) {

                $allLanguages = array("en", "es", "pt", "it", "ru");
                $languages = "es";
                while (($datos = fgetcsv($fp, 1000)) !== FALSE) {
                    if ($datos[0] != "Tabla") {
                        if ($datos[8] == "Si") {

                            foreach ($allLanguages as $lan) {
                                switch ($lan) {
                                    case "en":
                                        $this->getTypeModel($datos, $lan, $datos[3]);

                                    case "es":
                                        $this->getTypeModel($datos, $lan, $datos[4]);

                                        break;
                                    case "pt":
                                        $this->getTypeModel($datos, $lan, $datos[5]);
                                        break;
                                    case "it":
                                        $this->getTypeModel($datos, $lan, $datos[6]);

                                        break;
                                    case "ru":
                                        $this->getTypeModel($datos, $lan, $datos[7]);

                                        break;
                                    default:
                                        $this->getTypeModel($datos, $lan, "");

                                        break;
                                }
                            }
                        } else {
                            $this->getTypeModel($datos, $languages, $datos[4]);
                        }
                        $this->layoutData['content'] =  trans('admin::vars.var_add_transtable');
                    }
                }
                fclose($fp);
            }
        } catch (Exception $ex) {
                        $this->layoutData['content'] = $ex->getMessage();
            
        }
    }

    private function getTypeModel($type, $lan, $traslate) {

        switch ($type[0]) {
            case "cms_block_category_translations":
                $block = BlockCategory::find($type[1]);                
                $block->translateOrNew($lan)->{$type[2]} = $traslate;               
                $block->save();
                break;
            case "cms_block_translations":
                $block = Block::find($type[1]);
                $block->translateOrNew($lan)->{$type[2]} = $traslate;
                $block->save();
                break;
            case "cms_block_selectopts":
                $option = BlockSelectOption::where([['block_id', '=', $type[1]],
                                ['locale', '=', $lan],
                                ['active', '=', 1]
                        ])->count();

                $this->saveOptions($option, $traslate, $lan, $type);

                break;
            case "cms_template_translations";
                $template = Template::find($type[1]);
                $template->translateOrNew($lan)->{$type[2]} = $traslate;
                $template->save();

                break;
            case "glob_admin_action_translations":
                $action = AdminAction::find($type[1]);
                $action->translateOrNew($lan)->{$type[2]} = $traslate;
                $action->save();
                break;
            case "glob_admin_controller_translations":
                $controller = AdminController::find($type[1]);
                $controller->translateOrNew($lan)->{$type[2]} = $traslate;
                $controller->save();
                break;
            case "glob_admin_menu_translations":
                $menu = AdminMenu::find($type[1]);
                $menu->translateOrNew($lan)->{$type[2]} = $traslate;
                $menu->save();
                break;
            case "glob_brand_translations":
                $brand = Brand::find($type[1]);
                if ($type[2] == "name") {
                    $brand->translateOrNew($lan)->{$type[2]} = $traslate;
                } else {
                    $brand->translateOrNew($lan)->{$type[2]} = $type[4];
                }

                $brand->save();
                break;
            case "glob_country_translations":

                $country = Country::find($type[1]);
                $country->translateOrNew($lan)->{$type[2]} = $traslate;
                $country->save();
                break;
            case "glob_language_translations":
                $language = Language::find($type[1]);
                $language->translateOrNew($lan)->{$type[2]} = $traslate;
                $language->translateOrNew($lan)->language_country = $traslate;
                $language->save();
                break;
            default :
                return null;
        }
    }

    private function saveOptions($option, $traslate, $lan, $type) {
        if ($option == 0) {
            $option = BlockSelectOption::where([['block_id', '=', $type[1]], ['active', '=', 1],['option','=',$type[3]]])->first();
        
            if ($option != null) {
                $newOption = $option->replicate();
                $newOption->option = $traslate;
                $newOption->locale = $lan;
                $newOption->save();
            }
        } else {
            $optAux = BlockSelectOption::where([['block_id', '=', $type[1]], ['option', '=', $traslate], ['locale', '=', $lan],['active','=',1]])->get();                         
            if (!count($optAux) > 0) {
                $opttionExt = BlockSelectOption::where([['block_id', '=', $type[1]], ['option', '=', $type[3]],['active','=',1]])->first();                       
                if ($opttionExt != null) {
                    $newOption = $opttionExt->replicate();          
                    $newOption->option = $traslate;
                    $newOption->locale = $lan;
                    $newOption->save();
                }
            }
        }
    }
    


}

