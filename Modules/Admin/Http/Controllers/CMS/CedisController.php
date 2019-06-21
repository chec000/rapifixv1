<?php

namespace Modules\Admin\Http\Controllers;

use App\Helpers\RestWrapper;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\Language;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Admin\Entities\Cedis;

use Modules\Admin\Entities\Country;
use Modules\Admin\Http\Requests\SaveCedisRequest;
use View;
use Auth;
use Validator;

class CedisController extends Controller
{
    /**
     * Listado de CEDIS
     * @return Response
     */
    public function index()
    {
        $currentLang = Auth::user()->language->locale_key;
        $allCedis    = Cedis::whereIn('country_id', User::userCountriesPermission())->where('delete', 0)->orderBy('id', 'DESC')->get();

        $this->layoutData['modals']  = View::make('admin::shopping.products.modals.confirm');
        $this->layoutData['content'] = View::make('admin::cms.cedis.index', [
            'countries'   => Country::selectArrayActive(),
            'allCedis'    => $allCedis,
            'currentLang' => $currentLang,
        ]);
    }

    /**
     * Formulario para registrar un nuevo CEDIS
     * @return Response
     */
    public function add()
    {
        $countries   = Country::where('active', 1)->whereIn('id', User::userCountriesPermission())->get();
        $languages   = Language::where('active', 1)->get();
        $currentLang = Session::get('adminLocale');

        $this->layoutData['content'] = View::make('admin::cms.cedis.add', [
            'countries'   => $countries,
            'languages'   => $languages,
            'currentLang' => $currentLang
        ]);
    }

    /**
     * Guardar un CEDIS
     * @param  SaveCedisRequest $request
     * @return Response
     */
    public function save(SaveCedisRequest $request) {
        $input      = $request->all();
        $translates = $input['translate'];

        if (empty($input['country'])) {
            $request->session()->flash('error', [trans('admin::cedis.validation.country'),]);
            return redirect()->route('admin.cedis.add');
        }

        $cedis                  = new Cedis();
        $cedis->global_name     = $input['global_name'];
        $cedis->address         = $input['address'];
        $cedis->country_id      = $input['country'];
        $cedis->neighborhood    = $input['neighborhood'];
        $cedis->postal_code     = $input['postal_code'];
        $cedis->phone_number_01 = $input['phone_number_01'];
        $cedis->phone_number_02 = $input['phone_number_02'];
        $cedis->telemarketing   = $input['telemarketing'];
        $cedis->fax             = $input['fax'];
        $cedis->email           = $input['email'];
        $cedis->latitude        = $input['latitude'];
        $cedis->longitude       = $input['longitude'];
        $cedis->image_01        = $input['image_01'];
        $cedis->image_02        = $input['image_02'];
        $cedis->image_03        = $input['image_03'];
        $cedis->banner_link     = $input['banner_link'];
        $cedis->status          = 1;
        $cedis->delete          = 0;

        foreach ($translates as $locale => $translate) {
            if ($translate['name'] != null) {
                $cedis->translateOrNew($locale)->name = $translate['name'];
                $cedis->translateOrDefault($locale)->slug = str_slug($translate['name'], '-', $locale);
            }

            if ($translate['description'] != null) {
                $cedis->translateOrNew($locale)->description = $translate['description'];
            }

            if ($translate['state'] != null) {
                $cedis->translateOrNew($locale)->state_name = $translate['state_name'];
                $cedis->state_key = $translate['state'];
            }

            if ($translate['city'] != null) {
                $cedis->translateOrNew($locale)->city_name = $translate['city_name'];
                $cedis->city_key = $translate['city'];
            }

            if ($translate['schedule'] != null) {
                $cedis->translateOrNew($locale)->schedule = $translate['schedule'];
            }

            if ($translate['banner'] != null) {
                $cedis->translateOrNew($locale)->banner_image = $translate['banner'];
            }
        }

        $cedis->save();
        $request->session()->flash('success', trans('admin::cedis.add.success_save'));

        return redirect()->route('admin.cedis.index');
    }

