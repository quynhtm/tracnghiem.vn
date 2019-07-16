<?php

namespace App\Http\Controllers;

use App\Http\Models\Shop\Department;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class BaseSiteController extends Controller{

	public function __construct(){}

	public function header($action = STATUS_INT_KHONG){
        $product_name = Request::get('title-search', '');
        //Session::forget(SESSION_SHOP_CART);
        $arrDepart = app(Department::class)->getMenuDepart();
        $dataCart = $this->countNumCart();
        return View::make('site.SiteLayouts.header', [
            'action' => $action,
            'product_name' => $product_name,
            'arrDepart' => $arrDepart,
            'dataCart' => $dataCart['data'],
            'totalItemCart' => $dataCart['total_cart'],
            'totalMoneyCart' => $dataCart['total_money'],
        ]);
	}

    public function footer($action = STATUS_INT_KHONG){
        return View::make('site.SiteLayouts.footer', [
            'action' => $action,
        ]);
	}

    public function countNumCart(){
        $dataCart = [];
        $total_cart = $total_money = 0;
        if(Session::has(SESSION_SHOP_CART)){
            $dataCart = Session::get(SESSION_SHOP_CART);
             foreach($dataCart as $pro=>$v){
                if(isset($v['number']) && $v['number'] > 0){
                    $total_cart += $v['number'];
                    $total_money +=($v['product_price_sell']*$v['number']);
                }
            }
        }
        return ['data'=>$dataCart,'total_cart'=>$total_cart,'total_money'=>$total_money];
    }

	public function page403(){
		echo '403';
	}
	public function page404(){
		echo '404';
	}
}  