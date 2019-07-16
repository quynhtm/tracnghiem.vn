<?php
/**
 * QuynhTM
 */

namespace App\Http\Models\Shop;

use App\Http\Models\BaseModel;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Request;

class Product extends BaseModel
{
    protected $table = TABLE_PRODUCT;
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    //cac truong trong DB
    /*protected $fillable = array('product_id','product_code', 'product_name', 'category_name', 'depart_id','category_id',
         'provider_id', 'product_price_sell', 'product_price_market', 'product_price_input', 'product_price_provider_sell',
        'product_type_price','product_selloff', 'product_is_hot', 'product_sort_desc', 'product_content','product_image',
        'product_image_hover','product_image_other', 'product_order', 'quality_input','quality_out','product_status',
        'is_block','is_sale', 'user_shop_id', 'user_shop_name', 'is_shop','province_id',
        'created_at','user_id_creater','user_name_creater',
        'updated_at','user_id_update','user_name_update', 'product_note');*/

    /**
     * @param $shop_id
     * @param $id
     * @return array
     */
    public function searchByCondition($dataSearch = array(), $limit =0, $offset=0, $is_total=true){
        try{
            $query = Product::where('product_id','>',0);
            if (isset($dataSearch['is_block']) && $dataSearch['is_block'] != -1) {
                $query->where('is_block', $dataSearch['is_block']);
            }
            if (isset($dataSearch['product_status']) && $dataSearch['product_status'] != -1) {
                $query->where('product_status', $dataSearch['product_status']);
            }

            if (isset($dataSearch['product_name']) && $dataSearch['product_name'] != '') {
                $query->where('product_name','LIKE', '%' . $dataSearch['product_name'] . '%');
            }
            if (isset($dataSearch['product_id']) && $dataSearch['product_id'] != 0) {
                $query->where('product_id', $dataSearch['product_id']);
            }

            if (isset($dataSearch['category_id']) && $dataSearch['category_id'] != -1) {
                $query->where('category_id', $dataSearch['category_id']);
            }
            if (isset($dataSearch['provider_id']) && $dataSearch['provider_id'] != -1) {
                $query->where('provider_id', $dataSearch['provider_id']);
            }
            if (isset($dataSearch['user_shop_id']) && $dataSearch['user_shop_id'] != 0) {
                $query->where('user_shop_id', $dataSearch['user_shop_id']);
            }
            if (isset($dataSearch['user_id_creater']) && $dataSearch['user_id_creater'] != 0) {
                $query->where('user_id_creater', $dataSearch['user_id_creater']);
            }
            if (isset($dataSearch['user_id']) && $dataSearch['user_id'] != 0) {
                $query->where('user_id_creater', $dataSearch['user_id']);
            }
            if (isset($dataSearch['depart_id']) && $dataSearch['depart_id'] > 0) {
                $query->where('depart_id','=', $dataSearch['depart_id']);
            }
            if (isset($dataSearch['not_product_id']) && $dataSearch['not_product_id'] > 0) {
                $query->whereNotIn('product_id',array( $dataSearch['not_product_id']));
            }

            if (isset($dataSearch['user_shop_id'])) {
                if (is_array($dataSearch['user_shop_id'])) {
                    $query->whereIn('user_shop_id', $dataSearch['user_shop_id']);
                }
                elseif ((int)$dataSearch['user_shop_id'] > 0) {
                    $query->where('user_shop_id','=', (int)$dataSearch['user_shop_id']);
                }
            }
            if (isset($dataSearch['product_id'])) {
                if (is_array($dataSearch['product_id'])) {
                    $query->whereIn('product_id', $dataSearch['product_id']);
                }
                elseif ((int)$dataSearch['product_id'] > 0) {
                    $query->where('product_id','=', (int)$dataSearch['product_id']);
                }
            }

            if (isset($dataSearch['product_is_hot']) && $dataSearch['product_is_hot'] > 0) {
                $query->where('product_is_hot', $dataSearch['product_is_hot']);
            }
            //lay theo id SP truyen vào và sap xep theo vi tri đã truyền vào
            if(isset($dataSearch['str_product_id']) && $dataSearch['str_product_id'] != ''){
                $arrProductId = explode(',', trim($dataSearch['str_product_id']));
                $query->whereIn('product_id', $arrProductId);
                $query->orderByRaw(DB::raw("FIELD(product_id, ".trim($dataSearch['str_product_id'])." )"));
            }else{
                $orderBy = 'desc';
                if(isset($dataSearch['orderBy']) && $dataSearch['orderBy'] !=''){
                    $orderBy = $dataSearch['orderBy'];
                }
                $query->orderBy('product_id', $orderBy);
            }

            $total = ($is_total) ? $query->count() : 0;
            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];

        }catch (\PDOException $e){
            throw new \PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new Product();
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->save();
                self::removeCache($item->product_id, $item);
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
                self::removeCache($item->product_id, $item);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function getItemById($id) {
        $data = Memcache::getCache(Memcache::CACHE_PRODUCT_ID . $id);
        if (!$data) {
            $data = Product::where('product_id',$id)->first();
            if($data){
                Memcache::putCache(Memcache::CACHE_PRODUCT_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            $item = self::getItemById($id);
            if ($item) {
                $item->delete();
                self::removeCache($id, $item);
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
            Memcache::forgetCache(Memcache::CACHE_PRODUCT_ID . $id);
        }

        if($data){
            Memcache::forgetCache(Memcache::CACHE_LIST_HOME_PRODUCT_WITH_DEPART_ID . $data->depart_id);
            Memcache::forgetCache(Memcache::CACHE_LIST_CATEGORY_PRO_WITH_DEPART_ID . $data->depart_id);
        }
    }

    public function getProductHomeByDepartId($depart_id = 0,$field_get = array()) {
        if($depart_id > 0){
            $data = Memcache::getCache(Memcache::CACHE_LIST_HOME_PRODUCT_WITH_DEPART_ID . $depart_id);
            if (!$data) {
                $limit = 8; $offset = 0;
                $query = Product::where('product_id','>',STATUS_INT_KHONG);
                $query->where('product_status',STATUS_INT_MOT);
                $query->where('is_block',STATUS_INT_MOT);
                $query->where('depart_id',$depart_id);
                $query->orderBy('time_update', 'desc')->orderBy('product_id', 'desc');
                $data = (!empty($field_get)) ? $query->take($limit)->skip($offset)->get($field_get) :  $query->take($limit)->skip($offset)->get();
                if($data){
                    Memcache::putCache(Memcache::CACHE_LIST_HOME_PRODUCT_WITH_DEPART_ID . $depart_id, $data);
                }
            }
            return $data;
        }
        return array();
    }

    public function getListCateByDepart($depart_id){
        if($depart_id <= 0)
            return false;
        $data = Memcache::getCache(Memcache::CACHE_LIST_CATEGORY_PRO_WITH_DEPART_ID . $depart_id);
        if (!$data) {
            $fields[] = 'category_id';
            $fields[] = 'category_name';
            $fields[] = 'COUNT(category_id) AS total_cate';
            $query = DB::table(TABLE_PRODUCT)->select(DB::raw(implode(',', $fields)))
                ->where('product_status',STATUS_INT_MOT)
                ->where('is_block',STATUS_INT_MOT)
                ->where('depart_id',$depart_id)
                ->groupBy('category_id')
                ->orderBy('category_id');
            $data = $query->get();
            if($data){
                Memcache::putCache(Memcache::CACHE_LIST_CATEGORY_PRO_WITH_DEPART_ID . $depart_id, $data);
            }
        }
        return $data;
    }

    public function getProductForSite($dataSearch = array(), $limit =0, $offset = 0, $is_total=true){
        try{
            $query = Product::where('product_id','>',0);
            $query->where('product_status','=',STATUS_INT_MOT);
            $query->where('is_block','=',STATUS_INT_MOT);

            if (isset($dataSearch['product_id'])) {
                if (is_array($dataSearch['product_id'])) {
                    $query->whereIn('product_id', $dataSearch['product_id']);
                }
                elseif ((int)$dataSearch['product_id'] > 0) {
                    $query->where('product_id','=', (int)$dataSearch['product_id']);
                }
            }

            if (isset($dataSearch['not_product_id']) && $dataSearch['not_product_id'] > 0) {
                $query->whereNotIn('product_id',array( $dataSearch['not_product_id']));
            }

            if (isset($dataSearch['product_name']) && $dataSearch['product_name'] != '') {
                $query->where('product_name','LIKE', '%' . $dataSearch['product_name'] . '%');
            }
            if (isset($dataSearch['category_id'])) {
                if (is_array($dataSearch['category_id'])) {//tim theo mảng id danh muc
                    $query->whereIn('category_id', $dataSearch['category_id']);
                }
                elseif ((int)$dataSearch['category_id'] > 0) {//theo id danh muc
                    $query->where('category_id','=', (int)$dataSearch['category_id']);
                }
            }

            if (isset($dataSearch['category_parent_id']) && $dataSearch['category_parent_id'] > 0) {
                $arrCatId = array();
                $arrChildCate = Category::getAllChildCategoryIdByParentId($dataSearch['category_parent_id']);
                if(!empty($arrChildCate)){
                    $arrCatId = array_keys($arrChildCate);
                }
                $query->whereIn('category_id', $arrCatId);
            }

            if (isset($dataSearch['user_shop_id']) && $dataSearch['user_shop_id'] != 0) {
                $query->where('user_shop_id','=', $dataSearch['user_shop_id']);
            }

            if (isset($dataSearch['depart_id']) && $dataSearch['depart_id'] > 0) {
                $query->where('depart_id','=', $dataSearch['depart_id']);
            }
            if (isset($dataSearch['product_is_hot']) && $dataSearch['product_is_hot'] != -1) {
                $query->where('product_is_hot','=', $dataSearch['product_is_hot']);
            }

            if (isset($dataSearch['shop_province']) && $dataSearch['shop_province'] != -1) {
                $query->where('shop_province','=', $dataSearch['shop_province']);
            }
            //lấy khác shop_id này
            if (isset($dataSearch['shop_id_other']) && $dataSearch['shop_id_other'] > 0) {
                $query->where('user_shop_id','<>', $dataSearch['shop_id_other']);
            }

            //1: shop free, 2: shop thuong: 3 shop VIP
            if (isset($dataSearch['is_shop'])) {
                if (is_array($dataSearch['is_shop'])) {
                    $query->whereIn('is_shop', $dataSearch['is_shop']);
                }
                elseif ((int)$dataSearch['is_shop'] > 0) {
                    $query->where('is_shop', (int)$dataSearch['is_shop']);
                }
            }
            $total = ($is_total) ? $query->count() : 0;

            if(isset($dataSearch['str_product_id']) && $dataSearch['str_product_id'] != ''){
                $arrProductId = explode(',', trim($dataSearch['str_product_id']));
                $query->whereIn('product_id', $arrProductId);
                $query->orderByRaw(DB::raw("FIELD(product_id, ".trim($dataSearch['str_product_id'])." )"));
            }else{
                $orderBy = 'desc';
                if(isset($dataSearch['orderBy']) && $dataSearch['orderBy'] !=''){
                    $orderBy = $dataSearch['orderBy'];
                }
                $query->orderBy('time_update', $orderBy);
            }

            //get field can lay du lieu
            $str_field_product_get = 'product_id,product_name,depart_id,category_id,category_name,product_image,product_image_hover,product_status,product_price_sell,product_price_market,product_type_price,product_selloff,user_shop_id,user_shop_name,is_shop,is_block';//cac truong can lay
            $fields_get = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '')?trim($dataSearch['field_get']) : $str_field_product_get;
            $fields = (trim($fields_get) != '') ? explode(',',trim($fields_get)): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];
        }catch (\PDOException $e){
            throw new \PDOException();
        }
    }











    public  function getProductByShopId($shop_id,$product_id) {
        if($product_id > 0){
            $product = Product::getItemById($product_id);
            if (sizeof($product) > 0) {
                if(isset($product->user_shop_id) && (int)$product->user_shop_id == $shop_id){
                    return $product;
                }
            }
        }
        return array();
    }

    public function getListProductOfShopId($shop_id = 0, $field_get = array()) {
        if($shop_id > 0){
            $query = Product::where('user_shop_id','=',$shop_id);
            return $result = (!empty($field_get)) ? $query->get($field_get) : $query->get();
        }
        return array();
    }

    public function getProductByArrayProId($arrProId = array(),$field_get = array()) {
        if(!empty($arrProId)){
            $query = Product::where('product_id','>',0);
            $query->where('product_status','=',CGlobal::status_show);
            $query->where('is_block','=',CGlobal::PRODUCT_NOT_BLOCK);
            $query->whereIn('product_id',$arrProId);
            return $result = (!empty($field_get)) ? $query->get($field_get) : $query->get();
        }
        return array();
    }
}
