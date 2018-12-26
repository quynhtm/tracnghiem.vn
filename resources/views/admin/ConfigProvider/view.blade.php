<?php use App\Library\AdminFunction\CGlobal; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('[id*="check_"]').prop('checked', false);

        $('button#update_all').click(function(){
            var valid = false;
            $('[id*="check_item"]').each(function(){if ($(this).is(':checked')) valid = true;});
            $('.ajax-control >select').each(function(){if (parseInt($(this).val()) <= 0) $(this).prop('disabled', true);});
            if (!valid) {
                alert('Bạn cần lựa chọn nhà mạng cần sửa đổi cấu hình nhà cung cấp SMS');
                return false;
            }
        });

        $('#check_all').change(function(){
            $('[id*="check_item"]').prop('checked', $(this).is(':checked')).change();
        });

        $('[id*="check_item"]').change(function(){
            var parent = $(this).parents('tr.row_'+$(this).attr('item'));
            if ($(this).is(':checked')) {
                parent.find('.update-item').removeClass('hidden');
                parent.find('.cancel-item').removeClass('hidden');
                parent.find('.edit-item').addClass('hidden');
                parent.find('.ajax-control >label').addClass('hidden');
                parent.find('.ajax-control >select').removeClass('hidden').prop('disabled', false);
            } else {
                parent.find('.update-item').addClass('hidden');
                parent.find('.cancel-item').addClass('hidden');
                parent.find('.edit-item').removeClass('hidden');
                parent.find('.ajax-control >select').addClass('hidden').prop('disabled', true);
                parent.find('.ajax-control >label').removeClass('hidden');
            }
        });

        $('.edit-item').click(function(){
            var parent = $(this).parent();
            parent.find('.update-item').removeClass('hidden');
            parent.find('.cancel-item').removeClass('hidden');
            parent.parent().find('.ajax-control >label').addClass('hidden');
            parent.parent().find('.ajax-control >select').removeClass('hidden').prop('disabled', false);
            parent.parent().find('[id*="check_item"]').prop('checked', true);
            $(this).addClass('hidden');
            return false;
        });

        $('.cancel-item').click(function(){
            var parent = $(this).parent();
            parent.find('.update-item').addClass('hidden');
            parent.find('.edit-item').removeClass('hidden');
            parent.parent().find('.ajax-control >select').addClass('hidden').prop('disabled', true);
            parent.parent().find('.ajax-control >label').removeClass('hidden');
            parent.parent().find('[id*="check_item"]').prop('checked', false);
            $(this).addClass('hidden');
            return false;
        });

        $('.update-item').click(function(){
            var itme = $(this);
            var parent = itme.parent();
            var post_data = {'_token': jQuery('[name="_token"]').val(), '_ajax' : 1, 'provider' : {}, 'executes' : {}};

            parent.parent().find('.ajax-control').each(function(){
                var select  = $(this).find('>select');
                post_data['provider'][select.attr('data-code')+'_'+select.attr('data-key')] = select.val();
                post_data['executes'][select.attr('data-code')] = parent.parent().find('[id*="check_item"]').val();
            });

            jQuery.ajax({
                type: "post",
                url: $(this).data('link'),
                data: post_data,
                dataType: 'json',
                success: function (result) {
                    parent.find('.cancel-item').addClass('hidden');
                    parent.find('.edit-item').removeClass('hidden');
                    itme.addClass('hidden');

                    parent.parent().find('.ajax-control').each(function(){
                        parent.parent().find('[id*="check_item"]').prop('checked', false);
                        var select  = $(this).find('>select');
                        var label   = $(this).find('>label');
                        select.addClass('hidden').prop('disabled', true);
                        label.text(select.find(':selected').text()).removeClass('hidden');
                        $.each(result, function (key, items) {
                            if (key == select.attr('data-code'))
                                select.attr('data-key', items.id);
                        })
                    });

                    alert('Bạn đã cập nhật thành công cấu hình nhà cung cấp SMS');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('div#payment-lender .lds-css.ng-scope').hide();
                    alert('Error: ' + xhr.status + ' - ' + thrownError);
                }
            });

            return false;
        });
    });
