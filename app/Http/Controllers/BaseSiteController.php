<?php

namespace App\Http\Controllers;

class BaseSiteController extends Controller{

	public function __construct(){}
	public function header(){
       echo 'Header';
	}
    public function slider(){
		echo 'Slider';
    }
    public function footer(){
       echo 'Footer';
	}
	
	public function page403(){
		echo '403';
	}
	public function page404(){
		echo '404';
	}
}  