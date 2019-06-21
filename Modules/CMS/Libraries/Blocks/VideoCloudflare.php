<?php namespace Modules\CMS\Libraries\Blocks;

use Modules\CMS\Entities\Block;
use PageBuilder;
use View;

class VideoCloudflare extends AbstractBlock
{

    /**
     * @var string
     */
    protected $_renderDataName = 'videoCloudFlare';

    /**
     * Image constructor.
     * @param Block $block
     */
    public function __construct(Block $block)
    {
        parent::__construct($block);
        $this->_displayViewDirs[] = 'videocloudflare';
    }

    /**
     * Frontend display for the block
     * @param string $content
     * @param array $options
     * @return string
     */
    public function display($content, $options = [])
    {
        if (!empty($content)) {
            $videoInfo = new \stdClass();
            $videoInfo->id = str_replace('https://watch.cloudflarestream.com/', '', $content);
            $videoInfo->extra_attrs = [];
            $videoExtras = [
                'width' => '80%',
                'index' => ''
            ];
            foreach ($videoExtras as $extra => $value) {
                $videoInfo->extra_attrs[$extra] = isset($options[$extra]) ? $options[$extra] : $value;
            }
            return $this->_renderDisplayView($options, $videoInfo);
        } else {
            return '';
        }

        return parent::display($content, $options);
    }

}
