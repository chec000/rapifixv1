<?php namespace Modules\CMS\Libraries\Blocks;

use Carbon\Carbon;
use Modules\CMS\Helpers\Email;
use Modules\CMS\Helpers\View\CmsBlockInput;
use Modules\CMS\Helpers\View\FormWrap;
use Modules\CMS\Helpers\View\PaginatorRender;
use Modules\CMS\Libraries\Builder\FormMessage;
use PageBuilder;
use Modules\CMS\Entities\Block;
use Modules\CMS\Entities\BlockFormRule;
use Modules\CMS\Entities\BlockRepeater;
use Modules\CMS\Entities\PageBlockRepeaterData;
use Modules\CMS\Entities\PageBlockRepeaterRows;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;
use Validator;

class Repeater extends AbstractBlock
{
    /**
     * @var bool
     */
    protected static $_duplicate = false;

    /**
     * @var string
     */
    protected $_renderDataName = 'repeaters';

    /**
     * @var string
     */
    protected $_renderRepeatedItemName = 'repeater_row';

    /**
     * Repeater constructor.
     * @param Block $block
     */
    public function __construct(Block $block)
    {
        parent::__construct($block);
        $this->_displayViewDirs[] = 'repeaters';
    }

    /**
     * Display repeater view
     * @param string $content
     * @param array $options
     * @return string
     */
    public function display($content, $options = [])
    {
        if (!empty($options['form'])) {
            $view = !empty($options['view']) ? $options['view'] : '';
            return FormWrap::view($this->_block, $options, $this->displayView($view, '-form'));
        }

        $options = $options + ['random' => false, 'repeated_view' => true];
        $options['repeater_id'] = $content;
        $repeaterRows = PageBlockRepeaterData::loadRepeaterData($content, $options['version'],
            $options['random'], (isset($options['search']) ? $options['search'] : null));
        return $this->_renderDisplayView($options, $repeaterRows);
    }

    /**
     * @param array $options
     * @return string
     */
    public function displayDummy($options)
    {
        $options = $options + ['repeated_view' => true];
        $options['repeater_id'] = 0;
        return $this->_renderDisplayView($options, [0]);
    }

    /**
     * Used in theme builder to render blocks as json
     * @param string $content
     * @param array $options
     * @return string json
     */
    public function toJson($content, $options = [])
    {
        $options = $options + ['random' => false, 'repeated_view' => true];
        $options['repeater_id'] = $content;
        $repeaterRows = PageBlockRepeaterData::loadRepeaterData($content, $options['version'], $options['random']);
        $data = ['rows' => [], 'repeater_id' => $content];

        foreach ($repeaterRows as $rowId => $rowBlockData) {
            $data['rows'][$rowId] = [];

            foreach ($rowBlockData as $key => $rowContent) {
                $block = Block::preload($key);
                if ($block->exists) {
                    $data['rows'][$rowId] += json_decode($block->getTypeObject()->toJson($rowContent, $options), true);
                }
            }
        }

        return parent::toJson($data, $options);
    }

    /**
     * Check per page values and load block info to pass to repeated view
     * @param array $options
     * @param array $repeaterRows
     * @return string
     */
    protected function _renderRepeatedDisplayView($options, $repeaterRows = [])
    {
        $repeaterBlocks = BlockRepeater::getRepeaterBlocks($this->_block->id);
        // $repeaterRows[0] check allows skipping of block check (used for dummy data)
        if (($repeaterRows && $repeaterBlocks) || (isset($repeaterRows[0]) && $repeaterRows[0] === 0)) {

            // pagination
            if (!empty($options['per_page'])) {
                $pagination = new LengthAwarePaginator($repeaterRows, count($repeaterRows), $options['per_page'], Request::input('page', 1));
                $pagination->setPath(Request::getPathInfo());
                $paginationLinks = PaginatorRender::run($pagination);
                $repeaterRows = array_slice($repeaterRows, (($pagination->currentPage() - 1) * $options['per_page']), $options['per_page'], true);
            } else {
                $paginationLinks = '';
            }
            $options['pagination'] = $paginationLinks;
            $options['links'] = $paginationLinks;
            $options['blocks'] = $repeaterBlocks;
            return parent::_renderRepeatedDisplayView($options, $repeaterRows);
        }
        return '';
    }

    /**
     * Load custom data so PageBuilder::block will return repeater data
     * @param string $displayView
     * @param array $data
     * @return string
     */
    protected function _renderRepeatedDisplayViewItem($displayView, $data = [])
    {
        $itemData = reset($data);
        $itemDataIdKey = key($data) . '_id';
        $previousKey = PageBuilder::getData('customBlockDataKey');
        PageBuilder::setData('customBlockDataKey', 'repeater' . $data['repeater_id'] . '.' . $data[$itemDataIdKey]);
        foreach ($data['blocks'] as $repeaterBlock) {         
            if ($repeaterBlock->exists) {
                             PageBuilder::setCustomBlockData($repeaterBlock->name, !empty($itemData[$repeaterBlock->id]) ? $itemData[$repeaterBlock->id] : '', null, false);                             
            }
        }
        $renderedContent = parent::_renderRepeatedDisplayViewItem($displayView, $data);
        PageBuilder::setData('customBlockDataKey', $previousKey);   
        return $renderedContent;
    }

