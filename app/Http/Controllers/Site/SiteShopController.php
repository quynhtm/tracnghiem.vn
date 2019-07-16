<?php
/*
* @Created by: QuynhTM
* @Date      : 09/2019
* @Version   : 1.0
*/

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseSiteController;
use App\Http\Models\Shop\Category;
use App\Http\Models\Shop\Department;
use App\Http\Models\Shop\Product;
use App\Library\AdminFunction\Pagging;
use App\Services\ShopCuaTuiService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class SiteShopController extends BaseSiteController
{

    private $outDataCommon = [];
    private $commonService;

    public function __construct()
    {
        parent::__construct();
        $this->commonService = new ShopCuaTuiService();
    }

    public function index()
    {
        $this->getCommonSite(STATUS_INT_MOT);
        $arrProductHome = $this->commonService->getProductHome();

        $this->commonService->getSeoSite();
        return view('site.SiteShop.home', array_merge([
            'arrProductHome' => $arrProductHome,
        ], $this->outDataCommon));
    }

    /**
     * @param $cate_name
     * @param $pro_id
     * @param $pro_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailProduct($cate_name, $pro_id, $pro_name )
    {
        if ($pro_id <= 0) {
            return Redirect::route('site.home');
        }
        $product = app(Product::class)->getItemById($pro_id);
        if (isset($product->product_id)) {
            //check sản phẩm lỗi
            if ((isset($product->product_status) && $product->product_status == STATUS_INT_KHONG) || (isset($product->is_block) && $product->is_block == STATUS_INT_KHONG)) {
                return Redirect::route('site.home');
            }
            //seo
            $meta_title = $product->product_name;
            $meta_keywords = $product->product_name;
            $meta_description = $product->product_name;
            //$meta_img = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $product->product_id, $product->product_image, CGlobal::sizeImage_200);
            $meta_img = '';
            $url_detail = buildLinkDetailProduct($product->product_id, $product->product_name, $product->category_name);
            $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description, $url_detail);

            //sản phẩm liên quan
            $arrRelatedProducts = $this->commonService->getRelatedProducts($product->toArray());

            $this->getCommonSite();
            return view('site.SiteShop.detailProduct', array_merge([
                'product' => $product,
                'arrRelatedProducts' => $arrRelatedProducts,
            ], $this->outDataCommon));
        }
    }

    /**
     * @param $depart_id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listProductWithDepart($depart_id, $name)
    {
        if ($depart_id <= 0) {
            return Redirect::route('site.home');
        }
        if ($depart_id > 0) {
            $department = app(Department::class)->getItemById($depart_id);
            if (isset($department->department_id) && $department->department_id > 0 && isset($department->department_status) && $department->department_status == STATUS_INT_MOT) {
                $departName = $department->department_name;
                $pageNo = (int)Request::get('page_no', 1);
                $limit = LIMIT_RECORD_24;
                $offset = ($pageNo - 1) * $limit;
                $search = $data = array();

                $search['depart_id'] = (int)$department->department_id;
                $search['depart_name'] = strtolower(safe_title($department->department_name));
                $data = app(Product::class)->getProductForSite($search, $limit, $offset, true);
                $total = $data['total'];
                $dataSearch = $data['data'];
                $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

                //danh mục của sản phẩm theo departs
                $dataCateWithDepart = ($total > 0) ? app(Product::class)->getListCateByDepart($depart_id) : [];

                $this->getCommonSite();
                return view('site.SiteShop.listProductWithDepart', array_merge([
                    'paging' => $paging,
                    'total' => $total,
                    'is_category' => STATUS_INT_KHONG,
                    'titleSearchName' => $departName,
                    'dataCateWithDepart' => convertToArray($dataCateWithDepart),
                    'dataSearch' => $dataSearch,
                ], $this->outDataCommon));
            } else {
                return Redirect::route('site.home');
            }
        }
    }

    /**
     * @param $cate_id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listProductWithCategory($cate_id, $name)
    {
        if ($cate_id <= 0) {
            return Redirect::route('site.home');
        }
        if ($cate_id > 0) {
            $category = app(Category::class)->getItemById($cate_id);
            if (isset($category->category_id) && $category->category_id > 0 && isset($category->category_status) && $category->category_status == STATUS_INT_MOT) {
                $categoryName = $category->category_name;
                $pageNo = (int)Request::get('page_no', 1);
                $limit = LIMIT_RECORD_24;
                $offset = ($pageNo - 1) * $limit;
                $search = $data = array();

                $search['category_id'] = (int)$category->category_id;
                $search['category_name'] = strtolower(safe_title($category->category_name));
                $data = app(Product::class)->getProductForSite($search, $limit, $offset, true);
                $total = $data['total'];
                $dataSearch = $data['data'];

                $departId = 0;
                if (!empty($dataSearch)) {
                    foreach ($dataSearch as $ite) {
                        $departId = $ite->depart_id;
                        break;
                    }
                }
                $department = app(Department::class)->getItemById($departId);
                $departName = isset($department->department_id) ? $department->department_name : '';
                $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

                $this->getCommonSite();
                return view('site.SiteShop.listProductWithDepart', array_merge([
                    'paging' => $paging,
                    'total' => $total,
                    'is_category' => STATUS_INT_MOT,
                    'titleSearchName' => $categoryName,
                    'departName' => $departName,
                    'departId' => $departId,
                    'dataSearch' => $dataSearch,
                    'dataCateWithDepart' => []
                ], $this->outDataCommon));
            } else {
                return Redirect::route('site.home');
            }
        }
    }

    public function cartProduct()
    {
        $this->getCommonSite();
        return view('site.SiteShop.cart', array_merge([
            'data' => [],
        ], $this->outDataCommon));
    }

    public function contactShop()
    {
        $this->getCommonSite();
        return view('site.SiteShop.contact', array_merge([
            'data' => [],
        ], $this->outDataCommon));
    }

    public function repaymentsOrder()
    {
        $this->getCommonSite();
        return view('site.SiteShop.repaymentsOrder', array_merge([
            'data' => [],
        ], $this->outDataCommon));
    }

    public function getCommonSite($action = STATUS_INT_KHONG)
    {
        return $this->outDataCommon = [
            'header' => $this->header($action),
            'footer' => $this->footer($action),
        ];
    }

    public function actionRouter($catname, $catid)
    {

    }
}
