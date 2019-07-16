<?php
/**
 * Created by PhpStorm.
 * User: Quynhtm
 * Date: 29/05/2015
 * Time: 8:24 CH
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;

class AdminDashBoardController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function dashboard()
    {
        return view('admin.AdminDashBoard.index', [
            'user' => $this->user,
            'menu' => $this->menuSystem,
            'data' => [],
            'arrNotify' => [],
            'lang' => $this->languageSite,
            'is_root' => $this->is_root]);
    }
}