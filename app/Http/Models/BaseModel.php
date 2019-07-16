<?php
/**
 * QuynhTM
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model {

    function getFieldTable(){
        $fields= Schema::getColumnListing($this->getTable());
        return $fields;
    }

    function checkFieldInTable($dataInput = [])
    {
        $dataDB = array();
        $field_table = $this->getFieldTable();
        if (empty($dataInput) && empty($field_table))
            return $dataDB;

        if (!empty($field_table)) {
            foreach ($field_table as $field) {
                if (isset($dataInput[$field])) {
                    $dataDB[$field] = $dataInput[$field];
                }
            }
        }
        return $dataDB;
    }

    public function getFieldsSearch($dataSearch = array()){
        $fields = array();
        if(isset($dataSearch['field_get'])){
            if(is_array($dataSearch['field_get'])){
                $fields = $dataSearch['field_get'];
            }else{
                $fields = (trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            }
        }
        return $fields;
    }

    /**
     * QuynhTM add insert multiple
     * @param $table
     * @param $dataInput
     * @return bool|int
     */
    public function insertMultiple($dataInput){

        $fieldInput = [];
        foreach ($dataInput as $k =>$data_va){
            $fieldInput[] = $this->checkFieldInTable($data_va);
        }
        if(empty($fieldInput))
            return true;
        $str_sql = buildSqlInsertMultiple($this->table, $fieldInput);
        if(trim($str_sql) != ''){
            if(DB::statement($str_sql)){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }
}