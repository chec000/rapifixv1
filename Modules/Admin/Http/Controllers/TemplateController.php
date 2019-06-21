<?php

namespace Modules\Admin\Http\Controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempletesController
 *
 * @author sergio
 */
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Entities\Language;
//use Modules\CMS\Entities\AdminLog;
use Illuminate\Support\Facades\DB;
use Modules\CMS\Entities\Template;
use Illuminate\Http\Request;
use Validator;
use View;
use Auth;

class TemplateController extends Controller {

    //put your code here

    /*
     * Muestra la vista de agregar template
     */

    public function indexTemplate($message = "") {

        $languagesList = Language::where('active', '=', 1)->get();
        $this->layoutData['content'] = View::make('admin::settings.templates.add', array('languages' => $languagesList,
                    'can_add' => Auth::action('users.add'),
                    'can_delete' => Auth::action('users.delete'),
                    'can_edit' => Auth::action('users.edit'),
                    'msg' => $message
        ));
    }

    /*
     * Muestra la lista de template
     */

    public function listTemplates() {
        $templates = Template::all();
        $this->layoutData['content'] = View::make('admin::settings.templates.list', array('templates' => $templates,
                    'can_add' => Auth::action('template.add'),
                    'can_delete' => Auth::action('template.active'),
                    'can_edit' => Auth::action('template.update'),
        ));
    }

    /*
     * Guarda un  template
     */

    public function addTemplate(Request $request) {

        if ($request->isMethod('post')) {

            $v = Validator::make($request->all(), array(
                        'template' => 'required'
            ));
        }
        $attrNamesTrans = array(
            'template' => trans('admin::template.add_template'),
        );
        $v->setAttributeNames($attrNamesTrans);
        if ($this->validateTraslations($request)) {
            if ($v->passes()) {
                try {
                    DB::beginTransaction();
                    $data = ['active' => 1, 'template' => $request->template,
                        'child_template' => 0, 'hidden' => 0];
                    $template = Template::create($data);
                    $traslates = $this->getTraslatesTemplates($request, $template->id);
                    if (count($traslates) > 0) {
                        $template->traslations()->createMany($traslates);
                    }
                    DB::commit();
//                    AdminLog::new_log('Template \'' . $template->template . '\' added');
                    return redirect()->route('admin.template.list');
                } catch (Exception $ex) {
                    DB::rollback();
                    $this->indexTemplate();
                }
            } else {
                FormMessage::set($v->messages());
                $this->indexTemplate();
            }
        } else {
            $mensage = trans('admin::menu.traslates_name');
            $this->indexTemplate($mensage);
        }
    }

    private function getTraslatesTemplates($request, $id_template) {
        $traslates = array();
        if (count($request->name_lang) > 0) {
            $i = 0;
            foreach ($request->name_lang as $name) {
                $traslate = ['template_id' => $id_template, 'label' => ($name != null) ? $name : '', 'locale' => $request->locale[$i]];
                array_push($traslates, $traslate);
                $i = $i + 1;
            }
        }
        return $traslates;
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

    /*
     * Cambia el estatus de un template
     */

    public function updateTemplate(Request $request) {
        if ($request->isMethod('post')) {

            $v = Validator::make($request->all(), array(
                        'template' => 'required'
            ));
        }
        $attrNamesTrans = array(
            'template' => trans('admin::template.add_template'),
        );
        $v->setAttributeNames($attrNamesTrans);
        if ($this->validateTraslations($request)) {
            if ($v->passes()) {
                try {
                    DB::beginTransaction();
                    $template = Template::find($request->template_id);
                    $template->template = $request->template;
                    $template->traslations()->delete();
                    $traslates = $this->getTraslatesTemplates($request, $request->template_id);
                    $template->traslations()->createMany($traslates);
                    $template->save();
                    DB::commit();
//                    AdminLog::new_log('Template \'' . $template->template . '\' edited');
                    return redirect()->route('admin.template.list');
                } catch (Exception $e) {
                    DB::rollback();
                    $this->getTemplate($request->template_id);
                }
            } else {
                FormMessage::set($v->messages());
                $this->getTemplate($request->template_id);
            }
        } else {
            $message = trans('admin::menu.traslates_name');
            $this->getTemplate($request->template_id, $message);
        }
    }

    public function activateTemplate(Request $request) {
        $template = Template::find($request->template_id);
        if ($template != null) {

            if ($template->active == true) {
                $template->active = 0;
                $template->save();
//                AdminLog::new_log('Template \'' . $template->template . '\' disabled');
                $response = array(
                    'status' => 0,
                    'message' => trans('admin::menu.disabled'),
                );
            } else {
                $template->active = 1;
                $template->save();
//                AdminLog::new_log('Template \'' . $template->item_name . '\' enabled');
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

    /*
     * Obtiene un template
     */

    public function getTemplate($template_id, $message = "") {
        $template = Template::find($template_id);
        $languagesList = Language::where('active', '=', 1)->get();

        $this->getTraslationsByTemplate($template->translations, $languagesList);
        $this->layoutData['content'] = View::make('admin::settings.templates.edit', array('languages' => $languagesList,
                    'can_add' => Auth::action('users.add'),
                    'can_delete' => Auth::action('users.delete'),
                    'can_edit' => Auth::action('users.edit'),
                    'template' => $template,
                    'msg' => $message
        ));
    }

    private function getTraslationsByTemplate($translations, $languagesList) {
        $data = array();
        foreach ($languagesList as $lan) {
            foreach ($translations as $t) {
                if ($lan->locale_key == $t->locale) {
                    $lan['label'] = $t->label;
                }
            }

            array_push($data, $lan);
        }
        return $data;
    }

}
