<?php use App\Library\AdminFunction\FunctionLib; ?>
<div class="panel panel-primary">
    <div class="panel-heading paddingTop1 paddingBottom1">
        <h4>
            @if(isset($data->id) && $data->id > 0)
                <i class="fa fa-edit icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Sửa')}} </span>
            @else
                <i class="fa fa-plus-square icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Thêm mới')}}</span>
            @endif
        </h4>
    </div>
    <div class="panel-body">
        <form id="formAdd" method="post">
            <input type="hidden" name="id_hiden" @if(isset($data->id))value="{{$data->id}}"@endif class="form-control" id="id_hiden">
            <div class="form-group">
                <label for="name">{{viewLanguage('Tên')}}<span class="red"> (*) </span></label>
                <input name="name" title="{{viewLanguage('Tên tình trạng')}}" class="form-control input-required" id="name" type="text" @if(isset($data->name))value="{{$data->name}}"@endif>
            </div>
            <div class="form-group">
                <label for="data">{{viewLanguage('Mô tả')}}<span class="red"> (*) </span></label>
                <textarea name="data" id="data" title="{{viewLanguage('Mô tả')}}" cols="30" rows="2" class="form-control input-required">@if(isset($data->data)){{$data->data}}@endif</textarea>
            </div>
            <div class="form-group">
                <label for="status">{{viewLanguage('Trạng thái')}}</label>
                <select class="form-control input-sm" name="status" id="status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/document_type/post/' + '{{$data->id}}')">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{viewLanguage('Lưu')}}
            </a>
            <a class="btn btn-default" id="cancel" onclick="VM.resetItem('#id_hiden', '0')">
                <i class="fa fa-undo" aria-hidden="true"></i> {{viewLanguage('Làm lại')}}
            </a>
        </form>
    </div>
</div>