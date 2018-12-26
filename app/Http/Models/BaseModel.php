<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model {

    public  function  getDataResource($request, $flgEncode = true) {
        $fields = $this->fillable;
        $data = array();
        if(!empty($fields)) {
            foreach($fields as $field) {
               if($request::exists($field)) {
                   $data[$field] = ($flgEncode) ? urldecode($request::get($field)) : $request::get($field);
               }
            }
        }
        return $data;
    }

    public function getDataArray($aryData = array(), $flgEncode = true) {
        $fields = $this->fillable;
        if(empty($fields) && empty($aryData)) {
            return array();
        }
        $data = array();
        if(is_array($fields)) {
            foreach($fields as $field) {
                if(isset($aryData->$field)) {
                    $data[$field] = ($flgEncode) ? urldecode($aryData->$field) : $aryData->$field;
                }
            }
        }
        return $data;
    }

    function checkFieldInTable($dataInput = [])
    {
        $dataDB = array();
        if (empty($dataInput) && empty($this->fillable))
            return $dataDB;

        if (!empty($this->fillable)) {
            foreach ($this->fillable as $field) {
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

    public function getTotalCount($objQuery){
        return $objQuery->get([$this->primaryKey])->count();
    }

    public function conditionQuery($objQuery, $dataSearch=array()) {
        if (isset($dataSearch['s_date']) && $dataSearch['s_date'] != '') {
            $objQuery->where(DB::raw('DATE_FORMAT(created_at, "%Y%m%d")'), '>=', date('Ymd', strtotime($dataSearch['s_date'])));
        }
        if (isset($dataSearch['e_date']) && $dataSearch['e_date'] != '') {
            $objQuery->where(DB::raw('DATE_FORMAT(created_at, "%Y%m%d")'), '<=', date('Ymd', strtotime($dataSearch['e_date'])));
        }
        if (isset($dataSearch['group_by']) && $dataSearch['group_by' != '']) {
            $objQuery->groupBy($dataSearch['group_by']);
        }
        if(isset($dataSearch['sort']) && count($dataSearch['sort']) > 0){
            foreach ($dataSearch['sort'] as $field => $sortOrder) {
                $objQuery->orderBy($field, $sortOrder);
                break;
            }
        }else{
            $objQuery->orderBy($this->primaryKey, 'desc');
        }
        return $objQuery;
    }

    public function searchESByCondition($dataSearch = array(), $limit = 0, $offset = 0, $isTotal = true){
        try {
            $query = $this->query();
            $query = $this->conditionQuery($query, $dataSearch);
            $total = ($isTotal) ? $this->getTotalCount($query) : 0;
            $fields = $this->getFieldsSearch($dataSearch);
            if (!empty($fields)) {
                if ($limit > 0) {
                    $result = $query->take($limit)->skip($offset)->get($fields);
                } else {
                    $result = $query->get($fields);
                }
            } else {
                if ($limit > 0) {
                    $result = $query->take($limit)->skip($offset)->get();
                } else {
                    $result = $query->get();
                }
            }
            $data['data'] = $result;
            $data['total'] = $total;
            return $data;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function getAll($limit = LIMIT_RECORD_30, $offset = 0, $fieldGet = []) {
        $data = (\App\Library\AdminFunction\Memcache::CACHE_ON)? \Cache::get($this->getTable()): false;
        if (!$data) {
            if (self::count() > $limit) {
                $data = self::limit($limit)->offset($offset)->get($fieldGet);
                return $data;
            }
            $data = self::get($fieldGet);
            if ($data){
                \Cache::put($this->getTable(), $data, CACHE_ONE_MONTH);
            }
        }
        return $data;
    }

    /**
     * @param $condition
     * @return mixed
     * @author ChienKV <khuongchien@gmail.com>
     */
    public function getStatisticData($condition){
        $group_by = trim($condition['group_by']);
        $_query = [];
        $_query[] = $group_by;
        $_query[] = 'COUNT('.$group_by.') AS total';
        if (!empty($condition['statistic'])):
            foreach ($condition['statistic'] as $function => $fields):
                foreach ($fields as $field => $alias):
                    $_query[] = $function.'('.$field.') AS '.$alias;
                endforeach;
            endforeach;
        endif;

        $_query = self::selectRaw(implode(',', $_query))->groupBy($group_by);

        if (!empty($condition['condition'])):
            foreach ($condition['condition'] as $field => $value):
                $_query->where($field, $value);
            endforeach;
        endif;

        return $_query->get()->keyBy($group_by)->toArray();
    }

    /**
     * QuynhTM add insert multiple
     * @param $table
     * @param $dataInput
     * @return bool|int
     */
    public function insertMultiple($dataInput){
        //check field tồn tại trong DB
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