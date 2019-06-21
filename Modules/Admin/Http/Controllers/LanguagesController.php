<?php namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\LanguageTranslation;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use View;
use Auth;
use Validator;
use Request;
//use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Libraries\Builder\FormMessage;


class LanguagesController extends Controller
{

    public function getIndex()
    {
        $languagesList = Language::where('delete', 0)->orderBy('active','desc')->get();
        $this->layoutData['modals']  = View::make('admin::modals.general.delete_item').View::make('admin::shopping.pool.modals.confirm');
        $this->layoutData['content'] = View::make('admin::settings.languages.list', array('languages' => $languagesList));
    }

    public function getAdd()
    {
          $languagesList = Language::where('active','=',1)->get();
          $this->layoutData['content'] = View::make('admin::settings.languages.form', array('languages' => $languagesList));
    }

    public function postAdd()
    {
        //$authUser = Auth::user();
        $v = Validator::make(Request::all(), array(
                'locale_key' => 'required|min:2|unique:'.(new Language)->getTable(),
                'corbiz_key' => 'required|min:3|unique:'.(new Language)->getTable(),
                'language' => 'required',
                'language_country' => 'required'
            )
        );

        $attrNamesTrans = array(
            'locale_key' => trans('admin::language.lang_add_key'),
            'corbiz_key' => trans('admin::language.lang_add_corbizkey'),
            'language' => trans('admin::language.lang_add_name'),
            'language_country' => trans('admin::language.lang_add_country'),
        );
        $v->setAttributeNames($attrNamesTrans);

        /*$perm_issue = true;
        $role = UserRole::find(Request::input('role'));
        if (!empty($role) && $role->admin <= $authUser->role->admin) {
            $perm_issue = false;
        }*/

        if ($v->passes()) {
            $data_lang = [];
            $locale_lang = Request::input('locale_lang');
            $language_lang = Request::input('language_lang');
            $language_country_lang = Request::input('language_country_lang');

            $data_newlang = [
                'locale_key' => Request::input('locale_key'),
                'corbiz_key' => Request::input('corbiz_key'),
                'active' => 1,
            ];
            $data_lang[trim(Request::input('locale_key'))] = ['language' => Request::input('language'), 'language_country' => Request::input('language_country')];
            if(count($locale_lang) > 0){
                foreach ($locale_lang as $pos => $locale){
                    if(!empty($language_lang[$pos]) || !empty($language_country_lang[$pos])) {
                        $data_lang[trim($locale)] = ['language' => $language_lang[$pos], 'language_country' => $language_country_lang[$pos]];
                    }
                }
            }

            $new_lang = Language::create($data_newlang);
            foreach ($data_lang as $locale => $data) {
                $new_lang->translateorNew($locale)->language = $data['language'];
                $new_lang->translateorNew($locale)->language_country = $data['language_country'];
                $new_lang->save();
            }

//            AdminLog::new_log('Language \'' . $new_lang->locale_key . '\' added');

            $languagesList = Language::where('active', '=', 1)->get();
            $this->layoutData['content'] = View::make('admin::settings.languages.list', array(
                'success' => true,
                'action' => 'add',
                'lang' => $new_lang->locale_key,
                'languages' => $languagesList));
        } else {
            FormMessage::set($v->messages());
            /*if ($perm_issue) {
                FormMessage::add('role', 'Don\'t have permission to create user with this role, or doesn\'t exist');
            }*/
            $this->getAdd();
        }
    }

    public function postEdit($langId = 0, $action = null)
    {
        $lang = Language::find($langId);
        if (!empty($lang)) {

            switch ($action) {
                case 'status':
                    $v = Validator::make(Request::all(), array(
                            'set' => 'integer|min:0|max:1'
                        )
                    );
                    if ($v->passes()) {
                        $lang->active = Request::input('set');
                        $lang->save();
//                        AdminLog::new_log('Language \'' . $lang->locale_key . '\' updated, status changed');
                        return 1;
                    }
                    return 0;
                    break;
                default:
                    $v = Validator::make(Request::all(), array('corbiz_key' => 'required|min:3|unique:'.(new Language)->getTable().',corbiz_key,'.$lang->id,));
                    $attrNamesTrans = array('corbiz_key' => trans('admin::language.lang_add_corbizkey'),);
                    $v->setAttributeNames($attrNamesTrans);
                    if ($v->passes()) {
                        $lang->corbiz_key = Request::input('corbiz_key');
                        $lang->save();
                        $locale_lang = Request::input('locale_lang');
                        $language_lang = Request::input('language_lang');
                        $language_country_lang = Request::input('language_country_lang');

                        if (count($locale_lang) > 0) {
                            foreach ($locale_lang as $pos => $locale) {
                                if (!empty($language_lang[$pos]) || !empty($language_country_lang[$pos])) {
                                    if ($lang->hasTranslation($locale)) {
                                        $lang->translate($locale)->language = $language_lang[$pos];
                                        $lang->translate($locale)->language_country = $language_country_lang[$pos];
                                        $lang->save();
                                    } else {
                                        $lang->translateorNew($locale)->language = $language_lang[$pos];
                                        $lang->translateorNew($locale)->language_country = $language_country_lang[$pos];
                                        $lang->save();
                                    }
                                }
                            }
                        }

//                        AdminLog::new_log('Language \'' . $lang->locale_key . '\' edited');

                        $languagesList = Language::orderBy('active', 'desc')->get();
                        $this->layoutData['content'] = View::make('admin::settings.languages.list', array(
                            'success' => true,
                            'action' => 'edit',
                            'lang' => $lang->locale_key,
                            'languages' => $languagesList));
                    }
            }
        }
        return null;
    }

    public function getEdit($langId = 0)
    {
        $lang = Language::find($langId);

        //dd($lang->getTranslationsArray());
        if (!empty($lang)) {
            $languagesList = Language::where('active', '=', 1)->get();
            $this->layoutData['content'] = View::make('admin::settings.languages.form', array('langEdit' => $lang, 'languages' => $languagesList));
        } else {
            $this->layoutData['content'] = trans('admin::language.lang_notfound');
        }
    }

    public function delete(Request $request, Language $lang) {
        $lang->active = 0;
        $lang->delete = 1;
        $lang->update();

        return redirect()->route('admin.languages.list');
    }
}
    