<?php

namespace App\Services;

use App\Http\Models\Shop\Department;
use App\Http\Models\Shop\Product;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Config;

/**
 * Class BackendService
 * @package App\Services
 * Các function liên quan đến shopcuatui
 */
class ShopCuaTuiService
{

    public function getProductHome()
    {
        $arrProductHome = array();
        $arrDepart = app(Department::class)->getMenuDepart();
        if (!empty($arrDepart)) {
            foreach ($arrDepart as $depart_id => $name) {
                $product = app(Product::class)->getProductHomeByDepartId($depart_id);
                if (!empty($product)) {
                    $arrProductHome[$depart_id]['depart_id'] = $depart_id;
                    $arrProductHome[$depart_id]['depart_name'] = $name;
                    $arrProductHome[$depart_id]['product'] = $product;
                }
            }
        }
        return $arrProductHome;
    }

    //get sản phẩm liên quan
    public function getRelatedProducts($pro)
    {
        if(!is_array($pro) && $pro > 0){
            $product = app(Product::class)->getItemById($pro);
            $product = isset($product->product_id)? $product->toArray(): [];
        }else{
            $product = $pro;
        }
        if(is_array($product) && !empty($product)){
            $limit = LIMIT_RECORD_8;
            $search['category_id'] = $product['category_id'];
            $search['depart_id'] = $product['depart_id'];
            $search['not_product_id'] = $product['product_id'];
            $arrProductSame = app(Product::class)->getProductForSite($search, $limit, STATUS_INT_KHONG,false);
            return $arrProductSame['data'];
        }
        return [];
    }

    public function getSeoSite($img = '', $meta_title = '', $meta_keywords = '', $meta_description = '', $url = '')
    {
        if ($img == '') {
            $img = Config::get('config.WEB_ROOT') . 'uploads/default.jpg';
        }
        if ($meta_title == '') {
            $meta_title = CGlobal::meta_title;
        }
        if ($meta_keywords == '') {
            $meta_keywords = CGlobal::meta_keywords;
        }
        if ($meta_description == '') {
            $meta_description = CGlobal::meta_description;
        }

        $str = '';
        $str .= '<title>' . $meta_title . '</title>';
        $str .= "\n" . '<meta name="robots" content="index,follow">';
        $str .= "\n" . '<meta http-equiv="REFRESH" content="1800">';
        $str .= "\n" . '<meta name="revisit-after" content="days">';
        $str .= "\n" . '<meta http-equiv="content-language" content="vi"/>';
        $str .= "\n" . '<meta name="copyright" content="' . CGlobal::site_name . '">';
        $str .= "\n" . '<meta name="author" content="' . CGlobal::site_name . '">';

        //Google
        $str .= "\n" . '<meta name="keywords" content="' . $meta_keywords . '">';
        $str .= "\n" . '<meta name="description" content="' . $meta_description . '">';

        //Facebook
        $str .= "\n" . '<meta property="og:type" content="article" >';
        $str .= "\n" . '<meta property="og:title" content="' . $meta_title . '" >';
        $str .= "\n" . '<meta property="og:description" content="' . $meta_description . '" >';
        $str .= "\n" . '<meta property="og:site_name" content="' . CGlobal::site_name . '" >';
        $str .= "\n" . '<meta itemprop="thumbnailUrl" property="og:image" content="' . $img . '" >';

        //Twitter
        $str .= "\n" . '<meta name="twitter:title" content="' . $meta_title . '">';
        $str .= "\n" . '<meta name="twitter:description" content="' . $meta_description . '">';
        $str .= "\n" . '<meta name="twitter:image" content="' . $img . '">';

        $url = (trim($url) == '') ? buildLinkHome() : $url;
        if ($url != '') {
            $str .= "\n" . '<link rel="canonical" href="' . $url . '">';
            $str .= "\n" . '<meta property="og:url" itemprop="url" content="' . $url . '">';
            $str .= "\n" . '<meta name="twitter:url" content="' . $url . '">';
        }
        CGlobal::$extraMeta = $str;
    }
}