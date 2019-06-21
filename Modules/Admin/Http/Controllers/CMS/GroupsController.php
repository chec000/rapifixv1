<?php namespace Modules\Admin\Http\Controllers\CMS;

use Auth;
use Carbon\Carbon;
use Modules\CMS\Entities\Page;
use Modules\CMS\Helpers\StringHelper;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\Block;
use Modules\Admin\Entities\Language;
use Modules\CMS\Entities\PageBlock;
use Modules\CMS\Entities\PageGroup;
use Modules\CMS\Entities\PageGroupAttribute;
use Modules\CMS\Entities\PageLang;
use Modules\CMS\Entities\Theme;
use Request;
use View;

class GroupsController extends Controller
{

    public function getPages($groupId)
    {        
        $request=Request(); 
        $group = PageGroup::preload($groupId);
        if ($group->exists) {
            $pageIds = $group->itemPageIds(false, true);
            
            $attributes = PageGroupAttribute::where('group_id', '=', $groupId)->get();
            $attributeBlocks = [];
            foreach ($attributes as $attribute) {
                $block = Block::preload($attribute->item_block_id);              
                if ($block->exists) {
                    $attributeBlocks[$attribute->item_block_id] = $block;
                }
            }

            $pageRows = '';

            if (!empty($pageIds)) {
                foreach ($pageIds as $pageId) {
                    $pageLang = PageLang::where([['page_id','=',$pageId],['language_id','=',$request->language_id]]
                        )->first();
        
                    $showBlocks = [];
                    $canEdit = Auth::action('pages.edit', ['page_id' => $pageId]);
                    $canDelete = Auth::action('pages.delete', ['page_id' => $pageId]);

                    $pageModel = Page::find($pageId);

                    foreach ($attributeBlocks as $attributeBlock) {                              
                  $pageBlockContent =  PageBlock::preleadPageBlockContent($pageId, $attributeBlock->id, -1, 'block_id', $pageModel->brand_id, $pageModel->country_id,$request->language_id);
                  if($pageBlockContent!=null){    
                      $pageBlockContent=$pageBlockContent->content;
                              if (strpos($attributeBlock->type, 'selectmultiple') === 0 && !empty($pageBlockContent)) {
                            // selectmultiple
                            $showBlocks[] = implode(', ', unserialize($pageBlockContent));
                        } elseif ($attributeBlock->type == 'datetime' && !empty($pageBlockContent)) {                            
                            $showBlocks[] = (new Carbon($pageBlockContent))->format(config('cms.date.format.long'));                                                                       
                        } else {
                            // text/string/select
                            $showBlocks[] = strip_tags(StringHelper::cutString($pageBlockContent, 50));
                        }
                  }               
                    }                          
                    $pageRows .= View::make('admin::cms.partials.groups.page_row', array('page_lang' => $pageLang, 'item_name' => $group->item_name, 'showBlocks' => $showBlocks, 'can_edit' => $canEdit, 'can_delete' => $canDelete))->render();                                     
                    }
            }
                               
            $pagesTable = View::make('admin::cms.partials.groups.page_table', array('rows' => $pageRows, 'item_name' => $group->item_name, 'blocks' => $attributeBlocks))->render();
            $this->layoutData['modals'] = View::make('admin::modals.general.delete_item');
            $this->layoutData['content'] = View::make('admin::cms.pages.groups',                                         
                    array('group' => $group, 
                       "country_id"=>$request->input('country_id'),
                        'brand_id'=>$request->input('brand_id'),
                        'language_id'=>$request->input('language_id'),
                        'pages' => $pagesTable, 'can_add' => $group->canAddItems(), 'can_edit' => $group->canEditItems()));
        }
    }

    public function getEdit($groupId)
    {
        $group = PageGroup::preload($groupId);
        if ($group->exists) {
            
            $templateSelectOptions = [0 => '-- No default --'] + Theme::get_template_list($group->default_template);
            $blockList = Block::idToLabelArray();
            $this->layoutData['content'] = View::make('admin::cms.pages.groups.edit',                                        
                    ['group' => $group, 
                        'brand_id'=>Request::get('brand_id'),
                        'country_id'=>Request::get('country_id'),
                        'language_id'=>Request::get('language_id'),
                        'defaultTemplate' => $group->default_template, 'templateSelectOptions' => $templateSelectOptions, 'blockList' => $blockList]);
        }
    }


    public function postEdit($groupId)
    {
        $group = PageGroup::preload($groupId);
        if ($group->exists) {
            $groupInput = Request::input('group', []);
            foreach ($groupInput as $groupAttribute => $attributeValue) {
                if ($group->$groupAttribute !== null && $groupAttribute != 'id') {
                    if (is_array($attributeValue)) {
                        $attributeValue = isset($attributeValue['select']) ? $attributeValue['select'] : '';
                    }
                    $group->$groupAttribute = $attributeValue;
                }
            }
            $group->save();

            $currentAttributes = [];
            $newAttributes = [];
            foreach ($group->groupAttributes as $currentAttribute) {
                $currentAttributes[$currentAttribute->id] = $currentAttribute;
            }
            $groupPageAttributes = Request::input('groupAttribute', []);

            foreach ($groupPageAttributes as $attributeId => $groupPageAttribute) {
                if ($newAttribute = strpos($attributeId, 'new') === 0 ? new PageGroupAttribute : (!empty($currentAttributes[$attributeId]) ? $currentAttributes[$attributeId] : null)) {
                    $newAttribute->group_id = $group->id;
                    $newAttribute->item_block_id = $groupPageAttribute['item_block_id'];
                    $newAttribute->item_block_order_priority = $groupPageAttribute['item_block_order_priority'];
                    $newAttribute->item_block_order_dir = $groupPageAttribute['item_block_order_dir'];
                    $newAttribute->save();
                    $newAttributes[$newAttribute->id] = $newAttribute;
                }
            }

            $deleteAttributeIds = array_diff(array_keys($currentAttributes), array_keys($newAttributes));
            PageGroupAttribute::whereIn('id', $deleteAttributeIds)->delete();
        }

        return redirect()->route('admin.groups.edit', ['groupId' => $groupId,
            'country_id'=>Request::get('country_id'),
            'language_id'=>Request::get('language_id'),
            'brand_id'=>Request::get('brand_id')
            ]);
    }


}