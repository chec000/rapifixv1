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
