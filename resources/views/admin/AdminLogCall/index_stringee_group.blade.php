@extends('admin.AdminLayouts.index')
@section('content')
 <div class="main-content-inner">
     <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
         <ul class="breadcrumb">
             <li>
                 <i class="ace-icon fa fa-home home-icon"></i>
                 <a href="{{URL::route('admin.dashboard')}}">{{viewLanguage('Trang chủ')}}</a>
             </li>
             <li class="active">{{viewLanguage('Danh sách Stringee Group')}}</li>
         </ul>
     </div>
     <div class="page-content">
         <div class="row">
             <div class="col-xs-12">
                 <div class="panel panel-info">
                     <div class="panel-body">
                         <section id="listGroup">
                             <div class="row">
                                 @if(sizeof($recordGroup) > 0)
                                     @foreach($recordGroup as $k => $group)
                                         <div class="col-md-3 groupItemBox @if($groupId == $group->id) act @endif">
                                             <a href="{{ route('stringee.getGroupListID', $group->id) }}">
                                                 <div class="itemGroup" data-project="{{$group->project}}"
                                                      data-id="{{$group->id}}"
                                                      data-account="{{$group->account}}">
                                                     <div class="titleGroup">{{viewLanguage('Group')}} {{$k+1}}:</div>
                                                     <div class="nameGroup">{{$group->name}}</div>
                                                 </div>
                                             </a>
                                             <div title="Đổi tên group" class="editNameGroup"
                                                  data-id="{{$group->id}}"
                                                  data-name="{{$group->name}}" data-toggle="modal"
                                                  data-target="#sPopupUpdateNameGroup">
                                                 <i class="fa fa-edit"></i>
                                             </div>
                                             <div title="Xóa group" class="removeGroup" data-id="{{$group->id}}">
                                                 <i class="fa fa-times-circle-o"></i>
                                             </div>
                                         </div>
                                     @endforeach
                                 @endif
                                 <div class="col-md-3 createdGroupItemNew" data-toggle="modal"
                                      data-target="#sPopupCreateNameGroup">
                                     <div class="itemGroup">
                                         <div class="createGroup">
                                             <i class="fa fa-plus"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </section>
                     </div>
                     <div class="panel-footer">
                         <div class="wrap-panel">
                             <div class="inline pull-right">
                                 <span class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sPopupAddAgent"><i class="fa fa-plus"></i> {{viewLanguage('Thêm Agent')}}</span>
                                 @if(isset($arrNotInGroup) && sizeof($arrNotInGroup) > 0)
                                     <span class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sPopupAddAgentToGroup"><i class="fa fa-plus"></i> {{viewLanguage('Gán Agent đã tồn tại vào group')}}</span>
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="table-responsive">
                     <table class="table table-bordered table-hover listAgentStringee">
                         <thead>
                         <tr>
                             <th class="text-center" width="5%">{{viewLanguage('STT')}}</th>
                             <th width="30%">{{viewLanguage('Tên tài khoản')}}</th>
                             <th width="10%">{{viewLanguage('Trạng thái')}}</th>
                             <th>{{viewLanguage('Hành động')}}</th>
                         </tr>
                         </thead>
                         <tbody>
                         @if(sizeof($arrAgent) > 0)
                             @foreach($arrAgent as $k => $item)
                                 <tr>
                                     <td class="text-center">{{$k+1}}</td>
                                     <td>{{$item->stringee_user_id}}</td>
                                     <td>
                                         <label class="switch chageAgentStatus"
                                                user-id="{{$item->stringee_user_id}}"
                                                agent-id="{{$item->agent_id}}"
                                                group-id="{{$groupId}}">
                                             <input type="checkbox" class="statusAgent" value="1"
                                                    @if(isset($item->manual_status) && $item->manual_status == 'AVAILABLE') checked @endif>
                                             <span class="slider round"></span>
                                         </label>
                                     </td>
                                     <td>
                                         <a class="updateAgentToGroup" href="javascript:void(0)"
                                            data-toggle="modal" data-target="#sPopupUpdateAgentGroup"
                                            user-id="{{$item->stringee_user_id}}"
                                            agent-id="{{$item->agent_id}}" group-id="{{$groupId}}">Gán
                                             Group</a> /
                                         <a class="deleteAgentGroup" href="javascript:void(0)"
                                            agent-id="{{$item->agent_id}}" group-id="{{$groupId}}">Xóa
                                             agent
                                             trong group</a> /
                                         <a class="deleteAgent" href="javascript:void(0)"
                                            agent-id="{{$item->agent_id}}">Xóa</a>
                                     </td>
                                 </tr>
                             @endforeach
                         @endif
                         </tbody>
                     </table>
                     <input type="hidden" value="{{$groupId}}" id="groupId">
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade sPopup" id="sPopupAddAgent" tabindex="-1" role="dialog" aria-hidden="false"
      data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 THÊM AGENT STRINGEE
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class="listBoxAddAgent">
                     <div class="row">
                         <div class="col-md-5 mgt10">
                             <label>Tên Agent <span>*</span></label>
                             <input type="text" name="agent_name" class="form-control" id="agent_name">
                         </div>
                         <div class="col-md-5 mgt10">
                             <label>Stringee user id(Địa chỉ mail user) <span>*</span></label>
                             <input type="text" name="stringee_user_id" class="form-control"
                                    id="stringee_user_id">
                         </div>
                         <div class="col-md-5 mgt10">
                             <label>SIP phone extension)(VD: agent_11)</label>
                             <input type="text" name="sip_phone_extension" class="form-control"
                                    id="sip_phone_extension">
                         </div>
                         <div class="col-md-5 mgt10">
                             <input type="button" class="btn btn-primary btn-sm mgt22" id="createAgent"
                                    value="Tạo Agent"/>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade sPopup" id="sPopupUpdateAgentGroup" tabindex="-1" role="dialog"
      aria-hidden="false"
      data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 THÊM AGENT STRINGEE VÀO GROUP
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class="listBoxAddAgent">
                     <div class="row">
                         <div class="col-md-5 mgt10">
                             <label>Tên Agent</label>
                             <input type="text" name="agent_name" class="form-control" id="agentName"
                                    disabled>
                             <input type="hidden" name="agentId" class="form-control" id="agentId">
                         </div>
                         <div class="col-md-5 mgt10">
                             <label>Gán thêm agent vào group<span>*</span></label>
                             <select name="agent_group" id="agentGroup" class="form-control">
                                 @if(sizeof($recordGroup) > 0)
                                     @foreach($recordGroup as $group)
                                         <option value="{{$group->id}}">{{$group->name}}</option>
                                     @endforeach
                                 @endif
                             </select>
                         </div>
                         <div class="col-md-5 mgt10">
                             <input type="button" class="btn btn-primary btn-sm mgt22" id="updateAgentGroup"
                                    value="Thêm Agent vào group"/>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade sPopup" id="sPopupUpdateNameGroup" tabindex="-1" role="dialog"
      aria-hidden="false"
      data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 ĐỔI TÊN GROUP
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class="listBoxAddAgent">
                     <div class="row">
                         <div class="col-md-5 mgt10">
                             <label>Tên hiện tại</label>
                             <input type="text" name="group_name_curent" class="form-control"
                                    id="groupNameCurrent" value="" disabled>
                         </div>
                         <div class="col-md-5 mgt10">
                             <label>Tên hiện mới<span>*</span></label>
                             <input type="text" name="group_name_new" class="form-control"
                                    id="groupNameNew">
                             <input type="hidden" name="group_id" class="form-control"
                                    id="groupIdCurrent"
                                    value="">
                         </div>
                         <div class="col-md-5 mgt10">
                             <input type="button" class="btn btn-primary btn-sm mgt22" id="updateNameGroup"
                                    value="Đổi tên group"/>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade sPopup" id="sPopupCreateNameGroup" tabindex="-1" role="dialog"
      aria-hidden="false"
      data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 TẠO MỚI GROUP
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class="listBoxAddAgent">
                     <div class="row">
                         <div class="col-md-5 mgt10">
                             <div class="col-md-12">
                                 <label>Tên group<span>*</span></label>
                             </div>
                             <div class="col-md-12">
                                 <input type="text" name="group_name_create" class="form-control"
                                        id="groupNameCreate">
                             </div>
                         </div>
                         <div class="col-md-5 mgt10">
                             <div class="col-md-12">
                                 <label><span></span></label>
                             </div>
                             <div class="col-md-12">
                                 <input style="line-height: 32px;" type="button" class="btn btn-primary btn-sm mgt22" id="btnCreateNameGroup"
                                        value="Thêm mới group"/>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade sPopup" id="sPopupAddAgentToGroup" tabindex="-1" role="dialog"
      aria-hidden="false"
      data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 GÁN AGENT ĐÃ TỒN TẠI VÀO GROUP
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 <div class="listBoxAddAgent">
                     <div class="row">
                         <div class="col-md-5 mgt10">
                             <label>Danh sách Agent<span>*</span></label>
                             <select name="listAgentNotInGroup" id="listAgentNotInGroup"
                                     class="form-control">
                                 @foreach($arrNotInGroup as $key=>$item)
                                     <option value="{{$key}}">{{$item}}</option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="col-md-5 mgt10">
                             <input type="button" class="btn btn-primary btn-sm mgt22" id="btnAddAgentGroup"
                                    value="Gán vào group"/>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
@endsection
