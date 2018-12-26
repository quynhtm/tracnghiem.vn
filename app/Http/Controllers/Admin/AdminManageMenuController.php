<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\MenuSystem;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;

class AdminManageMenuController extends BaseAdminController
{
    private $permission_view = 'menu_view';
    private $permission_full = 'menu_full';
    private $permission_delete = 'menu_delete';
    private $permission_create = 'menu_create';
    private $permission_edit = 'menu_edit';
    private $arrStatus = array();
    private $arrMenuType = array();
    private $error = array();
    private $arrMenuParent = array();
    private $arrMenuTabTop = array();
    private $viewOptionData = array();
    private $viewPermission = array();//check quyen

    public function __construct()
    {
        parent::__construct();
        $this->arrMenuParent = MenuSystem::getAllParentMenu();
        $this->arrMenuTabTop = CGlobal::$arrMenuTabTop;
        CGlobal::$pageAdminTitle = 'Quản lý menu';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            CGlobal::status_block => viewLanguage('status_choose'),
            CGlobal::status_show => viewLanguage('status_show'),
            CGlobal::status_hide => viewLanguage('status_hidden'));

        $this->arrMenuType = array(
            STATUS_HIDE => viewLanguage('Menu cha'),
            STATUS_SHOW => viewLanguage('Link page'));
    }

    public function getPermissionPage()
    {
        return $this->viewPermission = [
            'is_root' => $this->is_root ? 1 : 0,
            'permission_edit' => in_array($this->permission_edit, $this->permission) ? 1 : 0,
            'permission_create' => in_array($this->permission_create, $this->permission) ? 1 : 0,
            'permission_delete' => in_array($this->permission_delete, $this->permission) ? 1 : 0,
            'permission_full' => in_array($this->permission_full, $this->permission) ? 1 : 0,
        ];
    }

    public function view()
    {
        //Check phan quyen.
        if (!$this->is_root && !in_array($this->permission_full, $this->permission) && !in_array($this->permission_view, $this->permission)) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = 200;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['menu_name'] = addslashes(Request::get('menu_name', ''));
        $search['active'] = (int)Request::get('active', -1);
        $search['menu_tab_top_id'] = (int)Request::get('menu_tab_top_id', 1);
        //$search['field_get'] = 'menu_name,menu_id,parent_id';//cac truong can lay

        $dataSearch = app(MenuSystem::class)->searchByCondition($search, $limit, $offset, $total);
        if (!empty($dataSearch)) {
            $data = MenuSystem::getTreeMenu($dataSearch);
            $data = !empty($data) ? $data : $dataSearch;
        }
        $paging = '';

        //FunctionLib::debug($data);
        $this->_getDataDefault();
        $optionStatus = getOption($this->arrStatus, $search['active']);
        $optionMenuTabTop = getOption(array(0 => 'Tất cả') + $this->arrMenuTabTop, isset($search['menu_tab_top_id']) ? $search['menu_tab_top_id'] : 1);
        $this->viewPermission = $this->getPermissionPage();
        $arrRouter = $this->getRouterNameSite();
        return view('admin.AdminMenuSystem.view', array_merge([
            'data' => $data,
            'search' => $search,
            'total' => $total,
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'arrRouter' => $arrRouter,
            'optionStatus' => $optionStatus,
            'optionMenuTabTop' => $optionMenuTabTop,
            'menuTabTop' => array(0 => 'Tất cả') + $this->arrMenuTabTop,
        ], $this->viewPermission));
    }

    public function getItem($ids)
    {
        $id = FunctionLib::outputId($ids);
        if (!$this->is_root && !in_array($this->permission_full, $this->permission) && !in_array($this->permission_edit, $this->permission) && !in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $data = array();
        if ($id > 0) {
            $data = MenuSystem::find($id);
        }

        $this->_getDataDefault();
        $this->_viewOptionData($data);
        $this->viewPermission = $this->getPermissionPage();
        return view('admin.AdminMenuSystem.add', array_merge([
            'data' => $data,
            'id' => $id,
            'arrStatus' => $this->arrStatus,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($ids)
    {
        $id = FunctionLib::outputId($ids);
        if (!$this->is_root && !in_array($this->permission_full, $this->permission) && !in_array($this->permission_edit, $this->permission) && !in_array($this->permission_create, $this->permission)) {
            return Redirect::route('admin.dashboard', array('error' => Define::ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        if (isset($data['menu_url'])) {
            $data['parent_id'] = isset($data['parent_id']) ? $data['parent_id'] : STATUS_HIDE;
            if ($data['parent_id'] == STATUS_HIDE && $data['menu_type'] == STATUS_HIDE) {
                $data['menu_url'] = '#';
            } elseif (trim($data['menu_url']) != '' && !in_array(trim($data['menu_url']), $this->getRouterNameSite())) {
                $data['menu_url'] = 'admin.dashboard';
            }
        }
        $data['ordering'] = (int)($data['ordering']);
        if ($this->valid($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                //cap nhat
                if (app(MenuSystem::class)->updateItem($id, $data)) {
                    return Redirect::route('admin.menuView', ['menu_tab_top_id' => $data['menu_tab_top_id']]);
                }
            } else {
                //them moi
                if (app(MenuSystem::class)->createItem($data)) {
                    return Redirect::route('admin.menuView', ['menu_tab_top_id' => $data['menu_tab_top_id']]);
                }
            }
        }

        $this->_getDataDefault();
        $this->_viewOptionData($data);
        $this->viewPermission = $this->getPermissionPage();
        return view('admin.AdminMenuSystem.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
            'arrStatus' => $this->arrStatus,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function _viewOptionData($data)
    {
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['active']) ? $data['active'] : CGlobal::status_show);
        $optionShowContent = FunctionLib::getOption($this->arrStatus, isset($data['showcontent']) ? $data['showcontent'] : CGlobal::status_show);
        $optionShowPermission = FunctionLib::getOption($this->arrStatus, isset($data['show_permission']) ? $data['show_permission'] : CGlobal::status_hide);
        $optionShowMenu = FunctionLib::getOption($this->arrStatus, isset($data['show_menu']) ? $data['show_menu'] : CGlobal::status_show);
        $optionMenuParent = FunctionLib::getOption($this->arrMenuParent, isset($data['parent_id']) ? $data['parent_id'] : 0);
        $optionMenuTabTop = FunctionLib::getOption($this->arrMenuTabTop, isset($data['menu_tab_top_id']) ? $data['menu_tab_top_id'] : 1);
        $optionMenuType = FunctionLib::getOption($this->arrMenuType, isset($data['menu_type']) ? $data['menu_type'] : STATUS_SHOW);

        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionShowContent' => $optionShowContent,
            'optionShowPermission' => $optionShowPermission,
            'optionShowMenu' => $optionShowMenu,
            'optionMenuParent' => $optionMenuParent,
            'optionMenuTabTop' => $optionMenuTabTop,
            'optionMenuType' => $optionMenuType,
        ];
    }

    public function deleteMenu()
    {
        $data = array('isIntOk' => 0);
        if (!$this->is_root && !in_array($this->permission_full, $this->permission) && !in_array($this->permission_delete, $this->permission)) {
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(MenuSystem::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function valid($data = array())
    {
        if (!empty($data)) {
            if (isset($data['banner_name']) && trim($data['banner_name']) == '') {
                $this->error[] = 'Null';
            }
        }
        return true;
    }

    public function ajaxGetOptionParent()
    {
        $object_id = Request::get('object_id', 0);
        $arrData = app(MenuSystem::class)->getMenuByTab($object_id);
        $option = getOption([0=>'---Chọn Menu cha --']+$arrData, 0);
        $arrData['optionSelect'] = $option;
        $arrData['isIntOk'] = 1;
        return response()->json($arrData);
    }
}
