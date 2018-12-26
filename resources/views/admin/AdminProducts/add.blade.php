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
            <li><a href="{{URL::route('admin.productView')}}"> {{viewLanguage('Danh sách sản phẩm vay')}}</a></li>
            <li class="active">@if($id > 0){{viewLanguage('Chi tiết')}}@else {{viewLanguage('Tạo mới')}} @endif</li>
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
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="row marginTop20 ">
                            <div class="col-lg-3 " >
                                <label for="name" class="text-bold" >{{viewLanguage('Tên sản phẩm vay')}}</label>
                                <input type="text" class="form-control paddingTopBottom" id="name" name="name" placeholder="Tên sản phẩm vay" value="@if(isset($data['name'])){{$data['name']}}@endif" >
                            </div>

                            <div class="col-lg-3">
                                <label for="name" class="text-bold">{{viewLanguage('Ngày tạo')}}</label>
                                <input type="text" class="form-control paddingTopBottom" id="created_at" value="@if(isset($data['created_at'])){{$data['created_at']}}@endif" readonly="true">
                            </div>
                            <div class="col-lg-3 " >
                                <label for="name" class="text-bold" >{{viewLanguage('Mã sản phẩm vay')}}</label>
                                <input type="text" class="form-control paddingTopBottom" id="code" name="code" placeholder="Mã sản phẩm vay" value="@if(isset($data['code'])){{$data['code']}}@endif" >
                            </div>
                            <div class="col-lg-3 " >
                                <label for="name" class="text-bold" >{{viewLanguage('Loại sản phẩm')}}</label>
                                <select class="form-control" name="type_product" id="type_product" style="height: 43px">
                                    {!! $optionTypeProduction !!}
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer text-left">
                        @if((isset($data['status']) && $data['status'] == STATUS_NEW) || $id == 0)
                            <button class="btn btn-success btn-sm" type="submit" name="status" value="1"><i class="fa fa-check-square"></i> {{viewLanguage('Kích hoạt')}}</button>
                        @endif
                        @if($is_root || $permission_full || $permission_create)
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-save"></i> {{viewLanguage('Lưu lại')}}</button>
                        @endif
                        @if($id > 0)
                            @if($is_root || $permission_full || $permission_delete)
                                <button class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash-o"></i> {{viewLanguage('Xóa')}}</button>
                            @endif
                        @endif
                    </div>
                </div>

                <ul class="nav nav-tabs marginTop30 text-bold" >
                    <li class="active"><a data-toggle="tab" href="#home"> Chi tiết</a></li>
                    <li ><a data-toggle="tab" href="#menu1">Lãi và phí</a></li>
                    <li ><a data-toggle="tab" href="#menu2">Hồ sơ yêu cầu</a></li>
                    <li ><a data-toggle="tab" href="#menu3">Thông tin khác</a></li>
                </ul>

                <div class="tab-content">
                    @include('admin.AdminProducts.component.tab1')
                    @include('admin.AdminProducts.component.tab2')
                    @include('admin.AdminProducts.component.tab3')
                    @include('admin.AdminProducts.component.tab4')
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
<script>
    $(document).ready(function(){
        $("#fee_rate").keyup(function(){
            if(isNaN(parseInt($('#ensure_rate').val()))){
                $('#total_fee').val(parseInt($('#fee_rate').val()))
            }
            else{
                $('#total_fee').val(parseInt($('#fee_rate').val()) + parseInt($('#ensure_rate').val()));
            }
        });
        $("#ensure_rate").keyup(function(){
            if(isNaN(parseInt($('#fee_rate').val()))){
                $('#total_fee').val(parseInt($('#ensure_rate').val()))
            }
            else{
                $('#total_fee').val(parseInt($('#fee_rate').val()) + parseInt($('#ensure_rate').val()));
            }
        });
    });
</script>
@stop
