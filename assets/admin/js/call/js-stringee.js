$(document).ready(function() {
	PERM_STRINGEE.checkedInput();
	PERM_STRINGEE.sumitViewPerm();
});
PERM_STRINGEE = {
	checkedInput:function(){
		jQuery("input#checkAllCall").click(function(){
			var checkedStatus = this.checked;
			jQuery("input.checkItemCall").each(function(){
				this.checked = checkedStatus;
			});
		});
		jQuery("input#checkAllCallMe").click(function(){
			var checkedStatusMe = this.checked;
			jQuery("input.checkItemCallMe").each(function(){
				this.checked = checkedStatusMe;
			});
		});
	},
	sumitViewPerm:function(){
		$('.savePermisStringee').click(function(){
			jConfirm('Bạn muốn lưu phân quyền cuộc gọi [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
				if(r){
					$('form.permissionStringeeCall').submit();
					return true;
				}
			});
		});
	}
}