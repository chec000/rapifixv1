<?php namespace Modules\CMS\Entities;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;

class PageBlockRepeaterRows extends Eloquent
{
    use DataPreLoad;

    protected $table = 'cms_page_blocks_repeater_rows';

    protected static function preloadRepeater($repeaterId)
    {
        $key = 'repeater' . $repeaterId;
        if (!static::_preloadIsset($key)) {
            $data = static::where('repeater_id', '=', $repeaterId)->get();
            static::_preloadOnce($data, $key, ['row_id']);
        }
        return static::_preloadGetArray($key);
    }

    public static function addRowKey($repeaterId, $rowId)
    {
        $repeaterRows = static::preloadRepeater($repeaterId);
        if (!isset($repeaterRows[$rowId])) {
            $repeater_row = new PageBlockRepeaterRows;
            $repeater_row->repeater_id = $repeaterId;
            $repeater_row->row_id = $rowId;
            $repeater_row->save();
            $repeaterRows[$rowId] = $repeater_row;
            static::_preloadAdd('repeater' . $repeaterId, $rowId, $repeater_row);
        }
        return $repeaterRows[$rowId]->id;
    }

    public static function getRowKey($repeaterId, $rowId)
    {
        $repeaterRows = static::preloadRepeater($repeaterId);
        return empty($repeaterRows[$rowId]) ? 0 : $repeaterRows[$rowId]->id;
    }

    public static function getRowIds($repeaterId)
    {
        $rowsByKey = [];
        $repeaterRows = static::preloadRepeater($repeaterId);
        foreach ($repeaterRows as $rowId => $repeaterRow) {
            $rowsByKey[$repeaterRow->id] = $rowId;
        }
        return $rowsByKey;
    }

    public static function nextFreeRepeaterId()
    {
        $highestRepeaterId = static::orderBy('repeater_id', 'desc')->first();
        $newRepeaterId = ($highestRepeaterId ? $highestRepeaterId->repeater_id : 0) + 1;
        static::addRowKey($newRepeaterId, 0);
        return $newRepeaterId;
    }

    public static function nextFreeRepeaterRowId($repeaterId)
    {
        $highestRepeaterRowId = static::where('repeater_id', '=', $repeaterId)->orderBy('row_id', 'desc')->first();
        $newRowId = ($highestRepeaterRowId ? $highestRepeaterRowId->row_id : 0) + 1;
        static::addRowKey($repeaterId, $newRowId);
        return $newRowId;
    }

    public static function getRowIdsInSearch($repeaterId, $search)
    {
        $rowsByKey = [];
        $repeaterRows = static::preloadRepeaterSearch($repeaterId, $search);
        foreach ($repeaterRows as $rowId => $repeaterRow) {
            $rowsByKey[$repeaterRow->row_key] = $rowId;
        }
        return $rowsByKey;
    }

    protected static function preloadRepeaterSearch($repeaterId, $search)
    {
        $key = 'repeater' . $repeaterId;
        if (!static::_preloadIsset($key)) {
            $data = static::join(
                'cms_page_blocks_repeater_data',
                'cms_page_blocks_repeater_data.row_key',
                '=',
                'cms_page_blocks_repeater_rows.id'
            )->where('cms_page_blocks_repeater_rows.repeater_id', '=', $repeaterId)
                ->where('cms_page_blocks_repeater_data.content', 'LIKE', '%'.$search.'%')->get();
            static::_preloadOnce($data, $key, ['row_id']);
        }
        return static::_preloadGetArray($key);
    }
}
