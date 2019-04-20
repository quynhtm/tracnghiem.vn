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
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> tài khoản  @endif </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="">
                                <th width="3%" class="text-center">STT</th>
                                <th width="15%">Câu hỏi</th>
                                <th width="5%" class="text-center">Câu TL 1</th>
                                <th width="5%" class="text-center">Câu TL 2</th>
                                <th width="5%" class="text-center">Câu TL 3</th>
                                <th width="5%" class="text-center">Câu TL 4</th>
                                <th width="5%" class="text-center">Câu TL 5</th>
                                <th width="5%" class="text-center">Câu TL 6</th>
                                <th width="5%" class="text-center">Ngày tạo</th>
                                <th width="5%" class="text-center">Trạng thái</th>
                                <th width="5%" class="text-center">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data) && sizeof($data) > 0)
                                @foreach($data as $k=>$item)
                                    <tr>
                                        <td class="text-center">{{$stt + $k + 1}}</td>
                                        <td>{{$item->question_name}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_MOT) text-green @endif">{{$item->answer_1}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_HAI) text-green @endif">{{$item->answer_2}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_BA) text-green @endif">{{$item->answer_3}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_BON) text-green @endif">{{$item->answer_4}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_NAM) text-green @endif">{{$item->answer_5}}</td>
                                        <td class="text-center @if($item->correct_answer == STATUS_INT_SAU) text-green @endif">{{$item->answer_6}}</td>
                                        <td class="text-center">{{date('d/m/Y', $item->created_at)}}</td>
                                        <td>{{($item->question_approved == STATUS_INT_MOT) ? 'Đã duyệt' : 'Chưa duyệt'}}</td>
                                        <td>
                                            @if($item->question_approved != STATUS_INT_MOT)
                                                Sửa | Xóa
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
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