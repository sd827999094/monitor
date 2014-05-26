<div>
	<p><input type="button" value="修改密码" id="changePass" /></p>
	<div style="display:none" id="passDiv">
		<form action="<?php echo base_url('index.php').'/admin/adminServer/changePass'; ?>" method='post'>
		<p>请输入旧密码: <input type="password" id="oldPass" value="" /></p>
		<p>请输入新密码: <input type="password" id="newPass" value="" /></p>
		<p>请再次输入新密码: <input type="password" id="newPassAgain" value="" /></p>
		<p><input type="submit" value="确认修改" id="confirm" />&nbsp;&nbsp;<input type="button" value="取消" id="cancel" /></p>
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
</script>