<?php namespace Modules\CMS\Libraries\Builder\ViewClasses;

use Modules\CMS\Entities\PageLang;

class BreadCrumb
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var PageLang
     */
    public $pageLang;

    /**
     * BreadCrumb constructor.
     * @param PageLang $pageLang
     * @param string $url
     * @param bool $active
     */
    public function __construct(PageLang $pageLang, $url, $active = false)
    {
        $this->url = $url;
        $this->name = $pageLang->name;
        $this->active = $active;

        $this->pageLang = $pageLang;
    }

}