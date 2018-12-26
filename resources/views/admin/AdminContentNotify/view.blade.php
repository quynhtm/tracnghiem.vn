<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\CGlobal; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<link media="all" type="text/css" rel="stylesheet" href="{{URL::asset('assets/admin/css/bootstrap-datepicker.css')}}"/>
<script type="text/javascript" language="JavaScript" src="{{URL::asset('assets/admin/js/bootstrap-datepicker.js')}}"></script>
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">{{CGlobal::$pageAdminTitle}}</li>
        </ul>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <form method="Post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label for="code"><i>{{viewLanguage('Mã thông báo')}}</i></label>
                                <input type="text" class="form-control input-sm" id="code" name="code" placeholder="Mã nhà đảm bảo" @if(isset($search['code']))value="{{$search['code']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="object_receive"><i>{{viewLanguage('Đối tượng')}}</i></label>
                                <select class="form-control" name="object_receive">
                                    <option value="-2">---{{viewLanguage('Chọn đối tượng')}}---</option>
                                    {!! $optionObjectReceives !!}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="career_receive"><i>{{viewLanguage('Theo sản phẩm vay')}}</i></label>
                                <select class="form-control" name="product_receive">
                                    <option value="">---{{viewLanguage('Chọn sản phẩm vay')}}---</option>
                                    {!! $optionProducts !!}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="type_noti"><i>{{viewLanguage('Loại')}}</i></label>
                                <select class="form-control" name="type_noti">
                                    <option value="-2">---{{viewLanguage('Chọn loại gửi')}}---</option>
                                    {!! $optionTypeNoti !!}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="type_send"><i>{{viewLanguage('Phương thức gửi')}}</i></label>
                                <select class="form-control" name="type_send">
                                    <option value="-2">---{{viewLanguage('Chọn phương thức gửi')}}---</option>
                                    {!! $optionTypeSend !!}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>{{viewLanguage('Từ Ngày Tạo')}}</label>
                                <input type="date" class="form-control input-sm" name="s_date" placeholder="{{viewLanguage('Từ Ngày Tạo')}}" @if(isset($search['s_date']) && $search['s_date'] != '')value="{{$search['s_date']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>{{viewLanguage('Đến Ngày Tạo')}}</label>
                                <input type="date" class="form-control input-sm" name="e_date" placeholder="{{viewLanguage('Đến Ngày Tạo')}}" @if(isset($search['e_date']) && $search['e_date'] != '')value="{{$search['e_date']}}"@endif>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-left">
                                <a class="btn btn-danger btn-sm" href="{{route('admin.contentNotifyEdit', ['id' => 0])}}"><i class="fa fa-plus"></i> {{viewLanguage('Thêm mới')}}</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-sm" id="reset" href="{{route('admin.contentNotifyView')}}"><i class="fa fa-recycle"></i> {{viewLanguage('Bỏ lọc')}}</a>
                                <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total>0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="">
                                <th width="3%" class="text-center">{{viewLanguage('STT')}}</th>
                                <th width="11%" class="text-center">{{viewLanguage('Mã thông báo')}}</th>
                                <th width="12%" class="text-center">{{viewLanguage('Tên thông báo')}}</th>
                                <th width="12%" class="text-center">{{viewLanguage('Nội dung thông báo')}}</th>
                                <th width="9%" class="text-center">{{viewLanguage('Đối tượng')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Sản phẩm vay')}}</th>
                                <th width="7%" class="text-center">{{viewLanguage('Loại')}}</th>
                                <th width="7%" class="text-center">{{viewLanguage('Phương thức')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Thời gian tạo')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Thời gian gửi')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Hành động')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr class="detailView" data-action="{{route('admin.contentNotifyEdit', ['id' => $item['id']])}}">
                                    <td class="text-center">{{$key + 1}}</td>
                                    <td class="text-center middle">{{ $item['code'] }}</td>
                                    <td class="text-center middle">{{ $item['name'] }}</td>
                                    <td class="text-center middle">{{ str_limit($item['content_send'], 10, '...') }}</td>
                                    <td class="text-center middle">{{ isset($dataObjectReceives[$item['object_receive']]) ?  $dataObjectReceives[$item['object_receive']] : $item['object_receive']}}</td>
                                    <td class="text-center middle">{{ isset($dataProducts[$item['product_receive']]) ?  $dataProducts[$item['product_receive']] : ($item['product_receive'] == 'Total' ? viewLanguage('Tất cả') : $item['product_receive'])}}</td>
                                    <td class="text-center middle">{{ isset($dataTypeNoti[$item['type_noti']]) ? $dataTypeNoti[$item['type_noti']] : $item['type_noti']}}</td>
                                    <td class="text-center middle">
                                        @if ($item['type_send'] == STATUS_INT_KHONG)
                                            {{viewLanguage('Đặt lịch')}}
                                        @elseif($item['status'] == STATUS_INT_MOT && $item['type_send'] == STATUS_INT_MOT)
                                            <a href="javascript:void(0)" onclick="Admin.sendMultiNotificationForLoaner('{{$item['product_receive']}}','{{$item['content_send']}}','{{$item['id']}}')" class="btn btn-sm btn-danger"><i class="fa fa-send"></i>&nbsp;&nbsp;{{viewLanguage('Gửi ngay')}}</a>
                                        @endif
                                    </td>
                                    <td class="text-center middle">{{ date('H:i d/m/Y', strtotime($item['created_at'])) }}</td>
                                    <td class="text-center middle">{{ date('H:i d/m/Y', strtotime($item['time_to_send']))}}</td>
                                    <?php
                                    $style_background = '';
                                    $style_text = '';
                                    if(isset(CGlobal::$array_content_notification_status[$item['status']])){
                                        $style_background = CGlobal::$array_content_notification_status[$item['status']]['background'];
                                        $style_text = CGlobal::$array_content_notification_status[$item['status']]['text'];
                                    }
                                    ?>
                                    <td class="text-center middle {{$style_background}}">
                                        <a href="javascript:void(0);" class="{{$style_text}}" ><span>{{$arrStatus[$item['status']]}}</span></a>
                                    </td>
                                    <td class="text-center middle">
                                        @if($is_root || $permission_full || $permission_delete)
                                            <div class="col-sm-12">
                                                <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['id']}},11)" title="Xóa Item">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </div>
                                        @endif
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