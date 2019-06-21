<?php namespace Modules\CMS\Libraries\Blocks;

use Modules\CMS\Entities\Block;
use URL;
use View;

class VideoUploaded extends AbstractBlock
{

    /**
     * @var string
     */
    protected $_renderDataName = 'videouploaded';

    /**
     * VideoUploaded constructor.
     * @param Block $block
     */
    public function __construct(Block $block)
    {
        parent::__construct($block);
        $this->_displayViewDirs[] = 'videouploaded';
    }

    /**
     * Load image block data with domain relative paths
     * @param string $content
     * @return string
     */
    public function edit($content)
    {
        $content = str_replace(URL::to('/'), '', $content);
        return parent::edit($content);
    }

    /**
     * Save image block data
     * @param array $postContent
     * @return static
     */
    public function submit($postContent)
    {
        $path = (!empty($postContent['source'])) ? $postContent['source'] : '';
        if ($path != '') {
            $pathParts = pathinfo($path);
            $path = $pathParts['dirname'] . '/' . $pathParts['filename'];
        }
        $videoData = $path;
        return parent::submit($videoData);
    }

}
