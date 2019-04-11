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
            <div class="col-md-12 panel-content loadForm">
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
        </div>
    </div>
</div>
@stop