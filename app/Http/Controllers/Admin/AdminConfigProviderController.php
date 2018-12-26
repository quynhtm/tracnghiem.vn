<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\ConfigProvider;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Loader;
use App\Services\ElasticSearchService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AdminConfigProviderController extends BaseAdminController
{
    private $error = array();
    private $elasticService;
    private $arrCase = [];
    private $arrNetwork = [];
    private $arrProvider = [];
    private $viewPermission = array();

    public function __construct(ElasticSearchService $elasticService)
    {
        parent::__construct();
        $this->elasticService = $elasticService;
        CGlobal::$pageAdminTitle = __('Quản lý thông tin cấu hình nhà cung cấp SMS');
    }

    public function _getDataDefault()
    {
        Loader::loadJS('admin/js/custom.js', CGlobal::$POS_END);
        $this->arrAutos = CGlobal::$lender_setting_invest;
        $this->arrStatus = CGlobal::$lender_setting_status;

        # out put permission
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_CONFIG_PROVIDER_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_CONFIG_PROVIDER_CREATE),
            'permission_update' => $this->checkPermiss(PERMISS_CONFIG_PROVIDER_UPDATE),
            'permission_delete' => $this->checkPermiss(PERMISS_CONFIG_PROVIDER_DELETE),
        ];

        $ConfigProvider     = new ConfigProvider();
        $this->arrCase      = $ConfigProvider->case_id;
        $this->arrNetwork   = $ConfigProvider->network_id;
        $this->arrProvider  = $ConfigProvider->provider_id;
    }

    public function view()
    {
        # Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_CONFIG_PROVIDER_FULL, PERMISS_CONFIG_PROVIDER_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $this->_getDataDefault();

        $searchFields['name']     = addslashes(Request::get('name', ''));
        $searchFields['code']     = addslashes(Request::get('code', ''));
        $searchFields['status']   = (int)Request::get('status', -2);

        $instance   = new ConfigProvider();
        $result     = $instance->getAllData()->toArray();
        $data       = [];

        if (!empty($result)) foreach ($result as $key => $items):
            $data[$items['network_id']][$items['case_id']] = ['id' => $items['id'], 'value' => $items['provider_id']];
        endforeach;

        $variable = array_merge([
            'data' => $data,
            'error' => Session::get('error'),
            'success' => Session::get('success'),
            'arrCase' => $this->arrCase,
            'arrNetwork' => $this->arrNetwork,
            'arrProvider' => $this->arrProvider,
        ], $this->viewPermission);

        return view('admin.ConfigProvider.view', $variable);
    }

    public function postItem()
    {

        if (!$this->checkMultiPermiss([PERMISS_CONFIG_PROVIDER_FULL, PERMISS_CONFIG_PROVIDER_CREATE, PERMISS_CONFIG_PROVIDER_UPDATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        } elseif (!$this->checkMultiPermiss([PERMISS_CONFIG_PROVIDER_CREATE]) && empty($data['id'])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        } elseif (!$this->checkMultiPermiss([PERMISS_CONFIG_PROVIDER_UPDATE]) && !empty($data['id'])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $insert = [];
        $update = [];
        if (is_array($_POST['provider'])) foreach ($_POST['provider'] as $code => $provider_id):
            list($network_id, $case_id, $pkid) = explode('_', $code);

            if (!empty($_POST['executes'][$network_id]) && !empty($provider_id)):
                if ($pkid):
                    $update[$pkid] = ['code' => $network_id.'_'.$case_id, 'case_id' => $case_id, 'network_id' => $network_id, 'provider_id' => $provider_id, 'updated_at' => date('Y-m-d H:i:s')];
                else:
                    $insert[$code] = ['code' => $network_id.'_'.$case_id, 'case_id' => $case_id, 'network_id' => $network_id, 'provider_id' => $provider_id, 'created_at' => date('Y-m-d H:i:s')];
                endif;
            endif;
        endforeach;

        if (!empty($update)) foreach ($update as $id => $items):
            app(ConfigProvider::class)->updateItem($id, $items);
        endforeach;

        if (!empty($insert)):
            app(ConfigProvider::class)->createMultipleItem($insert);
        endif;

        if ($update || $insert):
            return Redirect::route('admin.configProvider')->with('success', [viewLanguage('Bạn đã cập nhật thành công cấu hình nhà cung cấp SMS')]);
        else:
            return Redirect::route('admin.configProvider')->with('error', [viewLanguage('Bạn cần lựa chọn sửa đổi cấu hình nhà cung cấp SMS')]);
        endif;
    }

    public function postAjax()
    {

        if (!$this->checkMultiPermiss([PERMISS_CONFIG_PROVIDER_FULL, PERMISS_CONFIG_PROVIDER_CREATE, PERMISS_CONFIG_PROVIDER_UPDATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        } elseif (!$this->checkMultiPermiss([PERMISS_CONFIG_PROVIDER_CREATE]) && empty($data['id'])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        } elseif (!$this->checkMultiPermiss([PERMISS_CONFIG_PROVIDER_UPDATE]) && !empty($data['id'])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $insert = [];
        $update = [];
        if (is_array($_POST['provider'])) foreach ($_POST['provider'] as $code => $provider_id):
            list($network_id, $case_id, $pkid) = explode('_', $code);

            if (!empty($_POST['executes'][$network_id.'_'.$case_id]) && !empty($provider_id)):
                if ($pkid):
                    $update[$pkid] = ['code' => $network_id.'_'.$case_id, 'case_id' => $case_id, 'network_id' => $network_id, 'provider_id' => $provider_id, 'updated_at' => date('Y-m-d H:i:s')];
                else:
                    $insert[$code] = ['code' => $network_id.'_'.$case_id, 'case_id' => $case_id, 'network_id' => $network_id, 'provider_id' => $provider_id, 'created_at' => date('Y-m-d H:i:s')];
                endif;
            endif;
        endforeach;

        if (!empty($update)) foreach ($update as $id => $items):
            app(ConfigProvider::class)->updateItem($id, $items);
        endforeach;

        if (!empty($insert)):
            app(ConfigProvider::class)->createMultipleItem($insert);
            $lasted     = end($insert);
            $instance   = new ConfigProvider();
            $instance->conditionQuery($instance->query(), ['field_get' => 'id,code', 'network_id' => $lasted['network_id']]);
            $result = $this->elasticService->search($instance, ['field_get' => 'id,code', 'network_id' => $lasted['network_id']], count($this->arrCase), 0, false);
            $result = isset($result['data']) ? $result['data']->keyBy('code')->toArray() : array();
        endif;

        echo json_encode(!empty($result) ? $result : []);
        exit();
    }
}
