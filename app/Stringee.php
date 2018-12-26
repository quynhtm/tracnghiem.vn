<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 11/2018
* @Version   : 1.0
*/
namespace App;

use App\Http\Models\Admin\User;
use App\Http\Models\Admin\UsersPhoneStringeeAgent;
use App\Library\AdminFunction\CGlobal;
use App\Services\LogCall\LogCallHistoryService;
use Illuminate\Support\Facades\Request;

class Stringee{
    public static function scriptVMCallMobile(){
        $User = app(User::class)->user_login();
        $check = isset($User['check_permission_stringee_call']) ? $User['check_permission_stringee_call'] : -1;
        if($check == 1) {
            $str = '
                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".VMCall").click(function(){
                            phoneCall = $(this).attr("phoneCall");
                            if($(this).hasClass("Call")){
                                var _phone = 84 + $(this).attr("phone");
                                if(_phone != "" && phoneCall != ""){
                                    var r = confirm("Bật cuộc gọi");
                                    if(r){
                                        $(this).removeClass("Call").addClass("DisableCall");
                                        VM_STRIGEE.makeCall(phoneCall, _phone);
                                    }
                                }
                            }else{
                                if($(this).hasClass("DisableCall")){
                                    var _phone = 84 + $(this).attr("phone");
                                    if(_phone != "" && phoneCall != ""){
                                        var r = confirm("Tắt cuộc gọi");
                                        if(r){
                                            $(this).removeClass("DisableCall").addClass("Call");
                                            VM_STRIGEE.hangupCall();
                                            if(objSoftphone != null) {
                                                if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                                                    VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, "stop");
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        });
                        //popupPhone
                        $(".sPopupCall").click(function(){
                           var _phone = 84 + $(this).attr("phone");
                           var _bg = $(this).attr("data-bg");
                           $(".sPhoneNum").val(_phone);
                           $(".sPhoneContent").text(_phone);
                           $(".sPhoneContent").attr("bg", _bg);
                           $(this).addClass("iconPhoneRed");
                        });
                        $(".sPhoneCall").click(function(){
                            var sPhoneCall = $(".sPhoneVal").val();
                            var sPhoneNum = $(".sPhoneNum").val();
                            if($(this).hasClass("sCall")){
                                if(sPhoneNum != "" && sPhoneCall != ""){
                                    $(this).removeClass("sCall").addClass("dCall");
                                    $(this).find(".txt").text("Tắt cuộc gọi");
                                    VM_STRIGEE.makeCall(sPhoneCall, sPhoneNum);
                                    $(".sPhoneCall").addClass("act");
                                    $(".sPhoneCallDropHold").addClass("act");
                                }
                            }else{
                                if($(this).hasClass("dCall")){
                                    if(sPhoneNum != "" && sPhoneCall != ""){
                                        $(this).removeClass("dCall").addClass("sCall");
                                        $(this).find(".txt").text("Gọi điện");
                                        VM_STRIGEE.hangupCall();
                                        VM_STRIGEE.enableButtonCall();
                                        if(objSoftphone != null) {
                                            if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                                                VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, "stop");
                                            }
                                        }
                                        $(".sPhoneCall").removeClass("act");
                                        $(".sPhoneCallDropHold").removeClass("act");
                                    }
                                }
                            }
                        });
                        $("#sPopupCallModal .close").click(function(){
                            $(".sPopupCall").removeClass("iconPhoneRed");
                            VM_STRIGEE.hangupCall();
                            VM_STRIGEE.enableButtonCall();
                            if(objSoftphone != null) {
                                if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                                    VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, "stop");
                                }
                            }
                        });
                    });
                </script>';
            return $str;
        }
    }
    public static function btnVMCallMobile($phone=''){
        $User = app(User::class)->user_login();
        $arrPhone = isset($User['arr_phone_stringee_agent']) ? $User['arr_phone_stringee_agent'] : array();
        $str = '';
        if(is_array($arrPhone) && sizeof($arrPhone) > 0) {
            $provide_client = Stringee::checkPhoneProvideStringee($phone, 1);
            $_arrPhone = array();
            foreach ($arrPhone as $item) {
                $provide_stringee = Stringee::checkPhoneProvideStringee($item, 0);
                $_arrPhone[$provide_stringee][] = $item;
            }
            if (isset($_arrPhone[$provide_client])) {
                $_tmp = $_arrPhone[$provide_client];
                $phoneCall = $_tmp[array_rand($_tmp)];
            } else {
                $phoneCall = $arrPhone[array_rand($arrPhone)];
            }
            $check = isset($User['check_permission_stringee_call']) ? $User['check_permission_stringee_call'] : -1;
            if ($check == 1) {
                if (trim($phone) != '') {
                    $str = '<div class="clearfix text-left">
                    <span class="iconPhone sPopupCall" data-bg="'.$provide_client.'" data-toggle="modal" data-target="#sPopupCallModal" phone="' . trim($phone) . '"></span>
                    <span class="VMCall Call" phone="' . trim($phone) . '" phoneCall="' . $phoneCall . '"><i class="fa fa-phone-square"></i></span>
                    </div>';
                }
            }
        }
        return $str;
    }
    public static function sPopupCallModal(){
        $str = '';
        $User = app(User::class)->user_login();
        $check = isset($User['check_permission_stringee_call']) ? $User['check_permission_stringee_call'] : -1;
        $arrPhone = isset($User['arr_phone_stringee_agent']) ? $User['arr_phone_stringee_agent'] : array();
        if(sizeof($arrPhone) > 0 && $check == 1){
            $option = '';
            foreach($arrPhone as $num){
                $class = Stringee::checkPhoneProvideStringee($num, 0);
                $option .= '<option class="'.$class.'" value="'.$num.'">'.$num.'</option>';
            }
            $str = '
           <div class="modal fade" id="sPopupCallModal" tabindex="-1" role="dialog" aria-hidden="false" data-backdrop="static" data-keyboard="false">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-body">
                        <div class="listBoxNumber">
                            <div class="row">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <div class="col-md-5">
                                    <div class="sPhoneTitle">Gọi cho số:</div>
                                    <div class="sPhoneContent"></div>
                                    <div class="showTimeCall">
                                        <div class="textShowTime">Đang gọi...</div>
                                        <div class="countShowTime">00:00</div>
                                    </div>
                                    <div class="showCallBusy"></div>
                                </div>
                                <div class="col-md-2"><span class="icon-star-vn"></span></div>
                                <div class="col-md-5">
                                    <input type="hidden" value="" class="sPhoneNum">
                                    <div class="sPhoneTitle">Số tổng đài:</div>
                                    <select class="form-control input-sm sPhoneVal" size="5">
                                        '.$option.'
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="btn sPhoneCall sCall"><i class="fa fa-phone"></i> <span class="txt">Gọi điện</span></div>
                        <div class="btn sPhoneCallDropHold sHolde hCall"><i class="fa fa-phone"></i> <span class="txt">Giữ cuộc gọi</span></div>
                     </div>
                  </div>
               </div>
           </div>';
        }
        return $str;
    }
    public static function sDropCallHeader(){
        $str = '';
        $User = app(User::class)->user_login();
        $checkRoot = app(User::class)->getPermit();
        $arrPhone = isset($User['arr_phone_stringee_agent']) ? $User['arr_phone_stringee_agent'] : array();
        if($checkRoot){
            $check = 1;
        }else{
            $check = isset($User['check_permission_stringee_call']) ? $User['check_permission_stringee_call'] : -1;
        }
        if(sizeof($arrPhone) > 0 && $check == 1){
            $option = '';
            foreach($arrPhone as $num){
                $class = Stringee::checkPhoneProvideStringee($num, 0);
                $option .= '<option class="'.$class.'" value="'.$num.'">'.$num.'</option>';
            }
            $token_stringee = isset($User['token_stringee']) ? $User['token_stringee'] :'';

            $str = '
                <input type="hidden" name="token_stringee" value="'.$token_stringee.'" class="token_stringee" />
                <script type="text/javascript" src="' . getBaseUrl() . 'assets/admin/js/call/socket.io-2.0.3.js"></script>
                <script type="text/javascript" src="' . getBaseUrl() . 'assets/admin/js/call/StringeeSDK-1.3.9.js"></script>
                <script type="text/javascript" src="' . getBaseUrl() . 'assets/admin/js/call/customers-call.js"></script>
                <script type="text/javascript" src="' . getBaseUrl() . 'assets/admin/js/call/agent-stringee.js"></script>
                <script>
                    $(document).ready(function(){
                        $(".iconPhoneDrop").click(function(){
                            $(".contentBoxPhoneDropCall").toggleClass("active");
                        });
                        $(".sPhoneCallDrop").click(function(){
                            var sPhoneGetVal = $(".sPhoneGetVal").val();
                            sPhoneGetVal = sPhoneGetVal.split(" ").join("");
                            var sPhoneVMVal = $(".sPhoneVMVal").val();
                            if($(this).hasClass("sCall")){
                                if(sPhoneGetVal != "" && sPhoneVMVal != ""){
                                    $(this).removeClass("sCall").addClass("dCall");
                                    $(this).find(".txt").text("Tắt cuộc gọi");
                                    sPhoneGetVal = 84 + sPhoneGetVal;
                                    $(".sPhoneGetVal").removeClass("error");
                                    VM_STRIGEE.makeCall(sPhoneVMVal, sPhoneGetVal);
                                    $(".sPhoneCallDrop").addClass("act");
                                    $(".sPhoneCallDropHold").addClass("act");
                                }else{
                                    $(".sPhoneGetVal").addClass("error");
                                }
                            }else{
                                if($(this).hasClass("dCall")){
                                    if(sPhoneGetVal != "" && sPhoneVMVal != ""){
                                        $(this).removeClass("dCall").addClass("sCall");
                                        $(this).find(".txt").text("Gọi điện");
                                        VM_STRIGEE.hangupCall();
                                        VM_STRIGEE.enableButtonCall();
                                        if(objSoftphone != null) {
                                            if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                                                VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, "stop");
                                            }
                                        }
                                        $(".sPhoneCallDrop").removeClass("act");
                                        $(".sPhoneCallDropHold").removeClass("act");
                                    }
                                }
                            }
                        });

                        //Giu cuoc goi
                        $(".sPhoneCallDropHold").on("click", function() {
                            if($(this).hasClass("unHCall")){
                                VM_STRIGEE.unHoldCall();
                                $(this).removeClass("unHCall").addClass("hCall");
                                $(".sPhoneCallDropHold .txt").text("Giữ cuộc gọi");
                            }else{
                                if($(this).hasClass("hCall")){
                                    VM_STRIGEE.holdCall();
                                    $(this).removeClass("hCall").addClass("unHCall");
                                    $(".sPhoneCallDropHold .txt").text("Bỏ giữ cuộc gọi");
                                }
                            }
                        });

                        $(document).keypress(function(e) {
                            if(e.which == 13) {
                                var sPhoneGetVal = $(".sPhoneGetVal").val();
                                sPhoneGetVal = sPhoneGetVal.split(" ").join("");
                                var sPhoneVMVal = $(".sPhoneVMVal").val();
                                if($(".sPhoneCallDrop").hasClass("sCall")){
                                    if(sPhoneGetVal != "" && sPhoneVMVal != ""){
                                        $(".sPhoneCallDrop").removeClass("sCall").addClass("dCall");
                                        $(".sPhoneCallDrop").find(".txt").text("T?t cu?c g?i");
                                        sPhoneGetVal = 84 + sPhoneGetVal;
                                        $(".sPhoneGetVal").removeClass("error");
                                        VM_STRIGEE.makeCall(sPhoneVMVal, sPhoneGetVal);
                                        $(".sPhoneCallDrop").addClass("act");
                                        $(".sPhoneCallDropHold").addClass("act");
                                    }else{
                                        $(".sPhoneGetVal").addClass("error");
                                    }
                                }else{
                                    if($(".sPhoneCallDrop").hasClass("dCall")){
                                        if(sPhoneGetVal != "" && sPhoneVMVal != ""){
                                            $(".sPhoneCallDrop").removeClass("dCall").addClass("sCall");
                                            $(".sPhoneCallDrop").find(".txt").text("G?i ?i?n");
                                            VM_STRIGEE.hangupCall();
                                            VM_STRIGEE.enableButtonCall();
                                            if(objSoftphone != null) {
                                                if(objSoftphone.callId != null || objSoftphone.callId != undefined){
                                                    VM_STRIGEE.ajaxLogsCallTime(objSoftphone.callId, "stop");
                                                }
                                            }
                                            $(".sPhoneCallDrop").removeClass("act");
                                            $(".sPhoneCallDropHold").removeClass("act");
                                        }
                                    }
                                }
                            }
                        });
                        $(window).on("beforeunload",function(e){
                            if(checkClose != "undefined" && checkClose == 1){
                                var message = "Bạn có cuộc gọi. Bạn muốn đóng trình duyệt?";
                                e.returnValue = message;
                                return message;
                            }
                        });
                    });
                </script>
                '.Stringee::chageStatusStringeeFastHeader().'
                <li class="li-popup-call">
                <div class="boxPhoneDropCall">
                    <div class="iconPhoneDrop"></div>
                </div>
                <div class="contentBoxPhoneDropCall">
                    <div class="listBoxNumber">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="sPhoneTitle">Gọi cho số:</div>
                                <div class="sPhoneContentVal"><input type="text" class="form-control input-sm sPhoneGetVal"/></div>
                                <i>Dạng số: 941199656</i>
                                <div class="showTimeCall">
                                    <div class="textShowTime">Đang gọi...</div>
                                    <div class="countShowTime">00:00</div>
                                </div>
                                <div class="showCallBusy"></div>
                            </div>
                            <div class="col-md-2"><span class="icon-star-vn"></span></div>
                            <div class="col-md-5">
                                <div class="sPhoneTitle">Số tổng đài:</div>
                                <select class="form-control input-sm sPhoneVMVal" size="5">
                                    '.$option.'
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="btn sPhoneCallDrop sCall"><i class="fa fa-phone"></i> <span class="txt">Gọi điện</span></div>
                    <div class="btn sPhoneCallDropHold sHolde hCall"><i class="fa fa-phone"></i> <span class="txt">Giữ cuộc gọi</span></div>
                </div>
                <div class="hidden">
                    <span id="loggedUserId" style="color: red">Not logged</span>
                    <span id="callStatus" style="color: red">Not started</span>
                    <video id="remoteVideo" playsinline autoplay style="width: 350px"></video>
                    <video id="localVideo" class="flex-item" playsinline="" autoplay="autoplay" muted="muted"></video>
                    <audio loop="" id="sound_incomming_call" src="' . getBaseUrl('/') . '/assets/admin/js/call/sounds/incomming_call.mp3" style="display: none">
               </div>
            </li>';
        }
        $_str = Stringee::buttonShowAnswerMobile();
        return $str.$_str;
    }
    public static function checkPhoneProvideStringee($phone_number='', $phone_client=1){
        if($phone_number != ''){
            $phone_number = str_replace(array('^', '$', '\\', '/', '(', ')', '|', '?', '_', '-', '+', '.', ' ', '*', '[', ']', '{', '}', ',', '%', '<', '>', '=', '"', '“', '”', '!', ':', ';', '&', '~', '#', '`', "'", '@' ), array(''), $phone_number);
            $prex_number = '';
            $leng = strlen($phone_number);
            if($phone_client == 1){
                //Phone client: Dau vao mac dinh khong co 84 va 0
                if($leng == 9){
                    $prex_number = substr($phone_number, 0, 2);
                }elseif($leng == 10) {
                    $prex_number = substr($phone_number, 0, 3);
                }
            }else{
                //Phone setting stringee: Dau vao mac dinh nhap la co 84 va khong co 0
                if($leng == 11){
                    $prex_number = substr($phone_number, 2, 2);
                }elseif($leng == 12) {
                    $prex_number = substr($phone_number, 2, 3);
                }
            }
            $arr_dauso = CGlobal::$arr_dauso;
            $_key = Stringee::getKeyDauSo($arr_dauso, $prex_number);
            if($_key != ''){
                if(isset(CGlobal::$array_provide[$_key])){
                    return CGlobal::$array_provide[$_key];
                }
            }else{
                if($leng == 12) {
                    $prex_number = substr($phone_number, 2, 2);
                    $_key = Stringee::getKeyDauSo($arr_dauso, $prex_number);
                    if($_key != ''){
                        if(isset(CGlobal::$array_provide[$_key])){
                            return CGlobal::$array_provide[$_key];
                        }
                    }
                }
            }
        }
        return 'OT';
    }
    public static function getKeyDauSo($arr_dauso, $prex_number){
        $_key = '';
        foreach($arr_dauso as $key =>$val){
            if($val != ''){
                $val = explode(',', trim($val));
                if(in_array($prex_number, $val)){
                    $_key = $key;
                }
            }
        }
        return $_key;
    }

    public static function writePageCallApiStringee2($totalPages = 0, $numScroll=10, $linkPage='logcall'){
        if($totalPages > 1) {
            $next = '';
            $last = '';
            $prev = '';
            $first= '';
            $left_dot  = '';
            $right_dot = '';

            $page = Request::get('page_no', 1);
            $from_page = $page - $numScroll;
            $to_page = $page + $numScroll;

            $query = Request::all();
            if(isset($query['page_no'])){
                unset($query['page_no']);
            }
            $query = http_build_query($query);

            if($page > 1){
                if($query != ''){
                    $prev = '<li><a href="'.getBaseUrl('/').$linkPage.'?'.$query.'&page_no='.($page-1).'" rel="prev">«</a></li>';
                }else{
                    $first = '<li><a href="'.getBaseUrl('/').$linkPage.'?page_no='.($page-1).'" rel="prev">«</a></li>';
                }
            }else{
                $first = '<li class="disabled"><span>«</span></li>';
            }

            if($page < $totalPages){
                if($query != ''){
                    $next = '<li><a href="'.getBaseUrl('/').$linkPage.'?'.$query.'&page_no='.($page+1).'" rel="next">»</a></li>';
                }else{
                    $last= '<li><a href="'.getBaseUrl('/').$linkPage.'?page_no='.($page+1).'" rel="next">»</a></li>';
                }
            }else{
                $last = '<li class="disabled"><span>»</span></li>';
            }

            if($from_page > 0)	{
                $left_dot = ($from_page > 1) ? '<li><span>...</span></li>' : '';
            }else{
                $from_page = 1;
            }
            if($to_page < $totalPages)	{
                $right_dot = '<li><span>...</span></li>';
            }else{
                $to_page = $totalPages;
            }

            $pagerHtml = '';
            for($i=$from_page;$i<=$to_page;$i++){
                if($page == $i){
                    $class = 'class="active"';
                    $url = '<span>'.$i.'</span>';
                }else{
                    $class = '';
                    if($query != ''){
                        $url = '<a href="'.getBaseUrl('/').$linkPage.'?'.$query.'&page_no='.$i.'">'.$i.'</a>';
                    }else{
                        $url = '<a href="'.getBaseUrl('/').$linkPage.'?page_no='.$i.'">'.$i.'</a>';
                    }
                }
                $pagerHtml .= '<li '.$class.'>'.$url.'</li>';
            }
            return '<ul class="pagination">'.$first.$prev.$left_dot.$pagerHtml.$right_dot.$next.$last.'</ul>';
        }
        return '';
    }
    public static function totalCallTime($start_time=0, $stop_time=0){
        if ($start_time > 0 && $stop_time > 0 && $stop_time >= $start_time) {
            $_time = $stop_time - $start_time;
            $sd = $_time % 60;
            $sn = ($_time - $_time%60)/60;
            return $sn.'p'.$sd.'s';
        }
        return 0;
    }
    public static function getUserMailCallApiStringee($result = array()){
        $arrItem = array();
        if(sizeof($result) > 0){
            foreach($result as $item){
                $arrCheck = explode('_', $item->from_user_id);
                if(isset($arrCheck[1]) &&  isset($arrCheck[2])){
                    if($item->from_user_id != ''){
                        $mail = $arrCheck[1] . '@' . $arrCheck[2];
                        $arrItem['mail'][$item->from_user_id] = $mail;
                    }
                }else{
                    if($item->from_user_id != ''){
                        $arrItem['call'][$item->id] = $item->from_user_id;
                    }
                }
            }
        }
        return $arrItem;
    }
    public static function totalCallCount($from_number, $to_number, $from_user_id, $from_date, $to_date, $page, $limit){
        $count = array(
            'success' => 0,
            'miss' => 0
        );

        $result = app(LogCallHistoryService::class)->loadCallHistory($from_number, $to_number, $from_user_id, $from_date, $to_date, $page, $limit);
        $result = json_decode($result);
        $records = isset($result->data->calls) ? $result->data->calls : array();
        $totalPages = isset($result->data->totalPages) ? $result->data->totalPages : 0;

        $_records = array();
        if ($totalPages > 1){
            for ($i = 2; $i <= $totalPages; $i++) {
                $_result = app(LogCallHistoryService::class)->loadCallHistory($from_number, $to_number, $from_user_id, $from_date, $to_date, $i, $limit);
                $_result = json_decode($_result);
                $_records = isset($_result->data->calls) ? $_result->data->calls : array();
                foreach($_records as $item){
                    $records[] = $item;
                }
            }
        }

        if(sizeof($records) > 0){
            foreach($records as $item){
                $answer_time = (int)substr($item->answer_time, 0, -3);
                $stop_time = (int)substr($item->stop_time, 0, -3);
                if($answer_time == 0){
                    $count['miss'] += 1;
                }else{
                    if($stop_time - $answer_time > 0){
                        $count['success'] += 1;
                    }else{
                        $count['miss'] += 1;
                    }
                }
            }
        }
        return $count;
    }
    public static function checkRegexEmail($str=''){
        if($str != ''){
            $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
            if(!preg_match($regex, $str)){
                return false;
            }
            return true;
        }
        return false;
    }
    public static function buttonShowAnswerMobile(){
        $check = Stringee::isTrueAgentStringee();
        $str = '';
        if($check) {
            $str = '
                <div class="modal fade sPopup" id="sPopupCallToAgent" tabindex="-1" role="dialog" aria-hidden="false" data-backdrop="static" data-keyboard="false">
                <div class="modal-backdrop fade" style="height: 259px;"></div>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Cuộc gọi đến từ khách hàng...
                            <button id="btnHangupCall" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="wrap-icon">
                                <div class="numPhoneCustomerCall">Tới số: <span></span></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnRejectCall" type="button" class="btn btn-secondary btn-sm">Bỏ qua</button>
                            <button id="btnAnswerCall" type="button" class="btn btn-primary btn-sm">Trả lời</button>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        return $str;
    }
    public static function checkNameAgentStringee($prefix=PREFIX_STRINGEE_USER, $user_name=''){
        if($user_name != ''){
            $user_name_stringee = $prefix . str_replace('@', '_', strtolower($user_name));
            if(in_array($user_name_stringee, Stringee::getArrUserAgentStringee())){
                return $user_name_stringee;
            }
        }
        return $user_name;
    }
    public static function isTrueAgentStringee(){
        $User = app(User::class)->user_login();
        $user_mail = isset($User['user_email']) ? $User['user_email'] : '';
        $result = Stringee::checkNameAgentStringee(PREFIX_STRINGEE_USER, strtolower($user_mail));
        if(in_array($result, Stringee::getArrUserAgentStringee())){
            return true;
        }
        return false;
    }
    public static function getArrUserAgentStringee(){
        $result = app(UsersPhoneStringeeAgent::class)->getAllAgentActive();
        return $result;
    }
    public static function convertMailToUserStringee($prefix=PREFIX_STRINGEE_USER, $user_name=''){
        if($user_name != ''){
            $user_name_stringee = $prefix . str_replace('@', '_', strtolower($user_name));
            return $user_name_stringee;
        }
        return $user_name;
    }
    public static function chageStatusStringeeFastHeader(){
        $User = app(User::class)->user_login();
        $user_email = isset($User['user_email']) ? $User['user_email'] : '';
        $str = '';
        if($user_email != ''){
            $agent_user = Stringee::convertMailToUserStringee(PREFIX_STRINGEE_USER, $user_email);
            if($agent_user != ''){
                $getItem = app(UsersPhoneStringeeAgent::class)->checkAgentUserExist($agent_user);
                if(isset($getItem->id)){
                    if(isset($getItem->agent_status) && $getItem->agent_status == 'AVAILABLE'){
                        $checked = 'checked="checked"';
                    }else{
                        $checked = '';
                    }
                    $str = '<li class="li-status-call">
                        <label class="switch chageAgentStatus" user-id="'.$getItem->agent_user.'" agent-id="'.$getItem->agent_id.'">
                            <input type="checkbox" class="statusAgent" value="1" '.$checked.'>
                            <span class="slider round"></span>
                        </label>
                    </li>';
                }
            }
        }
        return $str;
    }
    public static function calcTotalCallTime($total_time=0){
        if ($total_time > 0) {
            $s = $total_time % 60;
            $_p = ($total_time - $total_time%60)/60;
            if($_p >= 60){
                $p =  $_p % 60;
                $h = ($_p - $_p%60)/60;
            }else{
                $p =  $_p;
                $h = 0;
            }
            return $h . ':' . $p . ':' . $s;
        }
        return 0;
    }
    public static function convertScheduleOption($call_type='', $call_status='', $call_type_default='', $schedule_option=array()){
        if(in_array($call_type, $schedule_option)){
            if($call_type_default == $call_type){
                if($call_status == 'ended'){
                    return 'Không';
                }elseif($call_status == 'answered'){
                    return 'Có';
                }else{
                    return '---';
                }
            }else{
                return '---';
            }
        }
        return '---';
    }
    //He thong VM
    public static function callPageTotal($totalRecord=0, $limit=200){
        $totalPage = 1;
        if($totalRecord > $limit){
            $totalPage = ceil($totalRecord/$limit);
        }
        return $totalPage;
    }
    public static function totalCallCountVM($data = array()){
        $count = array(
            'success' => 0,
            'miss' => 0
        );
        if(sizeof($data) > 0){
            foreach($data as $item){
                $answer_time = (int)$item->time_answer;
                $stop_time = (int)$item->time_stop;
                if($answer_time == 0){
                    $count['miss'] += 1;
                }else{
                    if($stop_time - $answer_time > 0){
                        $count['success'] += 1;
                    }else{
                        $count['miss'] += 1;
                    }
                }
            }
        }
        return $count;
    }
}