</script>
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">Thiết lập nhà cung cấp SMS</li>
        </ul>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                @if(isset($error) && !empty($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $_mess)
                            <p>{{ $_mess }}</p>
                        @endforeach
                    </div>
                @endif
                @if(isset($success) && !empty($success))
                    <div class="alert alert-success" role="alert">
                        @foreach($success as $_mess)
                            <p>{{ $_mess }}</p>
                        @endforeach
                    </div>
                @endif

                {{Form::open(array('method' => 'POST','role'=>'form','files' => true, 'url' => URL::route('admin.providerStore')))}}
                    @if($is_root || $permission_full || $permission_create)
                    <div class="panel panel-info">
                        <div class="panel-footer text-right">
                            <button class="btn btn-success btn-sm" type="submit" id="update_all">
                                <i class="ace-icon fa fa-save"></i>
                                {{viewLanguage('Cập nhật')}}
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="paging-ajax">
                        <div class="lds-css ng-scope"><div class="lds-eclipse"><div></div></div></div>
                        <div class="load-content">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thin-border-bottom">
                                    <tr class="">
                                        <th>
                                            <div class="checkbox">
                                                <label style="padding-left: 25px;">
                                                    @if($is_root || $permission_full || $permission_update)
                                                        <input type="checkbox" id="check_all" style="width: auto;" name="update[]" value="all">
                                                    @endif
                                                    #
                                                </label>
                                            </div>
                                        </th>
                                        @foreach($arrCase as $key => $val)
                                        <th class="text-center">{{viewLanguage($val)}}</th>
                                        @endforeach
                                        @if($is_root || $permission_full || $permission_update)
                                        <th class="text-center">{{viewLanguage('Thao tác')}}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($arrNetwork as $n_key => $n_val)
                                        <tr class="row_{{$n_key}}">
                                            <td>
                                                <div class="checkbox" style="margin: 0 0;">
                                                    <label style="padding-left: 25px;">
                                                        @if($is_root || $permission_full || $permission_update)
                                                        <input type="checkbox" id="check_item_{{$n_key}}" style="width: auto;" item="{{$n_key}}" name="executes[{{$n_key}}]" value="{{$n_key}}">
                                                        @endif
                                                        {{ viewLanguage($n_val) }}
                                                    </label>
                                                </div>
                                            </td>
                                            @foreach($arrCase as $c_key => $c_val)
                                            <td class="text-center ajax-control">
                                                <label>{{isset($data[$n_key][$c_key]) ? $arrProvider[$data[$n_key][$c_key]['value']] : 'Lựa chọn'}}</label>
                                                <select disabled="disabled" name="provider[{{$n_key}}_{{$c_key}}_{{isset($data[$n_key][$c_key]) ? $data[$n_key][$c_key]['id'] : 0}}]" data-code="{{$n_key}}_{{$c_key}}" data-key="{{isset($data[$n_key][$c_key]) ? $data[$n_key][$c_key]['id'] : 0}}" class="input-sm form-control hidden provider">
                                                    <option value="0">{{'Lựa chọn'}}</option>
                                                    @foreach($arrProvider as $p_key => $p_val)
                                                    <option value="{{$p_key}}" @if(isset($data[$n_key][$c_key]) && $data[$n_key][$c_key]['value'] == $p_key)selected="selected"@endif>{{viewLanguage($p_val)}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            @endforeach
                                            @if($is_root || $permission_full || $permission_update)
                                            <td class="text-center middle">
                                                <a class="edit-item" href="#" title="{{viewLanguage('Sửa đổi')}}"><i class="fa fa-edit fa-2x"></i></a>
                                                <a class="update-item hidden" href="#" data-link="{{route('admin.providerAjax')}}" title="{{viewLanguage('Lưu lại')}}"><i class="fa fa-save fa-2x"></i></a>
                                                <a style="margin-left: 10px;" class="cancel-item hidden" href="#" title="{{viewLanguage('Không lưu')}}"><i class="fa fa-refresh fa-2x"></i></a>
                                                <span class="img_loading" id="img_loading_{{!empty($items->id) ? $items->id : 0}}"></span>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop