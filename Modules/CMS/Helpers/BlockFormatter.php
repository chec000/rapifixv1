<?php namespace Modules\CMS\Helpers;

class BlockFormatter
{
    public static function ambassadorInfo($info, $trans, $options = '')
    {
        if ($info != '') {
            if ($options == 'span') {
                return '<div class="ambassador--description__info"><span>' . $trans . ':</span> <span>' . $info . '</span></div>';
            }
            return '<div class="ambassador--description__info"><span>' . $trans . ':</span> ' . $info . '</div>';
        }
        return '';
    }

    public static function smallButton($text)
    {
        if ($text != '') {
            return '<button class="button small">' . $text . '</button>';
        }
        return '';
    }

    public static function contactCREO($text, $trans)
    {
        if ($text != '') {
            return '<strong>' . $trans . ':</strong> ' . $text;
        }
        return '';
    }

    public static function validateBlocks($blocks)
    {
        for ($i=0; $i < count($blocks); $i++) {
            if ($blocks[$i] != '') {
                return true;
            }
        }
        return false;
    }
}
