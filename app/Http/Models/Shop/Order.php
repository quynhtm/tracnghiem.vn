<?php
/**
 * QuynhTM
 */

namespace App\Http\Models\Shop;

use App\Http\Models\Admin\User;
use App\Http\Models\BaseModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\library\AdminFunction\Memcache;

class Order extends BaseModel
{
    protected $table = TABLE_ORDER;
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    //cac truong trong DB
    /*protected $fillable = array('order_id','order_product_id',
        'order_customer_name','order_customer_phone', 'order_customer_email', 'order_customer_address','order_customer_note',
        'order_product_id', 'order_total_money','order_total_buy','order_money_ship',
        'order_is_cod','order_user_shipper_id', 'order_user_shipper_name',
        'order_user_shop_id', 'order_user_shop_name',
        'order_status','order_type', 'order_note', 'order_time_pay',
        'order_time_creater','order_time_update');*/
    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = Order::where('order_id', '>', 0);
            if (isset($dataSearch['order_product_id']) && $dataSearch['order_product_id'] != '') {
                $query->where('order_product_id', 'LIKE', '%' . $dataSearch['order_product_id'] . '%');
            }
            if (isset($dataSearch['order_total_buy']) && $dataSearch['order_total_buy'] != '') {
                $query->where('order_total_buy', 'LIKE', '%' . $dataSearch['order_total_buy'] . '%');
            }
            if (isset($dataSearch['order_note']) && $dataSearch['order_note'] != '') {
                $query->where('order_note', 'LIKE', '%' . $dataSearch['order_note'] . '%');
            }
            if (isset($dataSearch['order_money_ship']) && $dataSearch['order_money_ship'] != '') {
                $query->where('order_money_ship', 'LIKE', '%' . $dataSearch['order_money_ship'] . '%');
            }
            if (isset($dataSearch['order_total_money']) && $dataSearch['order_total_money'] != '') {
                $query->where('order_total_money', 'LIKE', '%' . $dataSearch['order_total_money'] . '%');
            }
            if (isset($dataSearch['order_product_name']) && $dataSearch['order_product_name'] != '') {
                $query->where('order_product_name', 'LIKE', '%' . $dataSearch['order_product_name'] . '%');
            }
            if (isset($dataSearch['order_customer_name']) && $dataSearch['order_customer_name'] != '') {
                $query->where('order_customer_name', 'LIKE', '%' . $dataSearch['order_customer_name'] . '%');
            } //provider_name - provider_email - provider_phone - provider_status
            if (isset($dataSearch['order_customer_phone']) && $dataSearch['order_customer_phone'] != '') {
                $query->where('order_customer_phone', 'LIKE', '%' . $dataSearch['order_customer_phone'] . '%');
            }
            if (isset($dataSearch['order_customer_email']) && $dataSearch['order_customer_email'] != '') {
                $query->where('order_customer_email', 'LIKE', '%' . $dataSearch['order_customer_email'] . '%');
            }
            if (isset($dataSearch['order_customer_address']) && $dataSearch['order_customer_address'] != '') {
                $query->where('order_customer_address', 'LIKE', '%' . $dataSearch['order_customer_address'] . '%');
            }
            if (isset($dataSearch['order_customer_note']) && $dataSearch['order_customer_note'] != '') {
                $query->where('order_customer_note', 'LIKE', '%' . $dataSearch['order_customer_note'] . '%');
            }
            if (isset($dataSearch['order_type']) && $dataSearch['order_type'] != '') {
                $query->where('order_type', 'LIKE', '%' . $dataSearch['order_type'] . '%');
            }
            if (isset($dataSearch['order_status']) && $dataSearch['order_status'] != -1) {
                $query->where('order_status', $dataSearch['order_status']);
            }
            if (isset($dataSearch['order_id']) && $dataSearch['order_id'] > 0) {
                $query->where('order_id', $dataSearch['order_id']);
            }

            $total = $is_total ? $query->count() : 0;
            $query->orderBy('order_id', 'desc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result ,'total' => $total ];

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new Order();
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->save();
                self::removeCache($item->order_id, $item);
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
                self::removeCache($item->order_id, $item);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_ORDER_ID . $id);
        if (!$data) {
            $data = Order::where('order_id',$id)->first();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ORDER_ID . $id, $data);
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

    public function removeCache( $id = 0 , $data)
    {
        if ($id > 0) {
            Memcache::forgetCache(Memcache::CACHE_ORDER_ID . $id);
        }
        if ($data) {}
    }
}
