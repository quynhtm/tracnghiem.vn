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


class VmDefine extends BaseModel
{
    protected $table = TABLE_DEFINE;
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function searchByCondition($dataSearch = array(), $limit = STATUS_INT_KHONG, $offset = STATUS_INT_KHONG, $is_total = true)
    {
        try {
            $query = VmDefine::where('id', '>', STATUS_INT_KHONG);
            if (isset($dataSearch['define_name']) && $dataSearch['define_name'] != '') {
                $query->where('define_name', 'LIKE', '%' . $dataSearch['define_name'] . '%');
            }
            if (isset($dataSearch['define_code']) && $dataSearch['define_code'] != '') {
                $query->where('define_code', $dataSearch['define_code']);
            }
            if (isset($dataSearch['define_status']) && $dataSearch['define_status'] > -1) {
                $query->where('define_status', $dataSearch['define_status']);
            }
            if (isset($dataSearch['define_type']) && $dataSearch['define_type'] > STATUS_INT_KHONG) {
                $query->where('define_type', $dataSearch['define_type']);
            }
            $total = ($is_total) ? $query->count() : STATUS_INT_KHONG;

            $query->orderBy('define_status', 'asc');
            $query->orderBy('define_order', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];

        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = new VmDefine();
                if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                    foreach ($fieldInput as $k => $v) {
                        $item->$k = $v;
                    }
                }
                $item->user_id_creater = app(User::class)->user_id();
                $item->user_name_creater = app(User::class)->user_name();
                $item->save();
                self::removeCache($item->id, $item);
                return $item->id;
            }
            return STATUS_INT_KHONG;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                $item = self::getItemById($id);
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_update = app(User::class)->user_id();
                $item->user_name_update = app(User::class)->user_name();
                $item->update();
                self::removeCache($item->id, $item);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_VMDEFINE_ID.$id);
        if (!$data) {
            $data = VmDefine::find($id);
            if ($data) {
                Memcache::putCache(Memcache::CACHE_VMDEFINE_ID.$id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= STATUS_INT_KHONG) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
                self::removeCache($id, $dataOld);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
            return false;
        }
    }

    public function removeCache($id = STATUS_INT_KHONG, $data = [])
    {
        if ($id > STATUS_INT_KHONG) {
            Memcache::forgetCache(Memcache::CACHE_VMDEFINE_ID . $id);
        }
        if ($data && isset($data->define_type)) {
            Memcache::forgetCache(Memcache::CACHE_VMDEFINE_BY_TYPE . $data->define_type);
        }
    }

    public function getDataByType($define_type = STATUS_INT_KHONG)
    {
        if ($define_type == STATUS_INT_KHONG) return [];
        $data = Memcache::getCache(Memcache::CACHE_VMDEFINE_BY_TYPE.$define_type);
        if (!$data) {
            $data = VmDefine::where('id', '>', STATUS_INT_KHONG)
                ->where('define_type', $define_type)
                ->orderBy('define_order', 'asc')->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_VMDEFINE_BY_TYPE.$define_type, $data);
            }
        }
        return $data;
    }

    public function getOptionNameByType($define_type = STATUS_INT_KHONG, $define_status = true)
    {
        if ($define_type == STATUS_INT_KHONG) return [];
        $arrOption = [];
        $data = self::getDataByType($define_type);
        if ($data || $data->count() > STATUS_INT_KHONG) {
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

    public function getOptionColorByType($define_type = STATUS_INT_KHONG, $define_status = true)
    {
        if ($define_type == STATUS_INT_KHONG) return [];
        $arrOption = [];
        $data = self::getDataByType($define_type);
        if ($data || $data->count() > STATUS_INT_KHONG) {
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

    public function getArrByType($define_type){
        $data = $this->getDataByType($define_type);
        $result = [];
        if($data->count() > STATUS_INT_KHONG){
            foreach($data as $item){
                $result[$item->id] = $item->define_name;
            }
        }
        return $result;
    }
}
