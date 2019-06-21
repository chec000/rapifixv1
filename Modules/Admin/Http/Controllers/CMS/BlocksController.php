<?php namespace Modules\Admin\Http\Controllers\CMS;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\BrandCountry;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Language;
use Modules\CMS\Entities\BlockCategory;
use Modules\CMS\Helpers\Page\PageCache;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Entities\Block;
use Modules\CMS\Entities\PageBlockDefault;
use Modules\CMS\Entities\PageVersion;
use Modules\CMS\Entities\Theme;
use View;
use Request;

class BlocksController extends Controller
{
    public function getIndex()
    {
        //dd($default_blocks);
        if(empty(Request::all())){
            $brand_id = 0;
            $country_id = 0;
            $lang_id = 0;
        } else {
            $brand_id = Request::get('brand_id');;
            $country_id = Request::get('country_id');;
            $lang_id = Request::get('language_id');
        }

        // load theme global blocks
        $blocks = array();
        $theme = Theme::find(config('cms.frontend.theme'));
        if (!empty($theme)) {
            $blocks = Theme::theme_blocks($theme->id);
        }

        // load tab contents from categories & blocks (with default block contents)
        //$default_blocks = PageBlockDefault::preloadArray();
        $globalBlockData = PageBlockDefault::from('cms_page_blocks_default as main')->join(
            DB::raw(
                '(SELECT max(maxVersions.version) as version, maxVersions.block_id FROM cms_page_blocks_default maxVersions
                        WHERE maxVersions.brand_id = '.$brand_id.' AND maxVersions.country_id = '.$country_id.' AND maxVersions.language_id = '.$lang_id.'
			            group by maxVersions.block_id) j'),
            function($join)
            {
                $join->on('j.version', '=', 'main.version');
                $join->on('j.block_id','=','main.block_id');
            }
        )
        ->where('main.brand_id', '=', $brand_id)->where('main.country_id', '=', $country_id)
            ->where('main.language_id', '=', $lang_id)->get();
        $default_blocks = [];
        foreach ($globalBlockData as $gbd){
            $default_blocks[$gbd->block_id][$gbd->language_id] = $gbd;
        }
//        dd($blocks);
        list($tab_headers, $tab_contents) = Block::getTabs($blocks, $default_blocks,0,0,$lang_id);
        $tab_headers = array_filter($tab_headers);
        ksort($tab_headers);

        if($lang_id == 0 || $brand_id == 0 || $country_id == 0){
            $tab_data['headers'] = "";
            $tab_data['contents'] = "";
        } else {
            $tab_data = [
                'headers' => View::make('admin::cms.partials.tabs.header', ['tabs' => $tab_headers])->render(),
                'contents' => View::make('admin::cms.partials.tabs.content', [
                    'tabs' => $tab_contents, 'item' => 'Site-wide Content', 'new_page' => false,
                    'publishing' => false, 'can_publish' => true
                ])->render()
            ];
        }

        $brands = Brand::selectArrayBrandUseractive();
        $countries = BrandCountry::selectCountryBrandUser($brand_id);
        $languages = Country::selectArrayCountryLanguages($country_id);

        $statsBlocks = $this->getDataStatsBlocks();

        $this->layoutData['title'] = trans('admin::siteWideContent.title_swc');
        $this->layoutData['content'] = View::make('admin::cms.pages.blocks', ['tab' => $tab_data, 'languages' => $languages, 'countries' => $countries, 'brands' => $brands, 'statsBlocks' => $statsBlocks]);
    }

    public function postIndex()
    {
        //dd(Request::all());
        // update blocks
        AdminLog::new_log('Updated Site-wide Content');

        $versionId = PageVersion::add_new(0)->version_id;
        Block::submit(0, $versionId);

        PageCache::clear();
        $this->addAlert('success', 'Site-wide Content Updated');

        $this->getIndex();
        //return \redirect()->route('admin.blocks.index');
    }

    public function postChangeSelectFilter(){
        $select = Request::get('select');
        $arrayReturn =[];
        switch($select){
            case "country":
                $arrayReturn = BrandCountry::selectCountryBrandUser(Request::get('search_id'));
                //$arrayReturn = Brand::selectArrayBrandCountries(Request::get('search_id'));
                break;
            case "language":
                $arrayReturn = Country::selectArrayCountryLanguages(Request::get('search_id'));
                break;
        }

        return json_encode($arrayReturn);
    }

    public function getDataStatsBlocks(){

        $dataTableStatsBlocks = [];

        $brands = Brand::selectArrayBrandUseractive();
        $countries = Country::selectArrayCountriesUser();
        $languages = Language::selectArray();

        $blocks = Block::preloadArray();
        $categories = BlockCategory::preloadArray();
        $default_blocks = PageBlockDefault::preloadArray();

        foreach($default_blocks as $default_block){
            foreach($default_block as $langDF){

                if(isset($brands[$langDF->brand_id]) && isset($countries[$langDF->country_id]) && isset($languages[$langDF->language_id])){
                    $categoryId = $blocks[$langDF->block_id]->category_id;
                    $dataTableStatsBlocks[$categoryId][] = array(
                        'brand_id' => $langDF->brand_id,
                        'brand' =>$brands[$langDF->brand_id],
                        'country_id' => $langDF->country_id,
                        'country' => $countries[$langDF->country_id],
                        'language_id' => $langDF->language_id,
                        'language' => $languages[$langDF->language_id],
                        'category_id' => $categoryId,
                        'category' => $categories[$categoryId]->name,
                        'block_id' => $langDF->block_id,
                        'block_name' => $blocks[$langDF->block_id]->label);
                }
            }
        }
        return $dataTableStatsBlocks;
    }
}