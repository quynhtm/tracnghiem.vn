<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\CGlobal; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">Quản lý sản phẩm vay</li>
        </ul>
    </div>
    @if(isset($error) && !empty($error))
        <div class="alert alert-danger" role="alert">
            @foreach($error as $itmError)
                <p>{{ $itmError }}</p>
            @endforeach
        </div>
    @endif
    @if(isset($success) && !empty($success))
        <div class="alert alert-danger" role="alert">
            <p>{{ $success }}</p>
        </div>
    @endif
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <form method="Post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label for="name"><i>{{viewLanguage('Tên sản phẩm vay')}}</i></label>
                                <input type="text" class="form-control input-sm" id="name" name="name" placeholder="Tên sản phẩm vay" @if(isset($search['name']))value="{{$search['name']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                                <select name="status" id="status" class="form-control input-sm">
                                    {!! $optionStatus !!}}
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            @if($is_root || $permission_full || $permission_create)
                                 <a class="btn btn-danger btn-sm" href="{{URL::route('admin.productEdit',array('id' => 0))}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                     {{viewLanguage('add')}}
                                 </a>
                            @endif
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                        </div>
                    </form>
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="">
                                <th width="5%" class="text-center">{{viewLanguage('Mã SPV')}}</th>
                                <th width="18%">{{viewLanguage('Sản phẩm vay')}}</th>
                                <th width="10%">{{viewLanguage('Số tiền vay tối thiểu')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Số tiền vay tối đa')}}</th>
                                <th width="5%" class="text-center">{{viewLanguage('Lãi suất vay(%/năm)')}}</th>
                                <th width="5%" class="text-center">{{viewLanguage('Phí sàn GD(%/năm)')}}</th>
                                <th width="5%" class="text-center">{{viewLanguage('Phí đảm bảo(%/năm)')}}</th>
                                <th width="5%" class="text-center">{{viewLanguage('Ngày vay tối thiểu')}}</th>
                                <th width="5%" class="text-center">{{viewLanguage('Ngày vay tối đa')}}</th>
                                <th width="7%" class="text-center">{{viewLanguage('Số mốc')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                                <th width="17%" class="text-center">{{viewLanguage('Thao tác')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr class="detailView" data-action="{{route('admin.productEdit',['id'=>$item['id']])}}">
                                    <td class="text-center middle">{{ $item['id'] }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td class="text-center">{{ numberFormat($item['min_amount']) }}</td>
                                    <td class="text-center">{{ numberFormat($item['max_amount']) }}</td>
                                    <td class="text-center">{{ $item['interest_rate'] }}</td>
                                    <td class="text-center">{{ $item['fee_rate'] }}</td>
                                    <td class="text-center">{{ $item['ensure_rate'] }}</td>
                                    <td class="text-center">{{ $item['min_duration'] }}</td>
                                    <td class="text-center">{{ $item['max_duration'] }}</td>
                                    <td class="text-center">{{ $item['step_amount'] }}</td>

                                    @if($item['status'] == STATUS_SHOW)
                                    <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['background']}}@endif">
                                        <a href="javascript:void(0);" title="Kích hoạt" class="@if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['text']}}@endif" ><span>Kích hoạt</span></a>
                                    </td>
                                    @elseif($item['status'] == STATUS_NEW)
                                    <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_NEW] )) {{CGlobal::$array_color_status[STATUS_NEW]['background']}}@endif" >
                                        {{--<a href="javascript:void(0);" style="color: red" title="Mới"><i class="fa fa-close fa-2x"></i></a>--}}
                                        <a href="javascript:void(0);" class="@if(isset(CGlobal::$array_color_status[STATUS_NEW] )) {{CGlobal::$array_color_status[STATUS_NEW]['text']}}@endif" title="Mới"><span>Mới</span></a>
                                    </td>
                                    @else
                                    <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_STOP] )) {{CGlobal::$array_color_status[STATUS_STOP]['background']}}@endif" >
                                        <a href="javascript:void(0);" class="@if(isset(CGlobal::$array_color_status[STATUS_STOP] )) {{CGlobal::$array_color_status[STATUS_STOP]['text']}}@endif" title="Khoá"><span>Khoá</span></a>
                                    </td>
                                    @endif


                                    <td class="text-center middle">
                                        @if($item['status'] == STATUS_NEW)
                                            <a href="{{route('admin.productEdit',['id'=>$item['id']])}}" target="_blank" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                            @if($is_root || $permission_full || $permission_active)
                                                <a href="javascript:void(0);" title="Kích hoạt sản phẩm vay" onclick="Admin.activeItem({{$item['id']}},{{STATUS_SHOW}},'{{route('admin.activeProduct')}}',' sản phẩm vay')"><i class="fa fa-thumbs-up fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                            @endif
                                            {{--@if($is_root || $permission_full || $permission_delete)--}}
                                                {{--<a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['id']}},7)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>--}}
                                            {{--@endif--}}
                                        @endif
                                        @if($item['status'] == STATUS_SHOW)
                                            @if($is_root || $permission_full || $permission_deactive)
                                                <a href="javascript:void(0);" onclick="Admin.activeItem({{$item['id']}},{{STATUS_STOP}},'{{route('admin.activeProduct')}}',' sản phẩm vay')" title="Khoá sản phẩm vay"><i class="fa fa-lock fa-2x"></i></a>
                                            @endif
                                        @endif
                                        @if($item['status'] == STATUS_STOP)
                                            @if($is_root || $permission_full || $permission_active)
                                                <a href="javascript:void(0);" onclick="Admin.activeItem({{$item['id']}},{{STATUS_SHOW}},'{{route('admin.activeProduct')}}',' sản phẩm vay')" title="Mở sản phẩm vay"><i class="fa fa-unlock fa-2x"></i></a>
                                            @endif
                                        @endif
                                        <span class="img_loading" id="img_loading_{{$item['menu_id']}}"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {!! $paging !!}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop