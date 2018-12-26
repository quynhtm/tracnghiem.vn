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
                <label for="career_name">{{viewLanguage('Tên')}}<span class="red"> (*) </span></label>
                <input name="career_name" title="{{viewLanguage('Tên tình trạng')}}" class="form-control input-required" id="career_name" type="text" @if(isset($data->career_name))value="{{$data->career_name}}"@endif>
            </div>
            <div class="form-group">
                <label for="career_description">{{viewLanguage('Mô tả')}}<span class="red"> (*) </span></label>
                <textarea name="career_description" id="career_description" title="{{viewLanguage('Mô tả')}}" cols="30" rows="2" class="form-control input-required">@if(isset($data->career_description)){{$data->career_description}}@endif</textarea>
            </div>
            <div class="form-group">
                <label for="status">{{viewLanguage('Trạng thái')}}</label>
                <select class="form-control input-sm" name="status" id="status">
                    {!! $optionStatus !!}
                </select>
            </div>
            <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/lender_career/post/' + '{{$data->id}}')">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{viewLanguage('Lưu')}}
            </a>
            <a class="btn btn-default" id="cancel" onclick="window.location.reload();">
                <i class="fa fa-undo" aria-hidden="true"></i> {{viewLanguage('Làm lại')}}
            </a>
        </form>
    </div>
</div>