<div>
	<p><h3>这是监考需求提交页面</h3></p>
	<div>
		<p>需要考试的科目代号:<input type="text" value="" id="classNum" /></p>
		<p>需要考试的科目名称:<input type="text" value="" id="className" /></p>
		<p>您的课堂人数: <input type="text" value="" id="studentNum" /></p>
		<p>您希望考试的时间: <input type="text" value="" id="time_start" onclick="WdatePicker()" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss',minDate:'{%y-1}-%M-%d 0:00:00',maxDate:'{%y+1}-%M-%d 23:59:59'})" />------
			<input type="text" value="" id="time_end" onclick="WdatePicker()" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss',minDate:'{%y-1}-%M-%d 0:00:00',maxDate:'{%y+1}-%M-%d 23:59:59'})" /></p>
		<p>考试时长: <input type="text" value="" id="hour_length" /></p>
		<p><input type="button" value="提交" id="sub" /> <a href='<?php echo base_url('index.php').'/admin/adminServer/main'; ?>'>&lt;返回管理主页</a></p>
	</div>
</div>

<script type="text/javascript">
	$('#sub').click(function(){
		var classNum = $('#classNum').val();
		var className = $('#className').val();
		var studentNum = $('#studentNum').val();
		var start_t = $('#time_start').val();
		var end_t = $('#time_end').val();
		var hour_length = $('#hour_length').val();
		
		if (!classNum || !className || !studentNum || !start_t || !end_t || !hour_length) {
			alert('所有信息不能为空!');
			return;
		}
		
		
		$.ajax({
			url:"<?php echo base_url('index.php').'/admin/adminServer/insertReq/'.$id; ?>",
			dataType:'json',
			type:'post',
			data:{'classNum':classNum, 'className':className,'studentNum':studentNum, 'start_t':start_t, 'end_t':end_t, 'hour_length':hour_length},
			success:function(data) {
				if(data.s == 'ok') {
					alert('提交成功,请等待审核!');
					location.reload();
					return;
				}else if (data.s == 'timeOut'){
					alert('时间填写不正确!');
					return;
				} else {
					alert('提交失败!');
					return;
				}
			},
		})
	});
</script>