<?php
Route::get('/', array('as' => 'site.home','uses' => Site.'\SiteShopController@index'));
Route::get('{cat}/{id}-{name}.html',array('as' => 'site.detailProduct','uses' =>Site.'\SiteShopController@detailProduct'));//chi tiết sản phẩm

Route::get('nhapkhau-{depart_id}/{depart_name}.html',array('as' => 'site.listProductWithDepart','uses' =>Site.'\SiteShopController@listProductWithDepart'));//list sản phẩm theo depart

Route::get('hang-nhap-khau/c-{category_id}/{category_name}.html',array('as' => 'site.listProductWithCategory','uses' =>Site.'\SiteShopController@listProductWithCategory'));//list sản phẩm theo danh mục

Route::get('/contactShop', array('as' => 'site.contactShop','uses' => Site.'\SiteShopController@contactShop'));

Route::get('/cartProduct', array('as' => 'site.cartProduct','uses' => Site.'\SiteShopController@cartProduct'));
Route::get('/repaymentsOrder', array('as' => 'site.repaymentsOrder','uses' => Site.'\SiteShopController@repaymentsOrder'));

//Gio hang
Route::post('them-vao-gio-hang.html', array('as' => 'site.ajaxAddCart','uses' => Site.'\ShopCartController@ajaxAddCart'));
Route::post('gio-hang.html',array('as' => 'site.listCartOrder','uses' =>Site.'\ShopCartController@listCartOrder'));
Route::post('xoa-mot-san-pham-trong-gio-hang.html', array('as' => 'site.deleteOneItemInCart','uses' => Site.'\ShopCartController@deleteOneItemInCart'));
Route::post('xoa-gio-hang.html', array('as' => 'site.deleteAllItemInCart','uses' => Site.'\ShopCartController@deleteAllItemInCart'));
Route::post('gui-don-hang.html',array('as' => 'site.sendCartOrder','uses' =>Site.'\ShopCartController@sendCartOrder'));
Route::get('cam-on-da-mua-hang.html',array('as' => 'site.thanksBuy','uses' =>Site.'\ShopCartController@thanksBuy'));
