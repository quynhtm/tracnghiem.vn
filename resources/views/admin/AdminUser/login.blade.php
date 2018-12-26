@extends('admin.AdminLayouts.login')
@section('content')
    <div class="block_login_center">
        <div class="form_login">
            {{ Form::open(array('class'=>'form-signin', 'url'=>URL::route('admin.login'))) }}
            <div class="form_login_content">
                @if(isset($error) && $error != '')
                    <div class="clear"></div>
                    <span class="float-L marginTop5 msg_error"> ** {{$error}}</span>
                @endif
                <div class="form_login_input">
                    <div class="label_input">Tên đăng nhập</div>
                    <input type="text" class="login_input" name="user_name" placeholder="Tên đăng nhập" @if(isset($username)) value="{{$username}}" @endif>
                    <div class="label_input marginTop10">Mật khẩu</div>
                    <input type="password" class="login_input" name="user_password" placeholder="Mật khẩu">
                    <div class="marginTop10">
                        <span class="marginTop5">
                            <input type="checkbox" class="login_input_checkbox"><b class="remeber_account">Nhớ tài khoản</b>
                        </span>
                        <span style="float: right">
                            <a href="javascript:void(0);" onclick="show_form_forgot();" ><b class="remeber_account">Quên mật khẩu</b></a>
                        </span>
                    </div>
                    <button type="submit" name="submit" class="button_login" >Đăng nhập</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <script>
        jQuery(document).ready(function() {
            $('.phpdebugbar').css('display', 'none');
        });
    </script>
@stop