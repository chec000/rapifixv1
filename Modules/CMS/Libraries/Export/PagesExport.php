<?php namespace Modules\CMS\Libraries\Export;

use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageGroupPage;
use Modules\CMS\Entities\PageLang;

class PagesExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = Page::class;

    /**
     * @param array $fieldDetails
     * @return string
     */
    protected function _extractFieldDataFromMapTo($fieldDetails)
    {
        if ($fieldDetails['mapTo'][0] == 'PageLang') {
            return PageLang::preload($this->_currentExportItem->id)->{$fieldDetails['mapTo'][1]};
        } else {
            return $this->_currentExportItem->{$fieldDetails['mapTo'][1]};
        }
    }

    /**
     * @param string $data
     * @return string
     */
    protected function _mapGroups($data)
    {
        return implode(',', PageGroupPage::getGroupIds($this->_currentExportItem->id));
    }

}