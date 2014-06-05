<div>
	<h4>这是最近的请求监考请求处理情况 &nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('index.php').'/admin/root/main'; ?>">返回管理主页</a></h4>
	<div>
		<table class="gridtable">
			<thead>
				<tr>
					<th>请求编号</th>
					<th>教师编号</th>
					<th>教师姓名</th>
					<th>教师请求科目</th>
					<th>请求时间</th>
					<th>请求人数</th>
					<th>考试时长</th>
					<th>请求状态</th>	
					<th>考试地点</th>
					<th>考试时间</th>
					<th>监考人</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody >
				<?php foreach ($res as $key => $value) {
					echo "<tr>
					<td class='selected'>{$value['id']}</td>
					<td>{$value['teacher_id']}</td>
						<td>{$value['name']}</td>
						<td>{$value['className']}</td>
						<td>{$value['req_t']}</td>
						<td>{$value['num']}</td>
						<td>{$value['hour_length']}</td>
						<td>{$value['status']}</td>
						<td>{$value['class_address']}</td>
						<td>{$value['test_t']}</td>
						<td>{$value['class_teacher_id']}</td>
						<td class='del_hr'><a href='javascript:void(0)' class='del_a' >删除</a>|<a href='javascript:void(0)' class='pass_a'>通过</a></td>
					</tr>";
				} ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$('.del_a').click(function(){
	    var str = $(this).parent().parent().children(".selected").text();
		$.ajax({
			url:"<?php echo base_url('index.php').'/admin/root/delReq/'; ?>",
			dataType:'json',
			type:'post',
			data:{'id':str},
			success:function(data){
				if (data.s == 'ok') {
					alert('删除成功!');
					location.reload();
					return;
				}else {
					alert('异常操作,请联系管理员!');
					return;
				}
			},
		});
	});
</script>
<style type="text/css" media="screen">
	table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>