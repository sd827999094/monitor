<?php 
	if (isset($error) && $error == 'error') {
		echo '<font color="red">用户名或密码错误!</font>';
	}
?>
<form action="<?php echo base_url('index.php').'/admin/adminServer/main'; ?>" method='post'>
<div id="login_div">
	<p class="login_css">教师登录</p>
	<p class="login_css">用户名:<input type="text" value="" id="teacher_id" name="teacher_id" /></p>
	<p class="login_css">密码:<input type="text" value="" id="teacher_pass" name="teacher_pass" /></p>
	<p class="login_css"><input type="submit" value="登录" id='login' />&nbsp;&nbsp;<input type="button" value="重置" id="reset" /></p>
</div>
</form>
<script type="text/javascript">
	$('#login').click(function(){
	var teacher_id = $('#teacher_id').val();
	var teacher_pass = $('#teacher_pass').val();
	if (!teacher_id || !teacher_pass) {
		alert('用户名或密码为空!');
		return;
	}
	
});

</script>