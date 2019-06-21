<?php namespace Modules\CMS\Libraries\Blocks;

use Modules\CMS\Entities\Block;
use URL;
use View;

class Map extends AbstractBlock
{

    /**
     * @var string
     */
    protected $_renderDataName = 'map';

    /**
     * Image constructor.
     * @param Block $block
     */
    public function __construct(Block $block)
    {
        parent::__construct($block);
        $this->_displayViewDirs[] = 'map';
    }

    /**
     * Display image, image can be cropped with croppa
     * @param string $content
     * @param array $options
     * @return string
     */
    public function display($content, $options = [])
    {
        $mapData = $this->_defaultData($content);

        if (empty($mapData->lat) || empty($mapData->long)) {
            return '';
        }

        $mapData->extra_attrs = '';
        $ignoreAttributes = [];
        foreach ($options as $option => $val) {
            if (!in_array($option, $ignoreAttributes)) {
                $mapData->extra_attrs .= $option . '="' . $val . '"';
            }
        }

        return $this->_renderDisplayView($options, $mapData);
    }

    /**
     * Load image block data with domain relative paths
     * @param string $content
     * @return string
     */
    public function edit($content)
    {
        $mapData = $this->_defaultData($content);
        return parent::edit($mapData);
    }

    /**
     * Save image block data
     * @param array $postContent
     * @return static
     */
    public function submit($postContent)
    {
        if (!empty($postContent['long']) || !empty($postContent['lat'])) {
            $mapData = $this->_defaultData('');
            $mapData->long = !empty($postContent['long']) ? $postContent['long'] : '';
            $mapData->lat = !empty($postContent['lat']) ? $postContent['lat'] : '';
        } else {
            $mapData = '';
        }
        return $this->save($mapData ? serialize($mapData) : '');
    }

    /**
     * Return valid image data
     * @param $content
     * @return \stdClass
     */
    protected function _defaultData($content)
    {
        $content = @unserialize($content);
        if (empty($content) || !is_a($content, \stdClass::class)) {
            $content = new \stdClass;
        }
        $content->long = empty($content->long) ? '' : $content->long;
        $content->lat = empty($content->lat) ? '' : $content->lat;
        return $content;
    }
}
