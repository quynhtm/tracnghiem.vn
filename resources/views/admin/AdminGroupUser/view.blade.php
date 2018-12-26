@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">Danh sách nhóm quyền</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="group_user_name"><i>Tên nhóm</i></label>
                            <input type="text" class="form-control input-sm" id="group_user_name" name="group_user_name" placeholder="Nhóm người dùng" @if(isset($dataSearch['group_user_name']) && $dataSearch['group_user_name'] != '')value="{{$dataSearch['group_user_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="group_user_status"><i>Trạng thái</i></label>
                            <select name="group_user_status" id="group_user_status" class="form-control input-sm">
                                <option value="-1">--- Chọn trạng thái ---</option>
                                @foreach($arrStatus as $k => $v)
                                    <option value="{{$k}}" @if($dataSearch['group_user_status'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.groupUser_edit')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> nhóm quyền @endif </div>
                    <br>
                    <table class="table-hover table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="3%" class="text-center">STT</th>
                            <th width="12%" class="">Tên nhóm</th>
                            <th width="70%" >Danh sách quyền</th>
                            <th width="3%" class="text-center">Order</th>
                            <th width="5%" class="text-center">ShowPerm</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="7%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr data-container="body" data-toggle="popover" data-placement="top" data-title="{{viewLanguage('Thông tin log thao tác')}}" data-html-content="#popover{{$item['group_user_id']}}">
                                <td class="text-center middle">{{ $start + $key+1 }}</td>
                                <td class="middle">
                                    {{ $item['group_user_name'] }}
                                    @if ($item['group_user_id'])
                                        <div class="hidden popover-html" id="popover{{$item['group_user_id']}}">
                                            <div class="title">
                                                {{viewLanguage("Mã quyền")}}: {{$item['group_user_id']}}
                                            </div>
                                            <div class="content">
                                                <table>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Người tạo")}}:</strong></td>
                                                        <td>{{$item['user_name_creater']}} ({{$item['created_at']}})</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Người cập nhật")}}:</strong></td>
                                                        <td>{{$item['user_name_update']}} ({{$item['updated_at']}})</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($item['permissions']))
                                        @foreach($item['permissions'] as $permission)
                                            {{$permission->permission_name}},
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center middle">
                                    {{ $item['group_user_order'] }}
                                </td>
                                <td class="text-center text-middle">
                                    @if($item['group_user_view'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item['group_user_status'] == 1)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center middle">
                                    @if($is_root || $permission_edit || $permission_view)
                                        <a href="{{URL::route('admin.groupUser_edit',array('id' => $item['group_user_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root)
                                        <a href="javascript:void(0)" class="sys_delete_user" data-content="Xóa tài khoản" data-placement="bottom" data-trigger="hover" data-rel="popover" data-url="groupUser/remove/" data-id="{{$item['group_user_id']}}">
                                            <i class="fa fa-trash fa-2x"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {!! $paging !!}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    $('[data-rel=popover]').popover({container: 'body'});
</script>
@stop