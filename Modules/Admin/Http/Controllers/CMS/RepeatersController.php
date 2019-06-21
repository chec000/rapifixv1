<?php namespace Modules\Admin\Http\Controllers\CMS;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\Block;
use Request;

class RepeatersController extends Controller
{

    public function postIndex()
    {
        $block = Block::find(Request::input('block_id'));
        if  (($repeaterId = Request::input('repeater_id')) && $block && $block->type == 'repeater') {
            return $block->setPageId(Request::input('page_id'))->getTypeObject()->edit($repeaterId, true);
        }
        return 0;
    }

}