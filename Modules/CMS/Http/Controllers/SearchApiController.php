<?php

namespace Modules\CMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CMS\Entities\PageBlock;
use Modules\CMS\Entities\Page;
use Modules\Admin\Entities\Cedis;
use Modules\Shopping\Entities\CountryProduct;
use App\Helpers\TranslatableUrlPrefix;
use App\Helpers\SessionHdl;

class SearchApiController extends Controller
{
    public function globalSearch(Request $request)
    {
        $search = $request->input('search');
        $session = [
            'brand_id' => session()->get('portal.main.brand.id'),
            'country_id' => session()->get('portal.main.country_id'),
            'language_id' => session()->get('portal.main.language_id'),
            'lang' => session()->get('portal.main.app_locale')
        ];

        $results = [];
        if ($searchProducts = $this->searchProducts($search, $session)) {
            $results[] = $searchProducts;
        }
        if ($searchPages = $this->searchPages($search, $session)) {
            $results[] = $searchPages;
        }
        if ($searchCedis = $this->searchCedis($search, $session)) {
            $results[] = $searchCedis;
        }

        return response()->json($results);
    }

    public function searchPages($search, $session)
    {
        $searchBlockID = config('settings::search.keywords_block.id', config('constants.SEARCH.KEYWORDS_BLOCK_ID'));
        $pageIDs = PageBlock::select('page_id')->where('block_id', $searchBlockID)
            ->where('language_id', $session['language_id'])->where('content', 'LIKE', '%' . $search . '%')->get();

        $pages = Page::whereIn('id', $pageIDs)->where('country_id', $session['country_id'])
            ->whereHas('metaTitle', function ($query) {
                $query->where('content', '<>', '');
            })->with(['pageLangs' => function ($query) use ($session) {
                $query->where('language_id', $session['language_id']);
            }])->with(['metaTitle' => function ($query) use ($session) {
                $query->where('language_id', $session['language_id']);
            }])->with(['metaDescription' => function ($query) use ($session) {
                $query->where('language_id', $session['language_id']);
            }])->with('brand')->get();

        if (count($pages) == 0) {
            return null;
        }

        $links = [];
        foreach ($pages as $page) {
            if ($page->metaTitle->first()->content != '') {
                $pageBrandDomain = rtrim($page->brand->domain, '/');
                $pageURL = ($page->pageLangs->first()->url != '/') ? $page->pageLangs->first()->url : '';
                $link = [
                    'header' => $page->metaTitle->first()->content,
                    'brand' => $page->brand->name,
                    'description' => $page->metaDescription->first()->content,
                    'link' => $pageBrandDomain . '/' . $pageURL
                ];
                $links[] = $link;
            }
        }

        return $this->setLinks($links, trans('cms::search.pages_header'));
    }

    public function searchProducts($search, $session)
    {
        $warehouse = SessionHdl::getWarehouse();
        $config = country_config(SessionHdl::getCorbizCountryKey());
        $isShoppingActive = $config['shopping_active'];
        $isWSActive = $config['webservices_active'];
        $countryProducts = CountryProduct::whereTranslationLike('name', '%' . $search . '%')
            ->orWhereTranslationLike('description', '%' . $search . '%')->whereTranslation('locale', $session['lang'])
            ->where('country_id', $session['country_id'])->where('active', 1)->where('delete', 0)
            ->with(['product' => function ($productQuery) {
                $productQuery->with(['brandProduct' => function ($brandProductQuery) {
                    $brandProductQuery->with('brand');
                }]);
            }]);

        if ($isShoppingActive && $isWSActive) {
            $countryProducts = $countryProducts->whereHas('warehouseProduct', function ($q) use ($warehouse) {
                $q->where('active', 1)->whereHas('warehouse', function ($q) use ($warehouse) {
                    $q->where('warehouse', $warehouse);
                });
            })->get();
        } else {
            $countryProducts = $countryProducts->get();
        }

        if (count($countryProducts) == 0) {
            return null;
        }

        $links = [];
        foreach ($countryProducts as $countryProduct) {
            if ($countryProduct->name != '') {
                $brand = $countryProduct->product->brandProduct->brand;
                $url = $brand->domain . route(TranslatableUrlPrefix::getRouteName($session['lang'], ['products', 'detail']),
                    [($countryProduct->slug . '-' . $countryProduct->product->sku)], false);
                $link = [
                    'header' => $countryProduct->name,
                    'brand' => $brand->name,
                    'description' => $countryProduct->description,
                    'link' => $url
                ];
                $links[] = $link;
            }
        }

        return $this->setLinks($links, trans('cms::search.products_header'));
    }

    public function searchCedis($search, $session)
    {
        $cedis = Cedis::whereTranslationLike('name', '%' . $search . '%')
            ->orWhereTranslationLike('description', '%' . $search . '%')->where('country_id', $session['country_id'])
            ->where('status', 1)->with('translations')->get();
        if (count($cedis) == 0) {
            return null;
        }

        $links = [];
        foreach ($cedis as $cedisItem) {
            if ($cedisItem->name != '') {
                $link = [
                    'header' => $cedisItem->name,
                    'brand' => '',
                    'description' => $cedisItem->description,
                    'link' => route('cedis.detail', $cedisItem->slug)
                ];
                $links[] = $link;
            }
        }

        return $this->setLinks($links, trans('cms::search.cedis_header'));
    }

    function setLinks($links, $trans)
    {
        if (count($links) == 0) {
            return null;
        }
        $res = [
            'title' => $trans,
            'links' => $links
        ];
        return $res;
    }
}
