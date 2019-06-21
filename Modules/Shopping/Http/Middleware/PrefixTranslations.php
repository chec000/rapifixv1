<?php

namespace Modules\Shopping\Http\Middleware;

use App\Helpers\SessionHdl;
use App\Helpers\TranslatableUrlPrefix;
use Closure;
use Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\GroupCountry;

class PrefixTranslations {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {

        $lang              = Session::get('portal.main.app_locale');
        $prefixProducts    = $request->segment(1);
        $prefixGroupOrSlug = $request->segment(2);
        $groupSlug         = $request->segment(3);
        $indexRoute        = TranslatableUrlPrefix::getRouteName($lang, ['products', 'index']);

        # Inspire index
        if (TranslatableUrlPrefix::isFromIndex($request->segment(1), 'inspire')) {
            if (count($request->segments()) == 1) {
                if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['inspire', 'index'])) {
                    return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['inspire', 'index']));
                } else {
                    return $next($request);
                }
            } else {
                if (TranslatableUrlPrefix::isFromIndex($request->segment(2), 'thanks')) {
                    if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['inspire', 'thanks'])) {
                        return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['inspire', 'thanks']));
                    } else {
                        return $next($request);
                    }
                }
            }
        }

        # Shopping index
        if (TranslatableUrlPrefix::isFromIndex($request->segment(1), 'shopping')) {
            if (count($request->segments()) == 1) {
                if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['shopping'])) {
                    return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['shopping']));
                } else {
                    return $next($request);
                }
            } else if (count($request->segments()) == 2 && TranslatableUrlPrefix::isFromIndex($request->segment(2), 'checkout')) {

                if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['checkout', 'index'])) {
                    return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['checkout', 'index']));
                } else {
                    return $next($request);
                }
            } else if (count($request->segments()) == 3 && TranslatableUrlPrefix::isFromIndex($request->segment(3), 'confirmation')) {
                if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['checkout', 'confirmation'])) {
                    //dd(count($request->segments()), $request->segments(), TranslatableUrlPrefix::getRouteName($lang, [ 'checkout', 'confirmation']), TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('confirmation', $lang));
                    return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['checkout', 'confirmation']));
                } else {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
        }

        # Register index
        if (TranslatableUrlPrefix::isFromIndex($request->segment(1), 'register')) {
            if (count($request->segments()) == 1) {
                if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['register'])) {
                    return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['register']),
                        isset($request->distributor_code) ? array('distributor_code' => $request->distributor_code) : array());
                } else {
                    return $next($request);
                }
            } else {
                if (TranslatableUrlPrefix::isFromIndex($request->segment(2), 'confirmation')) {
                    if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, [ 'register', 'confirmation'])) {
                        return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, [ 'register', 'confirmation']));
                    } else {
                        return $next($request);
                    }
                }
            }
        }

        # Resetpassword index
        if (TranslatableUrlPrefix::isFromIndex($request->segment(1), 'reset-password')) {
            if (count($request->segments()) == 1) {
                if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['reset-password', 'index'])) {
                    return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['reset-password', 'index']));
                } else {
                    return $next($request);
                }
            } else {
                if (count($request->segments()) > 1) {
                    if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, $request->segments())) {
                        return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, $request->segments()));
                    } else {
                        return $next($request);
                    }
                }
            }
        }

        # client-register index
        if (TranslatableUrlPrefix::isFromIndex($request->segment(1), 'client-register')) {
            if (count($request->segments()) == 1) {
                //dd($request->segments(), TranslatableUrlPrefix::getRouteName($lang, ['registercustomer']));
                if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, ['registercustomer'])) {
                    return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, ['registercustomer']),
                        isset($request->distributor_code) ? array('distributor_code' => $request->distributor_code) : array());
                } else {
                    return $next($request);
                }
            } else {
                if (count($request->segments()) > 1) {
                    //dd(Route::currentRouteName(), TranslatableUrlPrefix::getRouteName($lang, $request->segments()));
                    if(TranslatableUrlPrefix::isFromIndex($request->segment(2), 'activation')) {
                        /*$routeRegisterCustomer = TranslatableUrlPrefix::getRouteName($lang, ['registercustomer']);
                        $routeActivation = TranslatableUrlPrefix::getRouteName($lang, ['activation']);

                        if (Route::currentRouteName() != TranslatableUrlPrefix::getRouteName($lang, $request->segments())) {
                            return redirect()->route(TranslatableUrlPrefix::getRouteName($lang, $request->segments()));
                        } else {*/
                            return $next($request);
                        //}
                    }
                }
            }
        }

        # Products index
        if (!TranslatableUrlPrefix::isValidPrefix($prefixProducts, $lang, 'products') && ($prefixGroupOrSlug == null && $groupSlug == null)) {
            return redirect()->route($indexRoute);
        }

        # Product detail
        if ($prefixGroupOrSlug != null && !TranslatableUrlPrefix::isFromIndex($prefixGroupOrSlug, 'category') && !TranslatableUrlPrefix::isFromIndex($prefixGroupOrSlug, 'system') && $groupSlug == null) {
            $isValidProductPrefix = TranslatableUrlPrefix::isValidPrefix($prefixProducts, $lang, 'products');
            $product              = $this->getProductBySlugCountryAndLang($prefixGroupOrSlug, Session::get('portal.main.country_id'), $lang);

            if (!$isValidProductPrefix || $product == false) {
                $product = $this->getProductBySlug($prefixGroupOrSlug);

                if ($product != false) {
                    $route          = TranslatableUrlPrefix::getRouteName($lang, ['products', 'detail']);
                    $countryProduct = CountryProduct::whereTranslation('locale', $lang)->where('country_id', Session::get('portal.main.country_id'))->where('product_id', $product->product_id)->first();

                    if ($countryProduct == null) {
                        return redirect()->route($indexRoute);
                    }

                    return redirect()->route($route, $countryProduct->slug.'-'.$countryProduct->product->sku);
                } else {
                    return redirect()->route($indexRoute);
                }
            }
        }

        # Category
        if ($prefixGroupOrSlug != null && TranslatableUrlPrefix::isFromIndex($prefixGroupOrSlug, 'category') && $groupSlug != null) {
            $isValidProductPrefix  = TranslatableUrlPrefix::isValidPrefix($prefixProducts, $lang, 'products');
            $isValidCategoryPrefix = TranslatableUrlPrefix::isValidPrefix($prefixGroupOrSlug, $lang, 'category');
            $categories            = $this->getGroupsBySlugCountryAndLang($groupSlug, Session::get('portal.main.country_id'), $lang, 1);

            $category = false;
            if ($categories->count() > 1) {
                foreach ($categories as $cat) {
                    if ($cat->brandGroup->brand_id == SessionHdl::getBrandID()) {
                        $category = $cat;
                    }
                }
            } else {
                $category = $categories->first();
            }

            if (!$isValidProductPrefix || !$isValidCategoryPrefix || $category == false) {

                if ($category == false) {
                    $category = $this->getGroupBySlug($groupSlug, 1);
                }

                if ($category != false) {
                    $route          = TranslatableUrlPrefix::getRouteName($lang, ['products', 'category']);
                    $countryGroup   = GroupCountry::whereTranslation('locale', $lang)->where('country_id', Session::get('portal.main.country_id'))->where('code', $category->code)->first();

                    if ($countryGroup == null) {
                        return redirect()->route($indexRoute);
                    }

                    return redirect()->route($route, $countryGroup->slug);
                } else {
                    return redirect()->route($indexRoute);
                }
            }
        }

        # System
        if ($prefixGroupOrSlug != null && TranslatableUrlPrefix::isFromIndex($prefixGroupOrSlug, 'system') && $groupSlug != null) {
            $isValidProductPrefix = TranslatableUrlPrefix::isValidPrefix($prefixProducts, $lang, 'products');
            $isValidSystemPrefix  = TranslatableUrlPrefix::isValidPrefix($prefixGroupOrSlug, $lang, 'system');
            $systems              = $this->getGroupsBySlugCountryAndLang($groupSlug, Session::get('portal.main.country_id'), $lang, 2);

            $system = false;
            if ($systems->count() > 1) {
                foreach ($systems as $cat) {
                    if ($cat->brandGroup->brand_id == SessionHdl::getBrandID()) {
                        $system = $cat;
                    }
                }
            } else {
                $system = $systems->first();
            }

            if (!$isValidProductPrefix || !$isValidSystemPrefix || $system == false) {

                if ($system == false) {
                    $system = $this->getGroupBySlug($groupSlug, 2);
                }

                if ($system != false) {
                    $route          = TranslatableUrlPrefix::getRouteName($lang, ['products', 'system']);
                    $countryGroup   = GroupCountry::whereTranslation('locale', $lang)->where('country_id', Session::get('portal.main.country_id'))->where('code', $system->code)->first();

                    if ($countryGroup == null) {
                        return redirect()->route($indexRoute);
                    }

                    return redirect()->route($route, $countryGroup->slug);
                } else {
                    return redirect()->route($indexRoute);
                }
            }
        }


        return $next($request);
    }


    private function getProductBySlugCountryAndLang($slug, $country, $lang) {
        $divider        = strrpos($slug, '-');
        $product_slug   = substr($slug, 0, $divider);
        $countryProduct = CountryProduct::whereTranslation('slug', $product_slug)->whereTranslation('locale', $lang)->where('country_id', $country)->first();

        return $countryProduct != null ? $countryProduct : false;
    }

    private function getProductBySlug($slug) {
        $divider        = strrpos($slug, '-');
        $product_slug   = substr($slug, 0, $divider);
        $sku            = substr($slug, $divider+1);
        $countryProduct = CountryProduct::whereHas('Product', function ($q) use ($sku) {
            $q->where('sku', $sku);
        })->whereTranslation('slug', $product_slug)->first();

        return $countryProduct != null ? $countryProduct : false;
    }

    private function getGroupBySlugCountryAndLang($slug, $countryId, $lang, $type) {
        $category = GroupCountry::whereTranslation('slug', $slug)->whereTranslation('locale', $lang)->where('country_id', $countryId)->where('group_id', $type)->first();

        return $category != null ? $category : false;
    }

    private function getGroupBySlug($slug, $type) {
        $category = GroupCountry::whereTranslation('slug', $slug)->where('group_id', $type)->first();

        return $category != null ? $category : false;
    }

    private function getGroupsBySlugCountryAndLang($slug, $countryId, $lang, $type) {
        $category = GroupCountry::whereTranslation('slug', $slug)->whereTranslation('locale', $lang)->where('country_id', $countryId)->where('group_id', $type)->get();

        return $category != null ? $category : false;
    }
}
