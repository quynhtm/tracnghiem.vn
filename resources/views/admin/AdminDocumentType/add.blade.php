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
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                <div class="panel panel-info">
                    <form method="Post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label for="name"><b>{{viewLanguage('Tên sản phẩm vay')}}</b></label>
                                    <input type="text" class="form-control input-sm" id="name" name="name" placeholder="Tên hồ sơ" @if(isset($data['name']))value="{{$data['name']}}"@endif>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="status" class="control-label text-bold">{{viewLanguage('Trạng thái')}}</label>
                                    <input type="text" class="form-control input-sm" id="code" name="code" placeholder="Mã hồ sơ" @if(isset($data['code']))value="{{$data['code']}}"@endif>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label for="status" class="control-label text-bold">{{viewLanguage('Yêu cầu')}}</label>
                                    <select name="require" id="require" class="form-control input-sm" >
                                        @foreach($requires as $key_require => $require)
                                            <option value="{{$key_require}}">{{$require}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="status" class="control-label text-bold">{{viewLanguage('Hiển thị')}}</label>
                                    <select name="display" id="display" class="form-control input-sm" >
                                        @foreach($displays as $key_display => $display)
                                            <option value="{{$key_display}}">{{$display}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="status" class="control-label text-bold">{{viewLanguage('Kiểu sử dụng')}}</label>
                                    <select name="purpose" id="purpose" class="form-control input-sm" >
                                        @foreach($purposes as $key_purpose => $purpose)
                                            <option value="{{$key_purpose}}">{{$purpose}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 text-left">
                                    <a class="btn btn-warning" href="{{URL::route('admin.documentTypeView')}}"><i class="fa fa-reply"></i> {{viewLanguage('back')}}</a>
                                    @if($is_root || $permission_full || $permission_create)
                                        <button  class="btn btn-primary"><i class="fa fa-floppy-o"></i> {{viewLanguage('save')}}</button>
                                    @endif
                                </div>
                                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                            </div>
                        </div>
                    </form>
                </div>
                {{ Form::close() }}
            </div>
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <div class="form-group " style=" background: #fafafa;padding: 20px;margin : 0;border-radius: 5px;color: #767676">
                        <h3><b>Danh sách thuộc tính hồ sơ</b></h3>
                    </div>
                    <div class="panel-body line" id="element">
                        {{--<div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>--}}
                        <table class="table table-bordered bg-head-table">
                            <thead>
                            <tr >
                                {{--<th width="" class="text-center">{{viewLanguage('STT')}}</th>--}}
                                <th width="25%">{{viewLanguage('Tên thuộc tính')}}</th>
                                <th width="25%" class="text-center">{{viewLanguage('Tên hồ sơ')}}</th>
                                <th width="20%" class="text-center">{{viewLanguage('Ngày tạo')}}</th>
                                <th width="20%" class="text-center">{{viewLanguage('Ngày cập nhật')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($infor_entity_attributes) && sizeof($infor_entity_attributes))
                                @foreach($infor_entity_attributes as $k=>$item)
                                    <tr class="detailView" data-action="{{route('admin.documentEntityAttributeEdit',['id'=>$item['id']])}}">
                                        {{--<td class="text-center">{{$stt + $k + 1}}</td>--}}
                                        <td width="25%">{{$item->name}}</td>
                                        <td width="25%">{{$data['name']}}</td>
                                        <td width="20%">{{$item->created_at}}</td>
                                        <td width="20%">{{$item->updated_at}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
    <script>
        $(document).ready(function () {
            var selected_purpose = "<?php echo isset($data['purpose']) ? ($data['purpose']) : 'profile'; ?>"
            var selected_require = "<?php echo isset($data['require']) ? ($data['require']) : 'require'; ?>"
            var selected_display = "<?php echo isset($data['display']) ? ($data['display']) : 'display'; ?>"
            $("#purpose").val(selected_purpose);
            $("#require").val(selected_require);
            $("#display").val(selected_display);
        })

    </script>
@stop
