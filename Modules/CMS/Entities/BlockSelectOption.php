<?php namespace Modules\CMS\Entities;

use Eloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

Class BlockSelectOption extends Eloquent
{
    public $translatedAttributes = ['option'];

    protected $table = 'cms_block_selectopts';

    public function brand() {
        return $this->hasOne('Modules\Admin\Entities\Brand', 'id', 'brand_id');
    }
    public function country(){
        return $this->hasOne('Modules\Admin\Entities\Country', 'id', 'country_id');
    }

    public static function import($block_id, $inputOptions)
    {
        $databaseOptions = [];
        $options = self::where('block_id', '=', $block_id)->get();
        if (!$options->isEmpty()) {
            foreach ($options as $option) {
                $databaseOptions[$option->value] = $option;
            }
        }

        $toAdd = array_diff_key($inputOptions, $databaseOptions);
        $toUpdate = array_intersect_key($inputOptions, $databaseOptions);
        $toDelete = array_diff_key($databaseOptions, $inputOptions);

        if (!empty($toDelete)) {
            self::where('block_id', '=', $block_id)->whereIn('value', array_map('strval', array_keys($toDelete)))->delete();
        }

        if (!empty($toAdd)) {
            foreach ($toAdd as $value => $option) {
                $newBlockSelectOption = new self;
                $newBlockSelectOption->block_id = $block_id;
                $newBlockSelectOption->value = $value;
                $newBlockSelectOption->option = $option;
                $newBlockSelectOption->save();
            }
        }

        if (!empty($toUpdate)) {
            foreach ($toUpdate as $value => $option) {
                if ($option != $databaseOptions[$value]->option) {
                    $databaseOptions[$value]->option = $option;
                    $databaseOptions[$value]->save();
                }
            }
        }
    }

    public static function getOptionsArray($blockName)
    {
        $optionsArray = [];
        $blockId = Block::preload($blockName)->id;
        $options = self::where('block_id', '=', $blockId)->get();
        foreach ($options as $option) {
            $optionsArray[$option->value] = $option->option;
        }
        return $optionsArray;
    }

    /**
     * @return Collection
     */
    public static function blockNamesWithOptions()
    {
        $blockTable = (new Block)->getTable();
        $selectTable = (new static)->getTable();
        return static::select($blockTable.'.name')->groupBy($blockTable.'.name')->join($blockTable, function ($join) use ($blockTable, $selectTable) {
            $join->on($blockTable.'.id', '=', $selectTable.'.block_id');
        })->get()->keyBy('name')->keys();
    }

    public static function getOptionsArrayGroupValues($blockName)
    {
//        dd(session()->get('adminLocale'));
        $optionsArray = [];
        $blockId = Block::preload($blockName)->id;
        $options = BlockSelectOption::where([
            ['block_id', '=', $blockId],
            ['active', '=', 1],
        ])->get()->all();
        foreach ($options as $option) {
            $optionsArray[$option->value]['data'] = $option;
            $optionsArray[$option->value]['lang'][$option->locale]['locale'] = $option->option;
            $optionsArray[$option->value]['lang'][$option->locale]['id'] = $option->id;
        }
        return $optionsArray;
    }

    public static function saveDataTextOption( $blockId, $data){

        try {
            DB::beginTransaction();
            $databaseOptions = [];
            $options = self::where([
                    ['block_id', '=', $blockId],
                    ['active', '=', 1],
                ])->get();
            if (!$options->isEmpty()) {
                foreach ($options as $option) {
                    $databaseOptions[$option->id] = $option;
                }
            }
            if (!empty($data)) {
                //Foreach para recorrer y armar los arrays para el insertado/actualizado de los registros en la BD
                foreach ($data as $options) {
                    //Foreach para armar los arrays por lenguaje definido dentro de la vista
                    foreach ($options['lang'] as $idLang => $optLang) {
                        //Condicional para cotejar que exista el registro de la vista contra los obtenidos de la BD, en caso de que no exista se toma como nuevo registro
                        if (($optLang['id_option'] != 0) && (isset($databaseOptions[$optLang['id_option']]))) {
                            $databasesave = $databaseOptions[$optLang['id_option']];

                            //Se quita el registro para evitar su eliminado posterior de la BD
                            unset($databaseOptions[$optLang['id_option']]);

                        } else {
                            $databasesave = new BlockSelectOption();
                            $databasesave->id = $optLang['id_option'];
                            $databasesave->block_id = $blockId;
                        }

                        //Condicional para que si no existe el dato de idioma dentro del Request no se proceda a guardar o actualizar,
                        if(($optLang['option'] != null && !empty($optLang['option'])) || $optLang['id_option'] != 0) {
                            $databasesave->option = $optLang['option'];
                            $databasesave->locale = $optLang['locale_key'];

                            $databasesave->value = $options['value'] != null ? $options['value'] : '';
                            //$databasesave->brand_id = $options['brand_id'];
                            //$databasesave->country_id = $options['country_id'];
                            $databasesave->type = 'text';
                            $databasesave->save();
                            $databasesave = null;
                        }
                    }
                }
                // Código para el eliminado de todos los registro que no encontraron coincidentes con los obtenidos de la vista
                if (!empty($databaseOptions)) {
                    foreach ($databaseOptions as $dbOpt) {
                        $dbOpt->active = 0;
                        $dbOpt->save();
                    }
                }
            }
            DB::commit();
            return array('success' => true, 'type_msg' => 'success', 'msg' => trans('admin::themes.msgs.register_saved'));
        }catch (\Exception $ex) {
            DB::rollback();
            return array('success' => true, 'type_msg' => 'danger', 'msg' => trans('admin::themes.msgs.error_bd'));

        }
    }
}