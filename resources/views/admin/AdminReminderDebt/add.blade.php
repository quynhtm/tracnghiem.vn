<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
@extends('admin.AdminLayouts.index')
@section('content')
    <div class="main-content-inner">
        <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="{{URL::route('admin.dashboard')}}">{{viewLanguage('Trang chủ')}}</a>
                </li>
                <li><a href="{{URL::route('admin.reminderDebtView')}}"> {{viewLanguage('Danh sách audio thu nợ')}}</a></li>
                <li class="active">@if($id > 0){{viewLanguage('Cập nhật')}}@else {{viewLanguage('Tạo mới')}} @endif</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    {{Form::open(array('method' => 'POST','role'=>'form','files' => true,'id'=>'form_add_reminder_debt'))}}
                    @if(isset($error) && !empty($error))
                        <div class="alert alert-danger" role="alert">
                            @foreach($error as $itmError)
                                <p>{{ $itmError }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div style="float: left; width: 50%">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sort" class="control-label">{{viewLanguage('Tên audio')}}</label>
                                <input type="text" id="name_audio" name="name_audio"  class="form-control input-sm" required value="@if(isset($data['name_audio'])){{$data['name_audio']}}@endif">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Trạng thái nhắc nợ')}}</label>
                                <select id="remind_type" name="remind_type" class="form-control">
                                    @foreach(\App\Http\Models\Admin\ReminderDept::$array_remind_type as $key_remind_type => $value_remind_type)
                                        <option value="{{$key_remind_type}}">{{$value_remind_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach(\App\Http\Models\Admin\ReminderDept::$array_status as $key_status => $value_status)
                                        <option value="{{$key_status}}">{{$value_status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="image" class="control-label">{{viewLanguage('File audio')}}</label>
                                <input type="file" name="audio" id="audio">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                @if(isset($data['link_audio']) && $data['link_audio'] !== '')
                                <audio controls>
                                    <source src="{{URL_IMAGE.$data['link_audio']}}" type="audio/ogg">
                                    <source src="{{URL_IMAGE.$data['link_audio']}}" type="audio/mpeg">
                                </audio>
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sort" class="control-label">{{viewLanguage('Mô tả')}}</label>
                                <textarea rows="3" type="text" id="decscription" name="decscription"  class="form-control input-sm" required>@if(isset($data['decscription'])){{$data['decscription']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sort" class="control-label">{{viewLanguage('Nội dung')}}</label>
                                <textarea rows="3" type="text" id="content" name="content"  class="form-control input-sm" required>@if(isset($data['content'])){{$data['content']}}@endif</textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12 text-left">
                            <a class="btn btn-warning" href="{{URL::route('admin.reminderDebtView')}}"><i class="fa fa-reply"></i> {{viewLanguage('back')}}</a>
                            @if($is_root || $permission_full || $permission_create)
                                <button  class="btn btn-primary" type="button" id="button_save" onclick="Admin.submitForm('form_add_reminder_debt','button_save')"><i class="fa fa-floppy-o"></i> {{viewLanguage('save')}}</button>
                            @endif
                            @if($is_root || $permission_full || $permission_active)
                                @if(isset($data['status']))
                                    @if($data['status'] == STATUS_INT_AM_MOT || $data['status'] == STATUS_INT_KHONG)
                                        <button  class="btn btn-primary" name="active_button"><i class="fa fa-floppy-o"></i> {{viewLanguage('Kích hoạt')}}</button>
                                    @endif
                                @endif
                            @endif
                            @if($is_root || $permission_full || $permission_deactive)
                                @if(isset($data['status']))
                                    @if($data['status'] == STATUS_INT_MOT)
                                        <button  class="btn btn-primary" name="deactive_button" type="button" onclick="Admin.submitForm()"><i class="fa fa-floppy-o"></i> {{viewLanguage('Dừng')}}</button>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                        <input type="hidden" id="link_audio_old" name="link_audio_old" value="@if(isset($data['link_audio'])){{$data['link_audio']}}@else{{''}}@endif"/>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div><!-- /.page-content -->
    </div>
    <script>
        $(document).ready(function () {
            var selected_remind_type = "<?php echo isset($data['remind_type']) ? $data['remind_type'] : -1; ?>"
            var selected_status = "<?php echo isset($data['status']) ? ($data['status']) : -1; ?>"
            $("#remind_type").val(selected_remind_type);
            $("#status").val(selected_status);
        })

    </script>
@stop
