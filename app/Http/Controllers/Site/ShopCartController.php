<?php
/*
* @Created by: QuynhTM
* @Date      : 09/2019
* @Version   : 1.0
*/

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseSiteController;
use App\Http\Models\Shop\Order;
use App\Http\Models\Shop\OrderItem;
use App\Http\Models\Shop\Product;
use App\Library\AdminFunction\Pagging;
use App\Services\ShopCuaTuiService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ShopCartController extends BaseSiteController
{

    private $outDataCommon = [];
    private $commonService;
    private $sessionCart = SESSION_SHOP_CART;

    public function __construct()
    {
        parent::__construct();
        $this->commonService = new ShopCuaTuiService();
    }

    public function ajaxAddCart(){
        $result = ['intIsOK'=>0,'msg'=>'Thêm giỏ hàng thất bại'];
        if(empty($_POST)){
            return Response::json($result);
        }
        $pid = Request::get('pro_id');
        $number = (int)Request::get('number');
        $data = array();
        $product_id = getStrVar($pid);
        if($product_id > 0 && $number > 0){
            $product = app(Product::class)->getItemById($product_id);
            if(!isset($product->product_id)){
                $result = ['intIsOK'=>STATUS_INT_KHONG,'msg'=>'Không tồn tại sản phẩm!'];
                return Response::json($result);
            }
            //Tam Het Hang
            if($product->is_sale != STATUS_INT_MOT){
                $result = ['intIsOK'=>STATUS_INT_KHONG,'msg'=>'Tạm hết hàng'];
                return Response::json($result);
            }
            if($product->is_block == STATUS_INT_KHONG){
                $result = ['intIsOK'=>STATUS_INT_KHONG,'msg'=>'Sản phẩm đang bị khóa!'];
                return Response::json($result);
            }
            if(Session::has($this->sessionCart)){
                $data = Session::get($this->sessionCart);
                if(isset($data[$product_id])){
                    $data[$product_id]['number'] += $number;
                    if($data[$product_id]['number'] > LIMIT_RECORD_20){
                        $data[$product_id]['number'] = LIMIT_RECORD_20;
                    }
                }else{
                    $data[$product_id] = [
                        'number'=>$number,
                        'product_name'=>$product->product_name,
                        'product_id'=>$product->product_id,
                        'product_image'=>$product->product_image,
                        'category_name'=>$product->category_name,
                        'product_price_sell'=>$product->product_price_sell
                    ];
                }
            }else{
                $data[$product_id] = [
                    'number'=>$number,
                    'product_name'=>$product->product_name,
                    'product_id'=>$product->product_id,
                    'product_image'=>$product->product_image,
                    'category_name'=>$product->category_name,
                    'product_price_sell'=>$product->product_price_sell
                ];
            }

            Session::put($this->sessionCart, $data, 60*24);
            Session::save();
            $totalCart = 0;
            $dataCart = Session::get($this->sessionCart);
            foreach($dataCart as $pro=>$v){
                if(isset($v['number']) && $v['number'] > 0){
                    $totalCart += $v['number'];
                }
            }
            $result = ['intIsOK'=>STATUS_INT_MOT,'totalCart'=>$totalCart,'msg'=>'Thêm giỏ hàng thành công'];
            return Response::json($result);
        }
        return Response::json($result);
    }

    public function listCartOrder(){
        $meta_title = $meta_keywords = $meta_description = 'Thông tin giỏ hàng';
        $meta_img = '';
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description);
        $dataCart = array();
        //Update Cart
        if(!empty($_POST)){
            $token = Request::get('_token', '');
            if(Session::token() === $token){
                $updateCart = Request::get('listCart', array());
                $dataCart = Session::get($this->sessionCart);
                foreach($updateCart as $k=>$v){
                    if($v == 0){
                        if(isset($dataCart[$k])){
                            unset($dataCart[$k]);
                        }
                        if(empty($dataCart[$k])){
                            unset($dataCart[$k]);
                        }
                    }else{
                        if(isset($dataCart[$k])){
                            $dataCart[$k] = $v;
                            if($dataCart[$k] > LIMIT_RECORD_10){
                                $dataCart[$k] = LIMIT_RECORD_10;
                            }
                        }
                    }
                }

                Session::put($this->sessionCart, $dataCart);
                Session::save();
                unset($_POST);
                return Redirect::route('site.listCartOrder');
            }
        }
        //End Update Cart

        if(Session::has($this->sessionCart)){
            $dataCart = Session::get($this->sessionCart);
        }
        //Config Page
        $pageNo = (int) Request::get('page', 1);
        $pageScroll = STATUS_INT_HAI;
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $dataItem = array();
        $paging = '';

        if(!empty($dataCart)){
            $arrId = array_keys($dataCart);
            $paging = '';
            if(!empty($arrId)){
                $search['str_product_id'] = join(',',$arrId);
                $dataItem = app(Product::class)->getProductForSite($search, $limit, $offset, true);
                $paging = $dataItem['total'] > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $dataItem['total'], $limit, $search) : '';
            }
        }

        $this->header(0);
        $this->layout->content = View::make('site.SiteOrder.listCartOrder')
            ->with('dataCart',$dataCart)
            ->with('dataItem',$dataItem['data'])
            ->with('paging',$paging);
        $this->footer();

    }

    public function deleteOneItemInCart(){

        if(empty($_POST)){
            return Redirect::route('site.home');
        }

        $id = (int)Request::get('id', 0);
        if($id > 0){
            if(Session::has($this->sessionCart)){
                $data = Session::get($this->sessionCart);
                if(isset($data[$id])){
                    unset($data[$id]);
                }
                Session::put($this->sessionCart, $data, 60*24);
                Session::save();
            }
        }
        echo 'ok';exit();
    }

    public function deleteAllItemInCart(){
        if(empty($_POST)){
            return Redirect::route('site.home');
        }
        $dell = addslashes(Request::get('delAll', ''));
        if($dell == 'delAll'){
            if(Session::has($this->sessionCart)){
                Session::forget($this->sessionCart);
                Session::save();
            }
        }
        echo 'ok';exit();
    }

    public function sendCartOrder(){
        $meta_title = $meta_keywords = $meta_description = 'Gửi thông tin đơn hàng';
        $meta_img = '';
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description);

        if(!Session::has($this->sessionCart)){
            return Redirect::route('site.home');
        }
        $this->user_customer = Session::get('user_customer');

        $dataCart = $arrId = $search = $dataItem = array();

        if(Session::has($this->sessionCart)){
            $dataCart = Session::get($this->sessionCart);
        }
        if(!empty($dataCart)){
            $arrId = array_keys($dataCart);
            if(!empty($arrId)){
                $search['str_product_id'] = join(',',$arrId);
                $dataItem = app(Product::class)->getProductForSite($search, count($arrId), 0, false);
            }
        }

        if(!empty($_POST) && sizeof($arrId) > 0){
            $token = Request::get('_token', '');
            if(Session::token() === $token){
                $txtName = addslashes(Request::get('txtName', ''));
                $txtMobile = addslashes(Request::get('txtMobile', ''));
                $txtEmail = addslashes(Request::get('txtEmail', ''));
                $txtAddress = addslashes(Request::get('txtAddress', ''));
                $txtMessage = addslashes(Request::get('txtMessage', ''));
                //Check Mail Regex
                $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                if(!preg_match($regex, $txtEmail)){
                    $txtEmail = '';
                }

                if($txtName!= '' && $txtMobile != '' && $txtAddress != ''){
                    $arrOrderProductId = $arrId;
                    $total_money = $total_product = 0;
                    $productOrder = $dataOrder = array();
                    if(sizeof($arrOrderProductId) > 0){
                        $arrProductId = array();
                        if(!empty($arrOrderProductId)){
                            foreach($arrOrderProductId as $pro){
                                $arrProductId[] = (int)trim($pro);
                            }
                        }
                        if(!empty($arrProductId)){
                            $field_get = array('product_id','product_code', 'product_name', 'category_name','category_id', 'product_image',
                                'product_price_sell', 'product_price_market', 'product_price_input', 'product_price_provider_sell','product_type_price',);

                            $search2['field_get'] = $field_get;
                            $search2['str_product_id'] = join(',',$arrProductId);
                            $inforProduct = app(Product::class)->getProductForSite($search2, count($arrId), 0, false);

                            if(!empty($inforProduct['data'])){
                                foreach($inforProduct['data'] as $k => $pro){
                                    $number_buy = isset($dataCart[$pro->product_id]) ? (int)$dataCart[$pro->product_id] : 0;
                                    $total_product +=  $number_buy;
                                    $total_money += $number_buy*$pro->product_price_sell;
                                    $productOrder[$pro->product_id] = array(
                                        'product_id'=>$pro->product_id,
                                        'product_name'=>$pro->product_name,
                                        'product_price_sell'=>$pro->product_price_sell,
                                        'product_price_input'=>$pro->product_price_input,
                                        'product_category_id'=>$pro->product_category_id,
                                        'product_category_name'=>$pro->product_category_name,
                                        'product_type_price'=>$pro->product_type_price,
                                        'number_buy'=> $number_buy,
                                        'product_image'=>$pro->product_image,
                                    );
                                }
                            }
                        }

                        $dataUserOrder = array(
                            'order_customer_name'=>$txtName,
                            'order_customer_phone'=>$txtMobile,
                            'order_customer_email'=>$txtEmail,
                            'order_customer_address'=>$txtAddress,
                            'order_customer_note'=>$txtMessage,
                            'order_product_id'=>implode(',', $arrId),
                            'order_total_buy'=>$total_product,
                            'order_total_money'=>$total_money,
                            'order_type' => STATUS_INT_KHONG,
                            'order_time_creater'=>time(),
                            'order_status'=> STATUS_INT_MOT,
                        );

                        $order_id = app(Order::class)->createItem($dataUserOrder);
                        foreach($productOrder as $key => $item){
                            $item['order_id'] = $order_id;
                        }
                        app(OrderItem::class)->insertMultiple($productOrder);
                    }

                    //Gui Mail cho Khach Mua Hang
                    /*if($txtEmail != '' && sizeof($dataItem['data']) > 0){
                        $dataCustomer = array(
                            'txtName'=>$txtName,
                            'txtMobile'=>$txtMobile,
                            'txtEmail'=>$txtEmail,
                            'txtAddress'=>$txtAddress,
                            'txtMessage'=>$txtMessage,
                            'dataItem'=>$dataOrder,
                        );

                        $emailsCustomerShop = [$txtEmail, CGlobal::emailAdmin, CGlobal::emailAdminSub1, CGlobal::emailAdminSub2];
                        Mail::send('emails.SendOrderToMailCustomer', array('data'=>$dataCustomer), function($message) use ($emailsCustomerShop){
                            $message->to($emailsCustomerShop, 'OrderToCustomer')
                                    ->subject(CGlobal::web_name.' - Bạn đã đặt mua sản phẩm '.date('d/m/Y h:i',  time()));
                        });
                    }*/

                    if(Session::has($this->sessionCart)){
                        Session::forget($this->sessionCart);
                        return Redirect::route('site.thanksBuy');
                    }
                }
            }
        }

        $this->header();
        $this->layout->content = View::make('site.SiteOrder.sendCartOrder')
            ->with('dataCart',$dataCart)
            ->with('dataItem',$dataItem['data']);
        $this->footer();
    }

    public function thanksBuy(){

        $meta_title = $meta_keywords = $meta_description = 'Cảm ơn bạn đã mua hàng';
        $meta_img = '';
        $this->commonService->getSeoSite($meta_img, $meta_title, $meta_keywords, $meta_description);

        $this->header();
        $limit = LIMIT_RECORD_12;
        $search = $data = array();
        $arrProductSame = app(Product::class)->getProductForSite($search, $limit, 0, false);

        $this->layout->content = View::make('site.SiteOrder.thanksBuy')
            ->with('userAdmin', $this->userAdmin)
            ->with('arrProductSame',$arrProductSame['data']);
        $this->footer();
    }
}
