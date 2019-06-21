<?php namespace Modules\CMS\Events\Page;

use Modules\CMS\Helpers\Page\Search\Cms;

class Search
{
    /**
     * @var Cms[]
     */
    public $searchObjects;

    /**
     * @var bool
     */
    public $onlyLive;

    /**
     * LoadAuth constructor.
     * @param Cms[] $searchObjects
     * @param bool $onlyLive
     */
    public function __construct(&$searchObjects, &$onlyLive)
    {
        $this->searchObjects = &$searchObjects;
        $this->onlyLive = &$onlyLive;
    }
    
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

}
