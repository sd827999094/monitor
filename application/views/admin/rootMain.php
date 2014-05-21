<?php 
	if (isset($error) && $error == 'error') {
		echo '<font color="red">用户名或密码错误!</font>';
	}
?>
<div id="login_div">
	<form action="<?php echo base_url("index.php")."/admin/root/main"; ?>" method='post'>
	<p class="login_css">管理员登录</p>
	<p class="login_css">用户名:<input type="text" value="" id="user_name" name="user_name" /></p>
	<p class="login_css">密码:<input type="text" value="" id="user_pass" name="user_pass" /></p>
	<p class="login_css"><input type="submit" value="登录" id='login' />&nbsp;&nbsp;<input type="button" value="重置" id="reset" /></p>
	</form>
</div>
<script type="text/javascript">
	$('#login').click(function(){
	var user_name = $('#user_name').val();
	var user_pass = $('#user_pass').val();
	if (!user_name || !user_pass) {
		alert('用户名或密码为空!');
		return;
	}
	
});

</script>