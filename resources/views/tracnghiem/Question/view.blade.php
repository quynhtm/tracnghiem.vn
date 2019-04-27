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
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Khối học')}}</label>
                                <select name="question_school_block" id="question_school_block" class="form-control input-sm">
                                    {!! $optionBlock !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Môn học')}}</label>
                                <select name="question_subject" id="question_subject" class="form-control input-sm">
                                    {!! $optionSubs !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Chuyên đề')}}</label>
                                <select name="question_thematic" id="question_thematic" class="form-control input-sm">
                                    {!! $optionThematic !!}}
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <div class="pull-left">
                                <a class="btn btn-sm btn-warning btnChoseQuestion" href="javascript:void(0);"title="Gửi chờ duyệt">Chọn câu hỏi trộn đề</a>
                                <a class="btn btn-sm btn-success"  href="{{URL::route('tracnghiem.mixQuestionsView')}}"title="Gửi chờ duyệt">Trộn đề</a>
                            </div>
                            @if(($is_root || $permission_full || $permission_approve))
                                <a class="btn btn-sm btn-warning btnApproveQuestionRoot" href="javascript:void(0);"title="Gửi duyệt">Gửi duyệt</a>
                            @endif
                            <a class="btn btn-warning btn-sm" href="{{URL::route('tracnghiem.mixAutoQuestion')}}"><i class="fa fa-search"></i> {{viewLanguage('Tạo dề thi')}}</a>
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                        </div>
                    </form>
                </div>
                @if(isset($data) && sizeof($data) > 0)
                    <div class="col-md-12">

                        <br/>
                        <div class="span pull-left"> @if($total >0) Có tổng số <b>{{$total}}</b> câu hỏi  @endif </div>

                        <div class="clearfix"></div><br/>

                        {{Form::open(array('method' => 'POST', 'role'=>'form', 'class' =>'frmApproveQuestionListRoot','files' => false, 'url'=>URL::route('tronNgauNhien.approveTronNgauNhienRoot')))}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tableApproveQuestionRoot">
                                <thead class="thin-border-bottom">
                                <tr class="">
                                    <th width="3%" class="text-center">STT <br/> <input type="checkbox" id="checkAll"></th>
                                    <th width="30%">Câu hỏi</th>
                                    <th width="10%" class="text-center">Câu TL 1</th>
                                    <th width="10%" class="text-center">Câu TL 2</th>
                                    <th width="10%" class="text-center">Câu TL 3</th>
                                    <th width="10%" class="text-center">Câu TL 4</th>

                                    <td width="15%">Thông tin khác</td>

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

                                            <td>
                                                <b>Khối học:</b> {{ isset($arrBlock[$item->question_school_block]) ? $arrBlock[$item->question_school_block] : ''}} <br/>
                                                <b>Môn học:</b> {{ isset($arrSubs[$item->question_subject]) ? $arrSubs[$item->question_subject] : ''}} <br/>
                                                <b>Chuyên đề:</b> {{ isset($arrThematic[$item->question_thematic]) ? $arrThematic[$item->question_thematic] : ''}}
                                            </td>

                                            <td class="text-center">
                                                {{isset($arrTypeQuestionText[$item->question_type]) ? $arrTypeQuestionText[$item->question_type] : ''}}
                                            </td>

                                            <td class="text-center @if($item->question_approved == STATUS_INT_HAI) bg-green text-white @endif">
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
                        <input type="hidden" class="valAprove" name="valAprove" value="0">
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
<div id="sys-popup-approve" class="content-popup-show fade" style="display:none">
    <div class="modal-dialog modal-dialog-comment">
        <div class="modal-content">
            <div class="modal-title-classic">Duyệt câu hỏi <span class="btn-close" data-dismiss="modal">X</span></div>
            <div class="content-popup-body">
                <div class="classic-popup-subtitle">Trạng thái</div>
                <form id="frmRApprove" method="POST" class="frmForm" name="frmApprove" action="">
                    <div class="classic-popup-input">
                        <div>
                            <select name="approve" class="approve" class="form-control input-sm">
                                {!! $optionApprove !!}
                            </select>
                        </div>
                    </div>
                    <div class="action-popup-button">
                        <div class="btn btn-primary btn-ext" id="btnApprove" href="javascript:void(0)">Duyệt</div>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div>
    </div>
</div>
@stop