<div>
	<p><a href="<?php echo base_url('index.php') ?>/admin/adminServer/main">返回您的管理界面</a></p>
	<p><input type="button" value="修改密码" id="changePass" /></p>
	<div style="display:none" id="passDiv">
		<form action="<?php echo base_url('index.php').'/admin/adminServer/changePass'; ?>" method='post'>
		<p>请输入旧密码: <input type="password" id="oldPass" value="" name="oldPass" /></p>
		<p>请输入新密码: <input type="password" id="newPass" value="" name="newPass" /></p>
		<p>请再次输入新密码: <input type="password" id="newPassAgain" value="" name="newPassAgain" /></p>
		<p><input type="button" value="确认修改" id="confirm" />&nbsp;&nbsp;<input type="button" value="取消" id="cancel" /></p>
		</form>
	</div>
	<p>如果您哪天有事不在空闲状态，请写入忙碌日期:
<input type='text' value='' id='busyDate' onclick="WdatePicker()" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss',minDate:'{%y-1}-%M-%d 0:00:00',maxDate:'{%y+1}-%M-%d 23:59:59'})"  />
		<input type='button' value="加入忙碌状态" id="changeStatus" /></p>
	
	<p><label>当前状态:<font color="green"><?php echo $status; ?></font></label></p>
</div>
<script type="text/javascript">
	$('#changePass').click(function(){
		$('#passDiv').toggle('slow');
	});
	$('#cancel').click(function(){
		$('#passDiv').toggle('slow');
	});
	$('#changeStatus').click(function(){
		var busyDate = $('#busyDate').val();
		$.ajax({
			url:'<?php echo base_url('index.php'); ?>/admin/adminServer/changeStatus',
			dataType:'json',
			type:'post',
			data:{'busyDate':busyDate},
			success:function(data){
				if (data.s == 'ok') {
					alert('修改成功!');
					location.reload();
					return;
				}
			}
		});
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
