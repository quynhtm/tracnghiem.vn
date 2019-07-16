<?php
/**
 * QuynhTM
 */

namespace App\Http\Models\Shop;

use App\Http\Models\BaseModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\library\AdminFunction\Memcache;

class OrderItem extends BaseModel
{
    protected $table = TABLE_ORDER_ITEM;
    protected $primaryKey = 'order_item_id';
    public $timestamps = false;

    //cac truong trong DB
    /*protected $fillable = array('order_item_id','order_id',
        'product_id', 'product_name', 'product_price_sell',
        'product_price_input', 'product_image', 'product_category_id',
        'product_category_name', 'product_type_price', 'product_province', 'product_provider', 'number_buy');*/
    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = OrderItem::where('order_item_id', '>', 0);
            if (isset($dataSearch['provider_name']) && $dataSearch['provider_name'] != '') {
                $query->where('provider_name', 'LIKE', '%' . $dataSearch['provider_name'] . '%');
            }
            if (isset($dataSearch['provider_phone']) && $dataSearch['provider_phone'] != '') {
                $query->where('provider_phone', 'LIKE', '%' . $dataSearch['provider_phone'] . '%');
            }
            if (isset($dataSearch['provider_email']) && $dataSearch['provider_email'] != '') {
                $query->where('provider_email', 'LIKE', '%' . $dataSearch['provider_email'] . '%');
            }
            if (isset($dataSearch['provider_status']) && $dataSearch['provider_status'] != -1) {
                $query->where('provider_status', $dataSearch['provider_status']);
            }
            if (isset($dataSearch['member_id']) && $dataSearch['member_id'] != -1) {
                if ($dataSearch['member_id'] == 0) {
                    $query->where('member_id', '>=', $dataSearch['member_id']);
                } else {
                    $query->where('member_id', $dataSearch['member_id']);
                }
            }
            if (isset($dataSearch['order_item_id']) && $dataSearch['order_item_id'] > 0) {
                $query->where('order_item_id', $dataSearch['order_item_id']);
            }
            if (isset($dataSearch['member_id']) && $dataSearch['member_id'] > 0) {
                $query->where('member_id', $dataSearch['member_id']);
            }
            $total = ($is_total) ? $query->count() : 0;
            $query->orderBy('provider_status', 'desc');

            //get field can lay du lieu
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
            $item = new OrderItem();
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->save();
                self::removeCache($item->order_item_id, $item);
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
            $item = self::getItemById($id);
            if ($item) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->update();
                self::removeCache($item->order_item_id, $item);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_ORDER_ITEM_ID . $id);
        if (!$data) {
            $data = OrderItem::where('order_item_id',$id)->first();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ORDER_ITEM_ID . $id, $data);
            }
        }
        return $data;
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
        } catch (\PDOException $e) {
            throw new \PDOException();
            return false;
        }
    }

    public function removeCache($id = 0, $data)
    {
        if ($id > 0) {
            Memcache::forgetCache(Memcache::CACHE_ORDER_ITEM_ID . $id);
        }
        if ($data) {}
    }

    public function getOrderItemShopByID($id, $member_id)
    {
        $provider = OrderItem::getItemById($id);
        if (sizeof($provider) > 0) {
            if ($provider->member_id == $member_id) {
                return $provider;
            }
        }
        return array();
    }
}
