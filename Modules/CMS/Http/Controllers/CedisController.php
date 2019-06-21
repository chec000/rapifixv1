<?php

namespace Modules\CMS\Http\Controllers;

use App\Helpers\RestWrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\Cedis;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Language;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use PageBuilder;
use Response;
use View;

class CedisController extends Controller
{
    var $brand;
    var $currentLang;
    var $currentCountryId;

    var $cedisCountryKey;
    var $cedisStateKey;

    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request) {
        $this->defineLocalVars($request);

        $allCedis = $this->getCedis();
        $countries = Country::where('active', 1)
            ->get();

        $country  =  Country::find($this->currentCountryId);
        $language = Language::where('locale_key', $this->currentLang)->first();

        if (!empty($this->cedisCountryKey) && $this->cedisCountryKey != $country->corbiz_key) {
            return redirect()->route('cedis.index');
        }

        $countryKey = empty($this->cedisCountryKey) ? $country->corbiz_key : $this->cedisCountryKey;
        $response = $this->getStatesFromCorbiz($country->webservice, $countryKey, $language->corbiz_key);

        $data = [];
        foreach ($response['data'] as $city) {
            if (Cedis::belongToCity($this->currentCountryId, $city['id'])) {
                $data[] = $city;
            }
        }

        $response['data'] = $data;

        return View::make('cms::frontend.cedis.index', [
            'brand'            => $this->brand,
            'allCedis'         => $allCedis,
            'countries'        => $countries,
            'response'         => $response,
            'currentLang'      => $this->currentLang,
            'currentCountryId' => $this->currentCountryId,
            'cedisCountryKey'  => $this->cedisCountryKey,
            'cedisStateKey'    => $this->cedisStateKey,
            'countryKey'       => $country->corbiz_key
        ]);
    }

    public function detail($slug) {
        $this->defineLocalVars();

        $cedis = Cedis::whereTranslation('slug', $slug)->first();
        if ($cedis == null || $cedis->status == 0 || $cedis->delete == 1) {
            abort(404);
        }

        return View::make('cms::frontend.cedis.detail', [
            'brand'       => $this->brand,
            'currentLang' => $this->currentLang,
            'cedis'       => $cedis,
        ]);
    }

    private function defineLocalVars($request = null) {
        if ($request != null && $request->input('country') != null) {
            $this->cedisCountryKey = $request->input('country');
        }

        if ($request != null && $request->input('city') != null) {
            $this->cedisStateKey = $request->input('city');
        }

        $portal = Session::get('portal');
        if (is_array($portal) && isset($portal['main'])) {
            if (isset($portal['main']['app_locale'])) {
                $this->currentLang = $portal['main']['app_locale'];
            } else {
                $this->currentLang = 'en';
            }

            if (isset($portal['main']['country_id'])) {
                $this->currentCountryId = (int) $portal['main']['country_id'];
            }
        }

        $this->brand = 'omnilife';
    }

    private function getCedis() {
        $allCedis = $this->getCedisByUrlParams();
        if ($allCedis == null) {
            $allCedis = $this->getCedisBySessionParams();
        }

        return $allCedis;
    }

    private function getCedisByUrlParams() {
        $allCedis = null;

        if ($this->cedisCountryKey != null) {
            $country = Country::where('corbiz_key', $this->cedisCountryKey)->first();

            if ($country != null) {
                $lang = $this->currentLang;

                if ($this->cedisStateKey != null) {
                    $allCedis = Cedis::select('glob_cedis.*')
                        ->join('glob_cedis_translations as ct', function ($q) use ($lang) {
                            $q->on('glob_cedis.id', '=', 'ct.cedis_id')
                                ->where('ct.locale', '=', $lang);
                        })
                        ->where('status', 1)
                        ->where('delete', 0)
                        ->where('country_id', $country->id)
                        ->where('state_key', $this->cedisStateKey)
                        ->orderBy('ct.name', 'ASC')
                        ->paginate(8);
                } else {
                    $allCedis = Cedis::select('glob_cedis.*')
                        ->join('glob_cedis_translations as ct', function ($q) use ($lang) {
                            $q->on('glob_cedis.id', '=', 'ct.cedis_id')
                                ->where('ct.locale', '=', $lang);
                        })
                        ->where('status', 1)
                        ->where('delete', 0)
                        ->where('country_id', $country->id)
                        ->orderBy('ct.name', 'ASC')
                        ->paginate(8);
                }
            }
        }

        return $allCedis;
    }

    private function getCedisBySessionParams() {
        $lang = $this->currentLang;

        if ($this->currentCountryId == null) {
            $allCedis = Cedis::select('glob_cedis.*')
                ->join('glob_cedis_translations as ct', function ($q) use ($lang) {
                    $q->on('glob_cedis.id', '=', 'ct.cedis_id')
                        ->where('ct.locale', '=', $lang);
                })
                ->where('status', 1)
                ->where('delete', 0)
                ->orderBy('ct.name', 'ASC')
                ->paginate(8);
        } else {
            $allCedis = Cedis::select('glob_cedis.*')
                ->join('glob_cedis_translations as ct', function ($q) use ($lang) {
                    $q->on('glob_cedis.id', '=', 'ct.cedis_id')
                        ->where('ct.locale', '=', $lang);
                })
                ->where('status', 1)
                ->where('country_id', $this->currentCountryId)
                ->where('delete', 0)
                ->orderBy('ct.name', 'ASC')
                ->paginate(8);
        }

        return $allCedis;
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
            foreach ($responseWS['responseWS']['response']['State']['dsState']['ttState'] as $state) {
                $response['data'][] = ['id' => trim($state['idState']), 'name' => trim($state['stateDescr'])];
            }

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

        return $response;
    }
}