    /**
     * Formulario para editar un CEDIS
     * @return Response
     */
    public function edit(Cedis $cedis) {
        $countries   = Country::whereIn('id', User::userCountriesPermission())->where('active', 1)->get();
        $languages   = Language::where('active', 1)->get();
        $currentLang = Session::get('adminLocale');

        $states = $this->getStatesFromCorbiz($cedis->country->webservice, $cedis->country->corbiz_key, Language::where('locale_key', $currentLang)->first()->corbiz_key);
        $cities = [];
        foreach ($cedis->country->languages as $countryLang) {
            $cities[$countryLang->language->locale_key] = $this->getCitiesFromCorbiz($cedis->country->webservice, $cedis->state_key, $cedis->country->corbiz_key, $countryLang->language->corbiz_key);
        }

        $this->layoutData['content'] = View::make('admin::cms.cedis.edit', [
            'countries'   => $countries,
            'languages'   => $languages,
            'currentLang' => $currentLang,
            'cedis'       => $cedis,
            'cities'      => $cities,
            'states'      => $states
        ]);
    }

    /**
     * Actualizar la información de un CEDIS
     * @param  SaveCedisRequest $request
     * @param  Cedis $cedis
     * @return Response
     */
    public function update(SaveCedisRequest $request, Cedis $cedis) {
        $input      = $request->all();
        $translates = $input['translate'];

        $cedis->global_name     = $input['global_name'];
        $cedis->address         = $input['address'];
        $cedis->neighborhood    = $input['neighborhood'];
        $cedis->postal_code     = $input['postal_code'];
        $cedis->phone_number_01 = $input['phone_number_01'];
        $cedis->phone_number_02 = $input['phone_number_02'];
        $cedis->telemarketing   = $input['telemarketing'];
        $cedis->fax             = $input['fax'];
        $cedis->email           = $input['email'];
        $cedis->latitude        = $input['latitude'];
        $cedis->longitude       = $input['longitude'];
        $cedis->image_01        = $input['image_01'];
        $cedis->image_02        = $input['image_02'];
        $cedis->image_03        = $input['image_03'];
        $cedis->banner_link     = $input['banner_link'];
        $cedis->status          = 1;
        $cedis->delete          = 0;

        foreach ($translates as $locale => $translate) {
            if ($translate['name'] != null) {
                $cedis->translateOrNew($locale)->name = $translate['name'];
                $cedis->translateOrDefault($locale)->slug = str_slug($translate['name'], '-', $locale);
            }

            $cedis->translateOrNew($locale)->description = $translate['description'];

            if ($translate['state'] != null) {
                $cedis->translateOrNew($locale)->state_name = $translate['state_name'];
                $cedis->state_key = $translate['state'];
            }

            if ($translate['city'] != null) {
                $cedis->translateOrNew($locale)->city_name = $translate['city_name'];
                $cedis->city_key = $translate['city'];
            }

            if ($translate['schedule'] != null) {
                $cedis->translateOrNew($locale)->schedule = $translate['schedule'];
            }

            $cedis->translateOrNew($locale)->banner_image = $translate['banner'];
        }

        $cedis->update();
        $request->session()->flash('success', trans('admin::cedis.add.success_update'));

        return redirect()->route('admin.cedis.edit', $cedis);
    }

    /**
     * Eliminar un CEDIS
     * @return Response
     */
    public function delete(Request $request, Cedis $cedis) {
        $cedis->delete = 1;
        $cedis->update();

        $request->session()->flash('success', trans('admin::cedis.add.success_delete'));

        return redirect()->route('admin.cedis.index');
    }

