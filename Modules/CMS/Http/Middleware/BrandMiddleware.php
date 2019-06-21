<?php

namespace Modules\CMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\CountryLanguage;
use Modules\CMS\Entities\Share;
use Modules\Shopping\Entities\WarehouseCountry;

class BrandMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        //get current URL
        $url = $this->getValidUrl($request->url());
        //compare last domain
        $urlHost = parse_url($url, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $urlHost);

        $share = $request->input('share');        
        if (isset($share)) {
            $this->share($share, $url);
        }        
        if (Session::get('portal.main.domain') != $domain) {
            //set new domain
            $this->setBrandSession($domain);
           
            Session::put('portal.main.domain', $domain);
        }
        
        if (\Session::has('portal.main.app_locale')) {
             \App::setLocale(\Session::get('portal.main.app_locale'));
        }

        // if it's home route don't redirect
        $urlStart = url('/start');        
    
        if ($url !== $urlStart) {
            $countries = Session::get('portal.main.brand.countries');            
            $brandInCountry = false;
            if (!empty($countries)) {
                $currentCountryId = Session::get('portal.main.country_id', 0);
                foreach($countries as $country){
                    if ($country->id == $currentCountryId) {
                        $brandInCountry = true;
                        break;
                    }
                }
            }
            if (!$brandInCountry
                || !Session::has('portal.main.country_id') || !Session::has('portal.main.language_id')
                || (config('settings::frontend.webservices') == 1
                && (session()->get("portal.main.shopping_active", 0) == 1)
                && (!Session::has('portal.main.corbiz_warehouse') || empty(Session::has('portal.main.corbiz_warehouse'))))) {

                if (!$brandInCountry) {
                    session()->put('portal.main.brand_not_in_country', 1);
                }
                Session::forget('portal.main.language_id');
                if(!session()->has('portal.main.changeCountryURL')){
                    session()->put('portal.main.changeCountryURL', $url);
                }
                return redirect('/start');
            }

            session()->forget('portal.main.changeCountryId');
            session()->forget('portal.main.changeLanguageId');
            session()->forget('portal.main.booleanChangeCountry');
            session()->forget('portal.main.useGeolocalization');
        }

        //Code for redirect to URL request where change country
        if (Session::has('portal.main.country_id') && Session::has('portal.main.language_id')){
            $redirectCountryChangeURL = (session()->has('portal.main.changeCountryURL') && session()->get('portal.main.changeCountryURL') != "/")
                ? session()->get('portal.main.changeCountryURL') : 0;
            if($redirectCountryChangeURL !== 0) {
                session()->forget('portal.main.changeCountryURL');
                return redirect($redirectCountryChangeURL);
            }
        }

        $config_active_country = country_config(session()->get('portal.main.country_corbiz'));
        if($config_active_country != false){
            session()->put('portal.main.shopping_active', !$config_active_country['shopping_active'] ? 0 : 1);
            session()->put('portal.main.inscription_active', !$config_active_country['inscription_active'] ? 0 : 1);
            session()->put('portal.main.customer_active', !$config_active_country['customer_active'] ? 0 : 1);
        } else {
            session()->put('portal.main.shopping_active', 0);
            session()->put('portal.main.inscription_active', 0);
            session()->put('portal.main.customer_active', 0);
        }
        //session()->put('portal.main.shopping_active', !country_config(session()->get('portal.main.country_corbiz'))['shopping_active'] ? 0 : 1);

        return $next($request);
    }

    public function setBrandSession($domain)
    {
        $brand = Brand::where('domain', 'like', '%'.$domain.'%')->where('active', 1)->first();        
        if ($brand == null) {
            $brand = Brand::where('is_main', 1)->where('active', 1)->first();
        }
        // se agregaron datos a la marca
        $brand = $brand == null ?  Brand::find(config('settings::session.brand.id', config('constants.BRAND_ID')))->first() : $brand;
        //dd(config('settings::session.brand.id'), $brand);
        Session::put('portal.main.brand.id', $brand->id);
        Session::put('portal.main.brand.domain', $brand->domain);
        Session::put('portal.main.brand.parent_brand_id', $brand->parent_brand_id);
        Session::put('portal.main.brand.is_main', $brand->is_main);
        Session::put('portal.main.brand.favicon', $brand->favicon);
        Session::put('portal.main.brand.logo', $brand->logo);
        Session::put('portal.main.brand.name', strtolower($brand->name));
        Session::forget('portal.main.brand.countries');
        foreach ($brand->countries as $country) {
            Session::push('portal.main.brand.countries', $country);
        }
        $this->getVariablesMenuSession();
    }

    public function getVariablesMenuSession(){

        session()->forget('portal.main.varsMenu.otherBrands');
        if(!empty(Session::get('portal.main.brand.id'))){
            $brands = Brand::select('glob_brands.*')
                ->join('glob_brand_countries', 'glob_brand_countries.brand_id', '=', 'glob_brands.id')
                ->where('glob_brand_countries.active', '=', 1)
                ->where('glob_brand_countries.country_id', '=', Session::get('portal.main.country_id'))
                ->where('glob_brands.id', '<>', Session::get('portal.main.brand.id'))
                ->where('glob_brands.active', '=', 1)
                ->orderBy('glob_brands.id', 'ASC')
                ->get();
            session()->put('portal.main.varsMenu.otherBrands',$brands);
        }

        session()->forget('portal.main.varsMenu.parentBrands');
        if(!empty(Session::get('portal.main.brand.parent_brand_id'))){
            $explode_id = array_map('intval', explode(',',  Session::get('portal.main.brand.parent_brand_id')));
            $parentBrands =  Brand::select('glob_brands.*')
                ->join('glob_brand_countries', 'glob_brand_countries.brand_id', '=', 'glob_brands.id')
                ->where('glob_brand_countries.active', '=', 1)
                ->where('glob_brand_countries.country_id', '=', Session::get('portal.main.country_id'))
                ->whereIn('glob_brands.id', $explode_id)
                ->where('glob_brands.active', '=', 1)
                ->orderBy('glob_brands.id', 'ASC')
                ->get();

            session()->put('portal.main.varsMenu.parentBrands', $parentBrands);
        }

        session()->forget('portal.main.varsMenu.countryLangs');
        if(!empty(Session::get('portal.main.country_id'))){
            $langs = CountryLanguage::selectArrayActiveById(Session::get('portal.main.country_id'));
            session()->put('portal.main.varsMenu.countryLangs',$langs);
        }
    }

    public function share($share_id, $url)
    {
        $share = Share::where('share_id', $share_id)->first();
        if ($share !== null) {
            $decoded = (unserialize(base64_decode($share->data)));
            if (isset($decoded)) {
                $config_active_country = country_config($decoded['country_corbiz']);
                if(config('settings::frontend.webservices') == 1 && $config_active_country['shopping_active'] == 1){
                    $sku = $share->is_product === 1 ? str_replace("-","",strrchr($share->url, '-')) : null;
                    $corbizWarehouse = $sku !== null ? WarehouseCountry::getWarehouseByCountryAndSku($decoded['country_id'], $sku) : WarehouseCountry::getWarehouseByCountryAndSku($decoded['country_id']);
                    if($corbizWarehouse !== null){
                        $decoded['corbiz_warehouse'] = $corbizWarehouse->warehouse;
                    }
                }
                session()->put('portal.main', $decoded);
                return redirect($url);
            }
        }
    }

    private function getValidUrl($url){
        $badRoutes = ['cms..', 'cms../themes/omnilife2018/css/master.css', 'omnilife2018', 'save_read_cookies'];
        if(str_contains($url, $badRoutes)) {
            $url = url('/');
        }
        return $url;
    }
}
