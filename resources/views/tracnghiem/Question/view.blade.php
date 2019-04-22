<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active"><a href="{{URL::route('tracnghiem.questionView')}}">{{$pageAdminTitle}}</a></li>
        </ul>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <form method="get" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label for="name"><i>{{viewLanguage('Tên câu hỏi')}}</i></label>
                                <input type="text" class="form-control input-sm" id="question_name" name="question_name" placeholder="Tên câu hỏi" @if(isset($search['question_name']))value="{{$search['question_name']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Ẩn/hiện')}}</label>
                                <select name="question_status" id="question_status" class="form-control input-sm">
                                    {!! $optionStatus !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Trạng thái duyệt')}}</label>
                                <select name="question_approved" id="question_approved" class="form-control input-sm">
                                    {!! $optionApprove !!}}
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <div class="pull-left">
                                <a class="btn btn-sm btn-warning btnApproveQuestion" href="javascript:void(0);"title="Gửi chờ duyệt">Chọn câu hỏi trộn đề</a>
                                <a class="btn btn-sm btn-success btnApproveQuestion" href="javascript:void(0);"title="Gửi chờ duyệt">Trộn đề</a>
                            </div>
                            @if(($is_root || $permission_full || $permission_approve))
                                <a class="btn btn-sm btn-warning btnApproveQuestion" href="javascript:void(0);"title="Gửi chờ duyệt">Gửi chờ duyệt</a>
                            @endif
                            <a class="btn btn-warning btn-sm" href="{{URL::route('tracnghiem.mixAutoQuestion')}}"><i class="fa fa-search"></i> {{viewLanguage('Tạo dề thi')}}</a>
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                        </div>
                    </form>
                </div>
                @if(isset($data) && sizeof($data) > 0)
                    <div class="col-md-12">

                        <br/>
                        <div class="span pull-left"> @if($total >0) Có tổng số <b>{{$total}}</b> tài khoản  @endif </div>

                        <div class="clearfix"></div><br/>

                        {{Form::open(array('method' => 'POST', 'role'=>'form', 'class' =>'frmApproveQuestionList','files' => false, 'url'=>URL::route('tronNgauNhien.approveTronNgauNhien')))}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tableApproveQuestion">
                                <thead class="thin-border-bottom">
                                <tr class="">
                                    <th width="3%" class="text-center">STT <br/> <input type="checkbox" id="checkAll"></th>
                                    <th width="30%">Câu hỏi</th>
                                    <th width="10%" class="text-center">Câu TL 1</th>
                                    <th width="10%" class="text-center">Câu TL 2</th>
                                    <th width="10%" class="text-center">Câu TL 3</th>
                                    <th width="10%" class="text-center">Câu TL 4</th>
                                    <th width="5%">Loại câu hỏi</th>

                                    <th width="5%" class="text-center">Trạng thái</th>
                                    <th width="7%" class="text-center">Thao tác</th>
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

                                            <td class="text-center">
                                                {{isset($arrTypeQuestionText[$item->question_type]) ? $arrTypeQuestionText[$item->question_type] : ''}}
                                            </td>
                                            <td class="text-center">
                                                {{isset($arrApprove[$item->question_approved]) ? $arrApprove[$item->question_approved] : ''}}
                                            </td>
                                            <td class="text-center">
                                                @if($is_root || $permission_full || $permission_create)
                                                    <a href="{{URL::route('tronNgauNhien.suaTronNgauNhien',array('id' => $item['id']))}}" onclick="" title="Sửa"><i class="fa fa-edit fa-2x"></i></a>
                                                @endif
                                                @if(($is_root || $permission_full || $permission_delete) && $item->question_approved != STATUS_INT_HAI)
                                                    <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['id']}},13)" title="Xóa"><i class="fa fa-trash fa-2x"></i></a>
                                                @endif
                                                <br/>{{$item->created_at}}
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
</div>
@stop