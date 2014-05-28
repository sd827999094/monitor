<div>
	<p><input type="button" value="修改密码" id="changePass" /></p>
	<div style="display:none" id="passDiv">
		<form action="<?php echo base_url('index.php').'/admin/adminServer/changePass'; ?>" method='post'>
		<p>请输入旧密码: <input type="password" id="oldPass" value="" name="oldPass" /></p>
		<p>请输入新密码: <input type="password" id="newPass" value="" name="newPass" /></p>
		<p>请再次输入新密码: <input type="password" id="newPassAgain" value="" name="newPassAgain" /></p>
		<p><input type="button" value="确认修改" id="confirm" />&nbsp;&nbsp;<input type="button" value="取消" id="cancel" /></p>
		</form>
	</div>
	<p>
		<select id="status">
			<option value="1">空闲</option>
			<option value="2">忙碌</option>
		</select>
		<input type='button' value="修改当前状态" id="changeStatus" /></p>
	
	<p><label>当前状态:<font color="green"><?php echo $status; ?></font></label></p>
</div>
<script type="text/javascript">
	$('#changePass').click(function(){
		$('#passDiv').toggle('slow');
	});
	$('#cancel').click(function(){
		$('#passDiv').toggle('slow');
	});
	$('#confirm').click(function(){
		
		var oldPass = $('#oldPass').val();
		var newPass = $('#newPass').val();
		var passAgain = $('#newPassAgain').val();
		if (!oldPass || !newPass || !passAgain) {
			alert('信息填写不完整!');
			return;
		}
		if(newPass !== passAgain) {
			alert('新密码输入不一致');
			return;
		}
		
		$.ajax({
			url:"<?php echo base_url('index.php')?>/admin/adminServer/changePass",
			dataType:'json',
			type:'post',
			data:{'oldPass':oldPass, 'newPass':newPass, 'passAgain':passAgain},
			success:function(data){
				if (data.s == 'ok') {
					alert('修改成功!');
					location.reload();
					return;
				}else if (data.s == 'dif') {
					alert('新密码不一致');
					return;
				} else if (data.s == 'no') {
					alert('旧密码不正确!');
					return;
				} else {
					alert(data.s);
					alert('请联系管理员!');
				}
			},
			
		});
	});
</script>