    /**
     * Repeater form submission
     * @param array $formData
     * @return null|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function submission($formData)
    {
        $formRules = BlockFormRule::get_rules($this->_block->name.'-form');
        $v = Validator::make($formData, $formRules);
        if ($v->passes()) {

            foreach ($formData as $blockName => $content) {
                $fieldBlock = Block::preload($blockName);
                if ($fieldBlock->exists) {
                    if ($fieldBlock->type == 'datetime' && empty($content)) {
                        $content = new Carbon();
                    }
                    $formData[$blockName] = $content;
                }
            }

            $this->insertRow($formData);

            Email::sendFromFormData([$this->_block->name.'-form'], $formData, config('cms.site.name') . ': New Form Submission - ' . $this->_block->label);

            return \redirect(Request::url());

        } else {
            FormMessage::set($v->messages());
        }

        return null;
    }

    /**
     * Admin view for editing repeater data
     * Can return an individual repeater row with default block data)
     * @param string $content
     * @param bool $newRow
     * @return string
     */
    public function edit($content, $newRow = false,$lang=0)
    {
        // if no current repeater id, reserve next new repeater id for use on save
        $repeaterId = $content ?: PageBlockRepeaterRows::nextFreeRepeaterId();
        $this->_editViewData['renderedRows'] = '';
        $this->_editViewData['itemName'] = '';
        if ($repeaterBlocks = BlockRepeater::getRepeaterBlocks($this->_block->id)) {

            $this->_editViewData['itemName'] = BlockRepeater::preload($this->_block->id)->item_name;
            // check if new or existing row needs displaying
            if ($newRow) {  
                $renderedRow = '';
                $repeaterRowId = PageBlockRepeaterRows::nextFreeRepeaterRowId($repeaterId);
                foreach ($repeaterBlocks as $repeaterBlock) {
                    if($repeaterBlock->type=='link'){
                     $renderedRow .= $repeaterBlock->setPageId($this->_block->getPageId())->setRepeaterData($repeaterId, $repeaterRowId)->getTypeObject()->edit('',$this->_block->getPageId(),Request::input('language_id_repeater'));                                         
                    }else{
                   $renderedRow .= $repeaterBlock->setPageId($this->_block->getPageId())->setRepeaterData($repeaterId, $repeaterRowId)->getTypeObject()->edit('');
                    }
                }
                return (string) CmsBlockInput::make('repeater.row',
                    ['repeater_id' => $repeaterId, 'row_id' => $repeaterRowId, 'blocks' => $renderedRow,
                    'index' => trans('admin::repeaters.new'), 'label' => $this->_block->label]);
            } else {
             
                $repeaterRowsData = PageBlockRepeaterData::loadRepeaterData($repeaterId, $this->_block->getVersionId());
                $index = 0;
                foreach ($repeaterRowsData as $repeaterRowId => $repeaterRowData) {
                    $renderedRow = '';
                    foreach ($repeaterBlocks as $repeaterBlockId => $repeaterBlock) {
                        $fieldContent = isset($repeaterRowData[$repeaterBlockId]) ? $repeaterRowData[$repeaterBlockId] : '';
                     if($repeaterBlock->type=='link'){
                 
                                         $renderedRow .= $repeaterBlock->setPageId($this->_block->getPageId())->setRepeaterData($repeaterId, $repeaterRowId)->getTypeObject()->edit($fieldContent,$this->_block->getPageId(),  (Request::input('language_id')!=null)?Request::input('language_id'):$lang);             
                     }else{
                                         $renderedRow .= $repeaterBlock->setPageId($this->_block->getPageId())->setRepeaterData($repeaterId, $repeaterRowId)->getTypeObject()->edit($fieldContent);          
                     }                                                
                     }                  
                    $index++;
                    $this->_editViewData['renderedRows'] .= CmsBlockInput::make('repeater.row',
                        ['repeater_id' => $repeaterId, 'row_id' => $repeaterRowId, 'blocks' => $renderedRow,
                        'index' => $index, 'label' => $this->_block->label]);
                }
            }
        }

        $this->_editViewData['_repeaterId'] = $this->_block->getRepeaterId();
        $this->_editViewData['_repeaterRowId'] = $this->_block->getRepeaterRowId();

        return parent::edit($repeaterId);
    }

