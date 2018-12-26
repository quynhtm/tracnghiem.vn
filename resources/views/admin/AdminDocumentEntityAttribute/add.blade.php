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
            <li><a href="{{URL::route('admin.documentEntityAttributeView')}}"> {{viewLanguage('Danh sách thuộc tính hồ sơ')}}</a></li>
            <li class="active">@if($id > 0){{viewLanguage('Cập nhật')}}@else {{viewLanguage('Tạo mới')}} @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
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
                            <label for="name" class="control-label"><b>{{viewLanguage('Tên thuộc tính')}}<span class="red"> (*) </span></b></label>
                            <input type="text" id="name" name="name"  class="form-control input-sm" value="@if(isset($data['name'])){{$data['name']}}@endif">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label"><b>{{viewLanguage('Mã thuộc tính')}}<span class="red"> (*) </span></b></label>
                            <input type="text" id="url" name="code"  class="form-control input-sm" value="@if(isset($data['code'])){{$data['code']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label"><b>{{viewLanguage('Thuộc loại hồ sơ')}}</b></label>
                            <select name="document_type_id" id="document_type_id" class="form-control input-sm" >
                                @foreach($document_types as $document_type)
                                    <option value="{{$document_type->id}}">{{$document_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="sort" class="control-label"><b>{{viewLanguage('Thứ tự hiển thị')}}</b></label>
                            <input type="text" id="position" name="position"  class="form-control input-sm" value="@if(isset($data['position'])){{$data['position']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="name" class="control-label"><b>{{viewLanguage('Định dạng thuộc tính')}}</b></label>
                            <select name="input_type" id="input_type" class="form-control input-sm" onchange="Admin.showChooseFile()">
                                @foreach($input_types as $input_type)
                                    <option value="{{$input_type}}">{{$input_type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="sort" class="control-label"><b>{{viewLanguage('Dữ liệu theo định dạng')}}</b></label>
                            <input type="text" id="input_data" name="input_data"  class="form-control input-sm" value="@if(isset($data['input_data'])){{$data['input_data']}}@endif">
                            <input type="file" id="file_excel_document" name="file_excel_document" class="hidden">
                            <label for="file_excel_document" class="custom-file-upload hidden">
                                Chọn file
                            </label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left">
                        <a class="btn btn-warning" href="{{URL::route('admin.bannerView')}}"><i class="fa fa-reply"></i> {{viewLanguage('back')}}</a>
                        @if($is_root || $permission_full || $permission_create)
                        <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> {{viewLanguage('save')}}</button>
                        @endif
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
    <script>
        $(document).ready(function () {
            var selected_document_type = "<?php echo isset($data['document_type_id']) ? ($document_types[$data['document_type_id']]['id']) : ''; ?>"
            var selected_input_type = "<?php echo isset($data['input_type']) ? ($data['input_type']) : ''; ?>"
            $("#document_type_id").val(selected_document_type);
            $("#input_type").val(selected_input_type);

            if ($('#input_type').val() == 'select') {
                $('.custom-file-upload').removeClass('hidden')
            }
            else {
                $('.custom-file-upload').addClass('hidden')
            }
        })

    </script>
@stop
