$(document).ready(function() {
	VM_AGENT_STRINGEE.chageAgentStatus();
	VM_AGENT_STRINGEE.createAgent();
	VM_AGENT_STRINGEE.deleteAgent();
	VM_AGENT_STRINGEE.deleteAgentGroup();
	VM_AGENT_STRINGEE.updateAgentToGroup();
	VM_AGENT_STRINGEE.editNameGroup();
	VM_AGENT_STRINGEE.updateNameGroup();
	VM_AGENT_STRINGEE.btnCreateNameGroup();
	VM_AGENT_STRINGEE.removeGroup();
	VM_AGENT_STRINGEE.btnAddAgentGroup()
});
VM_AGENT_STRINGEE = {
	chageAgentStatus: function() {
		$('.chageAgentStatus').on('click', function(e) {
			var _token = $('input[name="_token"]').val();
			var agentId = $(this).attr('agent-id');
			var userId = $(this).attr('user-id');
			var statusAgent = $(this).children('.statusAgent:checked').val();
			if (agentId != '' && userId != '') {
				$.ajax({
					type: "POST",
					url: WEB_ROOT + "/manager/stringee/ajaxChangeStatusAgent",
					data: {
						statusAgent: statusAgent,
						agentId: agentId,
						userId: userId,
						_token: _token
					},
					success: function(data) {
						console.log(data);
						location.reload();
					}
				})
			}
		})
	},
	createAgent: function() {
		$('#createAgent').click(function() {
			var agent_name = $('#agent_name').val();
			var stringee_user_id = $('#stringee_user_id').val();
			var sip_phone_extension = $('#sip_phone_extension').val();
			var groupId = $('#groupId').val();
			var _token = $('input[name="_token"]').val();
			var valid = !0;
			if (agent_name == '') {
				$('#agent_name').addClass('error');
				valid = !1
			} else {
				$('#agent_name').removeClass('error')
			}
			if (agent_name == '') {
				$('#agent_name').addClass('error');
				valid = !1
			} else {
				$('#agent_name').removeClass('error')
			}
			if (stringee_user_id == '') {
				$('#stringee_user_id').addClass('error');
				valid = !1
			} else {
				$('#stringee_user_id').removeClass('error')
			}
			if (valid) {
				$.ajax({
					type: "POST",
					url: WEB_ROOT + "/manager/stringee/ajaxCreateAgent",
					data: {
						agent_name: agent_name,
						stringee_user_id: stringee_user_id,
						sip_phone_extension: sip_phone_extension,
						groupId: groupId,
						_token: _token
					},
					success: function(data) {
						location.reload()
					}
				})
			}
		})
	},
	deleteAgent: function() {
		$('.deleteAgent').click(function() {
			var r = confirm("Bạn muốn xóa agent");
			if (r) {
				var _token = $('input[name="_token"]').val();
				var agentId = $(this).attr('agent-id');
				if (agentId != '') {
					if (agentId != '') {
						$.ajax({
							type: "POST",
							url: WEB_ROOT + "/manager/stringee/deleteAgent",
							data: {
								agentId: agentId,
								_token: _token
							},
							success: function(data) {
								location.reload()
							}
						})
					}
				}
			}
		})
	},
	deleteAgentGroup: function() {
		$('.deleteAgentGroup').click(function() {
			var r = confirm("Bạn muốn xóa agent trong group");
			if (r) {
				var _token = $('input[name="_token"]').val();
				var agentId = $(this).attr('agent-id');
				var groupId = $(this).attr('group-id');
				if (agentId != '' && groupId != '') {
					$.ajax({
						type: "POST",
						url: WEB_ROOT + "/manager/stringee/agentDeleteInGroup",
						data: {
							agentId: agentId,
							groupId: groupId,
							_token: _token
						},
						success: function(data) {
							location.reload()
						}
					})
				}
			}
		})
	},
	updateAgentToGroup: function() {
		$('.updateAgentToGroup').click(function() {
			var _token = $('input[name="_token"]').val();
			var agentId = $(this).attr('agent-id');
			var userId = $(this).attr('user-id');
			if (agentId != '' && groupId != '') {
				$('#sPopupUpdateAgentGroup #agentId').val(agentId);
				$('#sPopupUpdateAgentGroup #agentName').val(userId);
				$('#updateAgentGroup').click(function() {
					var groupId = $('#sPopupUpdateAgentGroup #agentGroup').val();
					$.ajax({
						type: "POST",
						url: WEB_ROOT + "/manager/stringee/ajaxAddAgentToGroup",
						data: {
							agentId: agentId,
							groupId: groupId,
							_token: _token
						},
						success: function(data) {
							console.log(data);
							location.reload()
						}
					})
				})
			}
		})
	},
	editNameGroup: function() {
		$('.editNameGroup').click(function() {
			var groupIdCurrent = $(this).attr('data-id');
			var groupNameCurrent = $(this).attr('data-name');
			$('#groupIdCurrent').val(groupIdCurrent);
			$('#groupNameCurrent').val(groupNameCurrent);
			$('#groupNameNew').val('')
		})
	},
	updateNameGroup: function() {
		$('#updateNameGroup').click(function() {
			var groupId = $('#groupIdCurrent').val();
			var groupName = $('#groupNameNew').val();
			var _token = $('input[name="_token"]').val();
			if (groupName == '') {
				$('#groupNameNew').addClass('error');
				return !1
			} else {
				$('#groupNameNew').removeClass('error')
			}
			if (groupId != '' && groupName != '') {
				$.ajax({
					type: "POST",
					url: WEB_ROOT + "/manager/stringee/updateNameGroup",
					data: {
						groupId: groupId,
						groupName: groupName,
						_token: _token
					},
					success: function(data) {
						console.log(data);
						location.reload()
					}
				})
			}
		})
	},
	btnCreateNameGroup: function() {
		$('#btnCreateNameGroup').click(function() {
			var groupName = $('#groupNameCreate').val();
			var _token = $('input[name="_token"]').val();
			if (groupName == '') {
				$('#groupNameCreate').addClass('error');
				return !1
			} else {
				$('#groupNameCreate').removeClass('error')
			}
			if (groupName != '') {
				$.ajax({
					type: "POST",
					url: WEB_ROOT + "/manager/stringee/createNameGroup",
					data: {
						groupName: groupName,
						_token: _token
					},
					success: function(data) {
						console.log(data);
						location.reload()
					}
				})
			}
		})
	},
	removeGroup: function() {
		$('.removeGroup').click(function() {
			var groupId = $(this).attr('data-id');
			var _token = $('input[name="_token"]').val();
			var r = confirm("Bạn muốn xóa group");
			if (r) {
				$.ajax({
					type: "POST",
					url: WEB_ROOT + "/manager/stringee/deleteGroup",
					data: {
						groupId: groupId,
						_token: _token
					},
					success: function(data) {
						console.log(data);
						location.reload()
					}
				})
			}
		})
	},
	btnAddAgentGroup: function() {
		$('#btnAddAgentGroup').click(function() {
			var agentId = $('#listAgentNotInGroup').val();
			var _token = $('input[name="_token"]').val();
			if (agentId != '') {
				var r = confirm("Bạn muốn gán agent này vào group?");
				if (r) {
					var groupId = $('#groupId').val();
					$.ajax({
						type: "POST",
						url: WEB_ROOT + "/manager/stringee/ajaxAddAgentToGroup",
						data: {
							agentId: agentId,
							groupId: groupId,
							_token: _token
						},
						success: function(data) {
							console.log(data);
							location.reload()
						}
					})
				}
			}
		})
	}
}