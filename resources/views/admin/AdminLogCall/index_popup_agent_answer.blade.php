<?php
use App\Http\Models\Admin\User;
$User = app(User::class)->user_login();
$token_stringee = isset($User['token_stringee']) ? $User['token_stringee'] :'';
?>
<script>
    var WEB_ROOT = '<?= URL::to('/'); ?>';
</script>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?= getBaseUrl() ?>assets/lib/bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="<?= getBaseUrl() ?>assets/js/jquery.2.1.1.min.js"></script>
    <script type="text/javascript" src="<?= getBaseUrl() ?>assets/admin/js/call/socket.io-2.0.3.js"></script>
    <script type="text/javascript" src="<?= getBaseUrl() ?>assets/admin/js/call/StringeeSDK-1.3.9.js"></script>
    <script type="text/javascript" src="<?= getBaseUrl() ?>assets/admin/js/call/customers-call-pupup.js"></script>
</head>
<body>
<div class="wrapPopupCallStringee">
    <div class="hidden">
        <input type="hidden" class="token_stringee" name="token_stringee" value="<?= $token_stringee ?>" />
        {{ csrf_field() }}
        <span id="loggedUserId" style="color: red">Not logged</span>
        <span id="callStatus" style="color: red">Not started</span>
        <video id="remoteVideo" playsinline autoplay style="width: 350px"></video>
        <video id="localVideo" class="flex-item" playsinline="" autoplay="autoplay" muted="muted"></video>
    </div>
    <div class="lineCall">Cuộc gọi từ số: <b><span class="customerPhoneCall"></span></b></div>
    <div class="lineCall">Thời gian: <b><span class="countTime"></span></b></div>
    <button id="btnHangupCall" type="button" class="btn btn-danger btn-sm">Tắt cuộc gọi</button>
    <button id="btnHoldCall" type="button" class="btn btn-warning btn-sm hCall">Giữ cuộc gọi</button>
</div>
<style>
    .wrapPopupCallStringee{width: 20%;margin: 10% auto;text-align: center;}
    .lineCall{margin-bottom: 10px;display: inline-block;width: 100%;}
</style>
</body>
</html>