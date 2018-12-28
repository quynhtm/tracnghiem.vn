<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Models\Admin;

use App\Http\Models\BaseModel;

use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class VmDefine extends BaseModel
{
    protected $table = TABLE_DEFINE;
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = array('define_code', 'define_name','define_color', 'define_type', 'type_item','object_id', 'define_order', 'define_status', 'define_value_min', 'define_value_max',
        'define_note', 'created_at', 'updated_at', 'user_id_creater', 'user_name_creater', 'user_id_update', 'user_name_update');

    public function conditionQuery($objQuery, $dataSearch = array())
    {
        $objQuery->where('id', '>', 0);
        if (!empty($dataSearch['id'])) {
            if (is_array($dataSearch['id']))
                $objQuery->whereIn('id', $dataSearch['id']);
            else
                $objQuery->where('id', $dataSearch['id']);
        }

        if (isset($dataSearch['define_type'])) {
            if (is_array($dataSearch['define_type']))
                $objQuery->whereIn('define_type', $dataSearch['define_type']);
            else
                $objQuery->where('define_type', $dataSearch['define_type']);
        }
        if (isset($dataSearch['define_status'])) {
            if (is_array($dataSearch['define_status']))
                $objQuery->whereIn('define_status', $dataSearch['define_status']);
            else
                $objQuery->where('define_status', $dataSearch['define_status']);
        }
        if (isset($dataSearch['define_name']) && $dataSearch['define_name'] != '') {
            $objQuery->where('define_name','like','%'.$dataSearch['define_name'].'%');
        }

        parent::conditionQuery($objQuery, $dataSearch);
        return $objQuery;
    }

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = VmDefine::where('id', '>', 0);
            if (isset($dataSearch['define_name']) && $dataSearch['define_name'] != '') {
                $query->where('define_name', 'LIKE', '%' . $dataSearch['define_name'] . '%');
            }
            if (isset($dataSearch['define_code']) && $dataSearch['define_code'] != '') {
                $query->where('define_code', $dataSearch['define_code']);
            }
            if (isset($dataSearch['define_status']) && $dataSearch['define_status'] > -1) {
                $query->where('define_status', $dataSearch['define_status']);
            }
            if (isset($dataSearch['define_type']) && $dataSearch['define_type'] > 0) {
                $query->where('define_type', $dataSearch['define_type']);
            }
            $total = ($is_total) ? $query->count() : 0;

            $query->orderBy('define_status', 'asc');
            $query->orderBy('define_order', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new VmDefine();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
            }
            $item->user_id_creater = app(User::class)->user_id();
            $item->user_name_creater = app(User::class)->user_name();
            $item->save();
            self::removeCache($item->id, $item);
            return $item->id;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = self::getItemById($id);
            foreach ($fieldInput as $k => $v) {
                $item->$k = $v;
            }
            $item->user_id_update = app(User::class)->user_id();
            $item->user_name_update = app(User::class)->user_name();
            $item->update();
            self::removeCache($item->id, $item);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function getItemById($id)
    {
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_VMDEFINE_ID . $id) : false;
        if (!$data) {
            $data = VmDefine::find($id);
            if ($data) {
                Cache::put(Memcache::CACHE_VMDEFINE_ID . $id, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public function getDataByType($define_type = 0)
    {
        if ($define_type == 0) return [];
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_VMDEFINE_BY_TYPE . $define_type) : false;
        if (!$data) {
            $data = VmDefine::where('id', '>', 0)
                ->where('define_type', $define_type)
                ->orderBy('define_order', 'asc')->get();
            if ($data) {
                Cache::put(Memcache::CACHE_VMDEFINE_BY_TYPE . $define_type, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public function getOptionNameByType($define_type = 0, $define_status = true)
    {
        if ($define_type == 0) return [];
        $arrOption = [];
        $data = self::getDataByType($define_type);
        if ($data || $data->count() > 0) {
            foreach ($data as $v) {
                if ($define_status && $v->define_status == STATUS_SHOW) {
                    $arrOption[$v->id] = $v->define_name;
                } else {
                    $arrOption[$v->id] = $v->define_name;
                }
            }
        }
        return $arrOption;
    }
    public function getOptionColorByType($define_type = 0, $define_status = true)
    {
        if ($define_type == 0) return [];
        $arrOption = [];
        $data = self::getDataByType($define_type);
        if ($data || $data->count() > 0) {
            foreach ($data as $v) {
                if ($define_status && $v->define_status == STATUS_SHOW) {
                    $arrOption[$v->id] = ['name'=>$v->define_name,'color'=>$v->define_color];
                } else {
                    $arrOption[$v->id] = ['name'=>$v->define_name,'color'=>$v->define_color];
                }
            }
        }
        return $arrOption;
    }

    public function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
                self::removeCache($id, $dataOld);
            }
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
            return false;
        }
    }

    public function removeCache($id = 0, $data = [])
    {
        if ($id > 0) {
            Cache::forget(Memcache::CACHE_VMDEFINE_ID . $id);
        }
        if ($data && isset($data->define_type)) {
            Cache::forget(Memcache::CACHE_VMDEFINE_BY_TYPE . $data->define_type);
        }
    }
}
