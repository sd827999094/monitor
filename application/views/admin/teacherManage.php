<div>
	<div>
		<p><input type='button' value='添加教师' id='addTeacher' /> &nbsp;&nbsp;<a href="<?php echo base_url('index.php').'/admin/root/main'; ?>">返回管理首页</a></p>
		<p><input type='checkbox' id='checkAll' />全选 &nbsp;&nbsp;&nbsp; <input type="button" value="修改" id='change' />&nbsp;&nbsp;<input type='button' value="删除" id="del" /></p>
		<p><a href="<?php echo base_url('index.php').'/admin/root/teacherManage/'.($page-1).'/'.$limit; ?>">&lt;before</a>&nbsp;&nbsp;当前第<?php echo $page; ?>页&nbsp;&nbsp;
			<a href="<?php echo base_url('index.php').'/admin/root/teacherManage/'.($page+1).'/'.$limit; ?>">next&gt;</a></p>
			<form action="<?php echo base_url('index.php').'/admin/root/search'; ?>"  method='post' >
		<p>按教师名字查询:<input type="text" value="" id="search_con" name="search" /> <input type="submit" value="查找" id="search" /></p>
		<input type='hidden' value="teacherManage" name="hidden" />
		</form>
	</div>
	<div>
		<table class="gridtable">
			<tr>
				<th>是否选中</th>
				<th>教师编号</th>
				<th>教师名字</th>
				<th>性别</th>
				<th>系别</th>
				<th>忙碌时间</th>
				<th>监考次数</th>
			</tr>
			<?php 
				foreach($teacherInfo as $v) {
					echo "<tr><td><input type='checkbox' name='checkout' class='one' value='$v->teacher_id' /></td>
						<td>{$v->teacher_id}</td>
						<td>{$v->name}</td>
						<td>{$v->sex}</td>
						<td>{$v->department}</td>
                        <td>{$v->busyDate}</td>
                        <td>{$v->monitor_times}</td>
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
	<p><input type="button" value="提交" id="sub" />&nbsp;&nbsp;&nbsp;<input type="button" value="取消" id="cancel" /></p>
</div>
<div id='alterDemo' style="display:none">
    <h4>统一修改项</h4>
    <p>性别:<select name='selectSex' id='alterSex'>
    <option value='1'>男</option>
    <option value='2'>女</option>
</select></p>
    <p>系别:<input type='text' value='' id='alterDep' /></p>
    <p><input type='button' value='修改' id='alter_sub' /><input type='button' value='取消' id='cancel_sub' /></p>
</div>
<script type="text/javascript">

	
    $('#alter_sub').click(function(){
    	var alter_id = '';
        var alter_teacher = '';
        var alter_post = {};
        $('.one').each(function(data){
            if ($(this).prop('checked')) {
				alter_id += $(this).val() +',';
            }
        });
        var sex = $('#alterSex option:selected').val();
        var depart = $('#alterDep').val();

        var data = {};
        data['teacher_id'] = alter_id;
        if (sex) {
            data['sex'] = sex;
        }
        if (depart) {
            data['department'] = depart;
        }

        $.ajax({
			dataType: 'json',
			type:'post',
			url:'<?php echo base_url('index.php')."/admin/root/alterteacher"; ?>',
			//data:{'sex':sex, 'depart':depart,'start_t':start_t, 'end_t':end_t},
			data:data,
			success: function(data){
                if (data.s == 'ok') {
                    alert('修改成功!');
                    location.reload();
                    return;
                }else {
                    alert('修改失败!');
                    location.reload();
                    return;
                }
            }
        });

    });
	$('#addTeacher').click(function(){
		 $('.bg').slideToggle('slow');

		$('#addDemo').slideToggle('slow');
	});
	$('#cancel').click(function(){
		$('.bg').fadeOut(800);
        $('#addDemo').fadeOut(800);
	});
    $('#cancel_sub').click(function(){
        $('.bg').fadeOut(800);
        $('#alterDemo').fadeOut(800);
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
		
		
		$.ajax({
			dataType: 'json',
			type:'post',
			url:'<?php echo base_url('index.php')."/admin/root/addteacher"; ?>',
			data:{'teacherId':teacherId,'teacherName':teacherName, 'sex':sex, 'department':department},
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
	//修改教师信息
    $('#change').bind('click', function(){
        var alter_id = '';
        var alter_teacher = '';
        var alter_post = {};
        $('.one').each(function(data){
            if ($(this).prop('checked')) {
				alter_id += $(this).val() +',';
            }
        });
        if (alter_id) {
            $('.bg').slideToggle('slow');
            $('#alterDemo').slideToggle('slow');
        }else {
            alert('请选择要统一修改项!');
        }
    });
</script>
<style type="text/css">
	#addDemo, #alterDemo{
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