    public function changeStatus(Request $request) {
        $response = ['status' => false];

        if ($request->ajax() && $request->has('id') && $request->has('type')) {
            $cedis = Cedis::find($request->input('id'));

            if ($request->input('type') == 'activate') {
                $cedis->status = 1;
            } else if ($request->input('type') == 'deactivate') {
                $cedis->status = 0;
            } else {
                $response['error'] = trans('admin::cedis.errors.not_params');
            }
            $cedis->update();
            $response['status'] = true;

        } else {
            $response['error'] = trans('admin::cedis.errors.not_params');
        }

        return $response;
    }

    /**
     * getStates
     * Método que valida los parámetros para obtener los estados por país y por sus idiomas correspondientes desde corbiz
     *
     * @param Request $request
     * @return JSON
     */
    public function getStates(Request $request) {
        $response = [];

        if ($request->has('country_id')) {
            $countryId = $request->input('country_id');
            $country = Country::find($countryId);

            $statesByLang = [];
            foreach ($country->languages as $countryLang) {
                $statesByLang[$countryLang->language_id] = [
                    'lang'   => $countryLang->language->locale_key,
                    'corbiz' => $this->getStatesFromCorbiz($country->webservice, $country->corbiz_key, $countryLang->language->corbiz_key)
                ];
            }

            $response['data'] = $statesByLang;
        }

        return json_encode($response);
    }

    /**
     * getCities
     * Método que valida los parámetros para obtener las ciudades por país, estado e idioma desde corbiz
     *
     * @param Request $request
     * @return JSON
     */
    public function getCities(Request $request) {
        $response = [];

        if ($request->has('country_id') && $request->has('state_key') && $request->has('lang')) {
            $countryId = $request->input('country_id');
            $stateKey  = $request->input('state_key');
            $lang      = $request->input('lang');

            $country  = Country::find($countryId);
            $language = Language::where('locale_key', $lang)->first();

            $response['data'] = [
                'lang'   => $lang,
                'corbiz' => $this->getCitiesFromCorbiz($country->webservice, $stateKey, $country->corbiz_key, $language->corbiz_key)
            ];
        }

        return json_encode($response);
    }


    /**
     * getStatesFromCorbiz
     * Realiza la petición del método getState a corbiz y se formatea su respuesta
     *
     * @param $ws           URL del webservice
     * @param $countryKey   Clave del país de corbiz
     * @param $lang         Clave del idioma de corbiz
     * @return array        Respuesta de la petición
     */
    private function getStatesFromCorbiz($ws, $countryKey, $lang) {
        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}getState?CountryKey={$countryKey}&Lang={$lang}");
        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['State']['dsState']['ttState'])) {
            $response['status'] = true;
            $response['data']   = $responseWS['responseWS']['response']['State']['dsState']['ttState'];
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                    '<i>'.$responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messTech'].'</i>'
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('cms::cedis.errors.404')];
                }
            }
        }

        $response['data'] = array_map(function ($state) {
            return ['idState' => trim($state['idState']), 'stateDescr' => trim($state['stateDescr'])];
            }, $response['data']);

        return $response;
    }

    /**
     * getCitiesFromCorbiz
     * Realiza la petición del método getCity a corbiz y se formatea su respuesta
     *
     * @param $ws           URL del webservice
     * @param $stateKey     Clave del estado de corbiz
     * @param $countryKey   Clave del país de corbiz
     * @param $lang         Clave del idioma de corbiz
     * @return array        Respuesta de la petición
     */
    private function getCitiesFromCorbiz($ws, $stateKey, $countryKey, $lang) {
        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}getCity?CountryKey={$countryKey}&Lang={$lang}&StateKey={$stateKey}");
        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['City']['dsCity']['ttCity'])) {
            $response['status'] = true;
            $response['data']   = $responseWS['responseWS']['response']['City']['dsCity']['ttCity'];
        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                    '<i>'.$responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messTech'].'</i>'
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('cms::cedis.errors.404')];
                }
            }
        }

        $response['data'] = array_map(function ($state) {
            return ['idCity' => trim($state['idCity']), 'cityDescr' => trim($state['cityDescr'])];
        }, $response['data']);

        return $response;
    }
}
