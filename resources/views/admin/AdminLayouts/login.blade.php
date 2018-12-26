<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Login Page - Ace Admin</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/admin_css.css')}}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/lib/font-awesome/4.2.0/css/font-awesome.min.css')}}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/lib/fonts/fonts.googleapis.com.css')}}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/bootstrap.min.css')}}"/>

    <!-- ace styles -->
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace.min.css')}}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/ace-part2.min.css')}}" />
    <script src="{{URL::asset('assets/js/jquery.2.1.1.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.1.11.1.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/ace-extra.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/html5shiv.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/respond.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/admin.js')}}"></script>
    <script type="text/javascript">
        var WEB_ROOT = "<?php echo e(URL::to('/')); ?>";
    </script>
    <![endif]-->
</head>

<body class="login-layout">
    @yield('content')

    <div class="modal fade" id="sys_forgot_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Quên mật khẩu</h4>
                </div>
                {{Form::open(array('method' => 'POST','role'=>'form'))}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label text-left">{{viewLanguage('Email đăng ký')}}<span class="red"> (*) </span></label>
                        <input type="text" id="email_forgot_password" name="email_forgot_password"  class="form-control input-sm" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_forgot_password">
                    <a href="javascript:void(0);" id="actionSendNotiLoan" class="btn btn-primary" onclick="submit_forgot_password()">{{viewLanguage('Gửi lại mật khẩu')}}</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{viewLanguage('Hủy')}}</button>
                </div>
                {{ csrf_field() }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <script>
        function show_form_forgot() {
            $('#sys_forgot_password').modal('show');
            $('#email_forgot_password').val('');
        }
        function submit_forgot_password() {
            var email_forgot_password = $('#email_forgot_password').val();
            var _token = $('input[name="_token"]').val();
            if(Admin.isEmailAddress(email_forgot_password)){
                $('#img_loading_forgot_password').show();
                $.ajax({
                    type: "POST",
                    url:'<?php echo e(URL::route('admin.forgot_password')); ?>',
                    data: {email_forgot_password: email_forgot_password, _token: _token},
                    dataType: 'json',
                    success: function (res) {
                        $('#img_loading_forgot_password').hide();
                        if(res.isOk == 1){
                            alert(res.msg);
                            $('#sys_forgot_password').modal('hide');
                        }else {
                            alert(res.msg);
                        }
                    }
                });
            }else {
                alert('Bạn nhập sai định dạng mai');
            }
        }
    </script>
</body>
</html>
