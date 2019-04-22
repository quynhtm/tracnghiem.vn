<?php
    use App\Library\AdminFunction\FunctionLib;
?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">{{viewLanguage('Trang chủ')}}</a>
            </li>
            <li class="active">Trộn đề từ File</li>
        </ul>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 panel-content">
                <div class="panel panel-primary">
                    <div class="panel-heading paddingTop1 paddingBottom1">
                        <h4>
                            <i class="fa fa-edit icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Upload file trộn')}}</span>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form id="formAdd" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="file" name="myFile">
                            </div>
                            <div class="clearfix"></div>
                            {!! csrf_field() !!}
                            <button type="submit" name="btnUpload" class="btn btn-warning btn-sm" value="">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
            @if(isset($data) && sizeof($data) > 0)
                <div class="col-md-12">

                    <br/>
                    <div class="span pull-left"> @if($total >0) Có tổng số <b>{{$total}}</b> tài khoản  @endif </div>
                    @if(($is_root || $permission_full || $permission_approve))
                        <a class="btn btn-sm btn-warning pull-right btnApproveQuestion" href="javascript:void(0);"title="Gửi chờ duyệt">Gửi chờ duyệt</a>
                    @endif
                    <div class="clearfix"></div><br/>

                    {{Form::open(array('method' => 'POST', 'role'=>'form', 'class' =>'frmApproveQuestionList','files' => false, 'url'=>URL::route('tronNgauNhien.approveTronNgauNhien')))}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tableApproveQuestion">
                            <thead class="thin-border-bottom">
                            <tr class="">
                                <th width="3%" class="text-center">STT <br/> <input type="checkbox" id="checkAll"></th>
                                <th width="15%">Câu hỏi</th>
                                <th width="5%" class="text-center">Câu TL 1</th>
                                <th width="5%" class="text-center">Câu TL 2</th>
                                <th width="5%" class="text-center">Câu TL 3</th>
                                <th width="5%" class="text-center">Câu TL 4</th>
                                <!--
                                <th width="5%" class="text-center">Câu TL 5</th>
                                <th width="5%" class="text-center">Câu TL 6</th>
                                -->
                                <th width="5%">Loại câu hỏi</th>
                                <th width="5%" class="text-center">Ngày tạo</th>
                                <th width="5%" class="text-center">Trạng thái</th>
                                <th width="5%" class="text-center">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data) && sizeof($data) > 0)
                                @foreach($data as $k=>$item)
                                    <tr>
                                        <td class="text-center">{{$stt + $k + 1}} <br/> <input type="checkbox" class="check" name="item[]" value="{{$item->id}}"></td>
                                        <td>{{$item->question_name}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_MOT) text-red @endif">{{$item->answer_1}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_HAI) text-red @endif">{{$item->answer_2}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_BA) text-red @endif">{{$item->answer_3}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_BON) text-red @endif">{{$item->answer_4}}</td>
                                        <!--
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_NAM) text-green @endif">{{$item->answer_5}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_SAU) text-green @endif">{{$item->answer_6}}</td>
                                        -->
                                        <td class="text-center">
                                            {{isset($arrTypeQuestionText[$item->question_type]) ? $arrTypeQuestionText[$item->question_type] : ''}}
                                        </td>
                                        <td class="text-center">{{date('d/m/Y', $item->created_at)}}</td>
                                        <td>
                                            {{isset($arrApprove[$item->question_approved]) ? $arrApprove[$item->question_approved] : ''}}
                                        </td>
                                        <td>
                                            @if($is_root || $permission_full || $permission_create)
                                                <a href="{{URL::route('tronNgauNhien.suaTronNgauNhien',array('id' => $item['id']))}}" onclick="" title="Sửa"><i class="fa fa-edit fa-2x"></i></a>
                                            @endif
                                            @if(($is_root || $permission_full || $permission_delete) && $item->question_approved != STATUS_INT_HAI)
                                                <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['id']}},13)" title="Xóa"><i class="fa fa-trash fa-2x"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    {{ Form::close() }}
                    <div class="text-right">
                        {!! $paging !!}
                    </div>
                </div>
            @else
                <div class="alert">
                    Không có dữ liệu
                </div>
            @endif
        </div>
    </div>
</div>
@stop