<div>
	<div>
		<p><input type='button' value='添加教师' id='addTeacher' /></p>
		<p><input type='checkbox' id='checkAll' />全选 &nbsp;&nbsp;&nbsp; <input type="button" value="修改" id='change' />&nbsp;&nbsp;<input type='button' value="删除" id="del" /></p>
		<p><a href="<?php echo base_url('index.php').'/admin/root/teacherManage/'.($page-1).'/'.$limit; ?>">&lt;before</a>&nbsp;&nbsp;当前第<?php echo $page; ?>页&nbsp;&nbsp;
			<a href="<?php echo base_url('index.php').'/admin/root/teacherManage/'.($page+1).'/'.$limit; ?>">next&gt;</a></p>
		<p>按教师名字查询:<input type="text" value="" id="search" /> <input type="button" value="查找" id="search" /></p>
	</div>
	<div>
		<table>
			<tr>
				<td>是否选中</td>
				<td>教师编号</td>
				<td>教师名字</td>
				<td>性别</td>
				<td>系别</td>
				<td>监考开始时间</td>
				<td>监考结束时间</td>
			</tr>
			<?php 
				foreach($teacherInfo as $v) {
					echo "<tr><td><input type='checkbox' name='checkout' class='one' value='$v->teacher_id' /></td>
						<td>{$v->teacher_id}</td>
						<td>{$v->name}</td>
						<td>{$v->sex}</td>
						<td>{$v->department}</td>
						<td>{$v->start_work_time}</td>
						<td>{$v->end_work_time}</td>
					</tr>";
				}
			?>
		</table>
	</div>
</div>
<div class="bg"></div>
<div id="addDemo" style="display: none">
	<p>教师编号:<input type="text" value="" id="teacher_id" /></p>
	<p>教师姓名:<input type="text" value="" id="teacherName" /></p>
	<p>性别:<input type="text" value="" id="sex" /></p>
	<p>系别:<input type="text" value="" id="department"></p>
	<p>监考开始时间:<input type="text" value="" id="start_work_time" /></p>
	<p>监考结束时间:<input type="text" value="" id="end_work_time" /></p>
	<p><input type="button" value="提交" id="sub" />&nbsp;&nbsp;&nbsp;<input type="button" value="取消" id="cancel" /></p>
</div>
<script type="text/javascript">
	$('#addTeacher').click(function(){
		 $('.bg').slideToggle('slow');

		$('#addDemo').slideToggle('slow');
	});
	$('#cancel').click(function(){
		$('.bg').fadeOut(800);
        $('#addDemo').fadeOut(800);
	});
	$('.bg').click(function(){
		$('.bg').fadeOut(800);
        $('#addDemo').fadeOut(800);
	});
	$('#sub').click(function(){
		var teacherId = $('#teacher_id').val();
		var teacherName = $('#teacherName').val();
		var sex = $('#sex').val();
		var department = $('#department').val();
		var start_work_time = $('#start_work_time').val();
		var end_work_time = $('#end_work_time').val();
		
		
		$.ajax({
			dataType: 'json',
			type:'post',
			url:'<?php echo base_url('index.php')."/admin/root/addteacher"; ?>',
			data:{'teacherId':teacherId,'teacherName':teacherName, 'sex':sex, 'department':department, 'start_work_time':start_work_time, 'end_work_time':end_work_time},
			success: function(data){
				if (data.s == 'ok') {
					alert('添加教师成功!');
					$('.bg').fadeOut(800);
        			$('#addDemo').fadeOut(800);
        			location.reload();
					return;
				}else if (data.s == 'no') {
					alert('添加教师失败!');
					$('.bg').fadeOut(800);
       				$('#addDemo').fadeOut(800);
       				location.reload() ;
					return;
				}
			},
		});
	});
	
	//全选
    $('#checkAll').bind('click', function(){
        $('input[type=checkbox]') .prop('checked', $(this).prop('checked'));
    });

	//删除教师信息
	$('#del').click(function(){
		var del_id = '';
		var del_post = {};
		$('.one').each(function(data){
			if ($(this).prop('checked')) {
				del_id += $(this).val() +',';
			}
		});
		if (del_id) {
			var dum = confirm("确定删除选中的条目?");
			if (dum) {
				del_id = del_id.substr(0, del_id.lastIndexOf(','));
				del_post['del_id'] = del_id;
				$.post('<?php echo base_url('index.php').'/admin/root/delTeacher'; ?>',
					del_post,
					function(data){
						if (data.s == 'ok') {
							alert('删除成功!');
							location.reload() ;
						}else if (data.s == 'faild') {
							alert('删除失败!');
							location.reload();
						}
					},
					'json'
				);
			}
		}else {
			alert('请选择要删除的条目!');
		}
	});
</script>
<style type="text/css">
	#addDemo{
       display: none;
    width: 550px;
    height: 325px;
    background:#fff;
    position: fixed;
    z-index: 3;
    top: 50%;
    margin-top: -150px;
    left: 50%;
    margin-left: -250px;

}
 .bg {
    display:none;
    width: 100%;
    height: 100%;
    background:#000;
    position: fixed;
    z-index: 2;
    top:0;
    left:0;
    opacity:0.7;
}


</style>