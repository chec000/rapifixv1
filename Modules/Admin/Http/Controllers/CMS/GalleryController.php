<?php namespace Modules\Admin\Http\Controllers\CMS;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Libraries\Blocks\Gallery;
use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Entities\Block;
use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageLang;
use Modules\CMS\Entities\Template;
use Modules\CMS\Entities\ThemeTemplate;
use Request;
use View;

class GalleryController extends Controller
{

    public function getList($pageId = 0)
    {
        $page = Page::find($pageId);
        if (!empty($page)) {
            $block_cats = ThemeTemplate::templateBlocks(config('cms.frontend.theme'), $page->template);
            foreach ($block_cats as $block_cat) {
                foreach ($block_cat as $block) {
                    if ($block->type == 'gallery') {
                        $gallery_blocks[] = $block;
                    }
                }
            }
        }
        if (isset($gallery_blocks)) {
            if (count($gallery_blocks) == 1) {
                return \redirect()->route('admin.gallery.edit', ['pageId' => $pageId, 'blockId' => $gallery_blocks[0]->id]);
            }
            $page_lang_data = PageLang::preload($pageId);
            if (!empty($page_lang_data)) {
                $name = $page_lang_data->name;
                if ($page->parent != 0) {
                    $parent_lang_data = PageLang::preload($page->parent);
                    $name = $parent_lang_data->name . " / " . $name;
                }
            } else {
                $name = '';
            }
            $this->layoutData['content'] = View::make('admin::cms.pages.gallery.list', array('page_name' => $name, 'page_id' => $pageId, 'galleries' => $gallery_blocks));
        } else {
            $this->layoutData['content'] = 'No Galleries Found';
        }
        return null;
    }

    // main actions

    public function getEdit($pageId = 0, $blockId = 0)
    {
        $this->layoutData['content'] = $this->_getGalleryBlock($pageId, $blockId)->editPage();
    }

    public function getUpdate($pageId = 0, $blockId = 0)
    {
        return $this->postUpdate($pageId, $blockId);
    }

    // ajax updates

    public function postCaption($pageId = 0, $blockId = 0)
    {
        return $this->_getGalleryBlock($pageId, $blockId)->submitCaption();
    }

    public function postSort($pageId = 0, $blockId = 0)
    {
        return $this->_getGalleryBlock($pageId, $blockId)->submitSort();
    }

    public function postUpdate($pageId = 0, $blockId = 0)
    {
        return $this->_getGalleryBlock($pageId, $blockId)->runHandler();
    }

    public function deleteUpdate($pageId = 0, $blockId = 0)
    {
        return $this->_getGalleryBlock($pageId, $blockId)->submitDelete(Request::input('file'));
    }

    /**
     * @param int $blockId
     * @param int $pageId
     * @return \Modules\CMS\Libraries\Blocks\Gallery
     * @throws \Exception
     */
    protected function _getGalleryBlock($pageId, $blockId)
    {
        $galleryBlock = Block::preload($blockId)->setPageId($pageId)->getTypeObject();
        if (is_a($galleryBlock, Gallery::class)) {
            return $galleryBlock;
        } else {
            throw new \Exception('Not a gallery block!');
        }
    }

}