    /**
     * Save submitted repeater data
     * @param array $postContent
     * @return static
     */
    public function submit($postContent)
    {
        // load current and submitted data
        $existingRepeaterRows = PageBlockRepeaterData::loadRepeaterData($postContent['repeater_id'], $this->_block->getVersionId());
        $submittedRepeaterRows = Request::input('repeater.' . $postContent['repeater_id']) ?: [];

        // save repeater id, if duplicating get new repeater id to save data to
        $postContent['repeater_id'] = static::$_duplicate ? PageBlockRepeaterRows::nextFreeRepeaterId() : $postContent['repeater_id'];
        $return = $this->save($postContent['repeater_id']);
        // if row missing, overwrite all data with blanks in new version
        if ($existingRepeaterRows && !static::$_duplicate) {
            foreach ($existingRepeaterRows as $rowId => $existingRepeaterRow) {
                if (empty($submittedRepeaterRows[$rowId])) {
                    foreach ($existingRepeaterRow as $blockId => $existingRepeaterBlockContent) {
                        $block = Block::preloadClone($blockId);
                        $block->id = $blockId;
                        if ($block->exists || $blockId === 0) {
                            $block->setVersionId($this->_block->getVersionId())->setRepeaterData($postContent['repeater_id'], $rowId)->setPageId($this->_block->getPageId())->getTypeObject()->save('');
                        }
                    }
                }
            }
        }

        // save new data
        $rowOrderNumber = 0;
        foreach ($submittedRepeaterRows as $rowId => $submittedRepeaterRow) {
            $rowOrderNumber++;
            foreach ($submittedRepeaterRow as $submittedBlockId => $submittedBlockData) {
                $block = Block::preloadClone($submittedBlockId)->setVersionId($this->_block->getVersionId())->setRepeaterData($postContent['repeater_id'], $rowId)->setPageId($this->_block->getPageId());
                if ($submittedBlockId == 0) { // use block id 0 to save order value
                    $block->exists = true;
                    $submittedBlockData = $rowOrderNumber;
                }
                if ($block->exists) {
                    $block->id = $submittedBlockId;
                    $block->getTypeObject()->submit($submittedBlockData);
                }
            }
        }

        return $return;
    }

    /**
     * Get search text from repeater blocks
     * @param null|string $content
     * @return null|string
     */
    public function generateSearchText($content)
    {
        $searchText = '';
        $repeaterRows = PageBlockRepeaterData::loadRepeaterData($content, $this->_block->getVersionId());
        $repeaterBlocks = BlockRepeater::getRepeaterBlocks($this->_block->id);

        foreach ($repeaterRows as $rowId => $repeaterRow) {
            foreach ($repeaterBlocks as $blockId => $repeaterBlock) {
                if(($blockContent = array_key_exists($blockId, $repeaterRow) ? $repeaterRow[$blockId] : null) !== null) {
                    $block = Block::preloadClone($blockId)->setRepeaterData($this->_block->getRepeaterId(), $this->_block->getRepeaterRowId())->setPageId($this->_block->getPageId());
                    if ($block->exists && $block->search_weight > 0) {
                        $blockSearchText = $block->getTypeObject()->generateSearchText($blockContent);
                        $searchText .= ($blockSearchText !== null) ? $blockSearchText . "\n" : '';
                    }
                }
            }
        }

        return parent::generateSearchText($searchText);
    }

    /**
     * Add new repeater row with passed block contents onto end of repeater rows (or create repeater and set as first row)
     * @param array $repeaterBlockContents
     */
    public function insertRow($repeaterBlockContents)
    {
        if (!($repeaterId = $this->_block->getContent())) {
            $repeaterId = PageBlockRepeaterRows::nextFreeRepeaterId();
            $this->save($repeaterId);
            $currentRepeaterRows = [];
        } else {
            $currentRepeaterRows = PageBlockRepeaterData::loadRepeaterData($repeaterId);
        }
        $repeaterRowId = PageBlockRepeaterRows::nextFreeRepeaterRowId($repeaterId);

        if (!array_key_exists(0, $repeaterBlockContents)) {
            if (!empty($currentRepeaterRows)) {
                $rowOrders = array_map(function ($row) {return !empty($row[0]) ? $row[0] : 0;}, $currentRepeaterRows);
                $repeaterBlockContents[0] = max($rowOrders) + 1;
            } else {
                $repeaterBlockContents[0] = 1;
            }
        }

        foreach ($repeaterBlockContents as $blockName => $content) {
            $block = Block::preloadClone($blockName);
            if ($block->exists || $blockName == 0) {
                $block->id = ($blockName === 0) ? 0 : $block->id;
                $block->setVersionId($this->_block->getVersionId())->setRepeaterData($repeaterId, $repeaterRowId)->setPageId($this->_block->getPageId())->getTypeObject()->save($content);
            }
        }
    }

    /**
     * If duplicate is set will save repeater data under a new id (useful for duplicate pages)
     * @param bool $duplicate
     */
    public static function setDuplicate($duplicate = true)
    {
        static::$_duplicate = $duplicate;
    }

}
