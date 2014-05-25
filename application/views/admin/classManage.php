<div>
	<div>
		<p><input type='button' value='添加教室' id='addTeacher' /> &nbsp;&nbsp;<a href="<?php echo base_url('index.php').'/admin/root/main'; ?>">返回管理首页</a></p>
		<p><input type='checkbox' id='checkAll' />全选 &nbsp;&nbsp;&nbsp; <input type="button" value="修改" id='change' />&nbsp;&nbsp;<input type='button' value="删除" id="del" /></p>
		<p><a href="<?php echo base_url('index.php').'/admin/root/classManage/'.($page-1).'/'.$limit; ?>">&lt;before</a>&nbsp;&nbsp;当前第<?php echo $page; ?>页&nbsp;&nbsp;
			<a href="<?php echo base_url('index.php').'/admin/root/classManage/'.($page+1).'/'.$limit; ?>">next&gt;</a></p>
			<form action="<?php echo base_url('index.php').'/admin/root/search'; ?>"  method='post' >
		<p>按教室编号查询:<input type="text" value="" id="search_con" name="search" /> <input type="submit" value="查找" id="search" /></p>
		<input type='hidden' value="classManage" name="hidden" />
		</form>
	</div>
	<div>
		<table>
			<tr>
				<td>是否选中</td>
				<td>教室编号</td>
				<td>教室地址</td>
				<td>教室容量</td>
				<td>监考开始时间</td>
				<td>监考结束时间</td>
			</tr>
			<?php 
				foreach($classInfo as $v) {
					echo "<tr><td><input type='checkbox' name='checkout' class='one' value='$v->id' /></td>
						<td>{$v->id}</td>
						<td>{$v->name}</td>
						<td>{$v->num}</td>
						<td>{$v->work_start}</td>
						<td>{$v->work_end}</td>
					</tr>";
				}
			?>
		</table>
	</div>
</div>
<div class="bg"></div>
<div id="addDemo" style="display: none">
	<p>教室地址:<input type="text" value="" id="className" /></p>
	<p>容量:<input type="text" value="" id="classNum"></p>
	<p>监考开始时间:<input type="text" value="" id="start_work_time" /></p>
	<p>监考结束时间:<input type="text" value="" id="end_work_time" /></p>
	<p><input type="button" value="提交" id="sub" />&nbsp;&nbsp;&nbsp;<input type="button" value="取消" id="cancel" /></p>
</div>
<div id='alterDemo' style="display:none">
    <h4>统一修改项</h4>
    
    <p>教室容量:<input type='text' value='' id='alterDep' /></p>
    <p>监考开始时间:<input type='text' value='' id='alterStartTime' /></p>
    <p>监考结束时间:<input type='text' value='' id='alterEndTime' /></p>
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
        
        var classNum = $('#alterDep').val();
        var start_t = $('alterStartTime').val();
        var end_t = $('alterEndTime').val();

        var data = {};
        data['id'] = alter_id;
       
        if (classNum) {
            data['num'] = classNum;
        }
        if (start_t) {
            data['work_start'] = start_t;
        }
        if (end_t) {
            data['work_end'] = end_t;
        }

        $.ajax({
			dataType: 'json',
			type:'post',
			url:'<?php echo base_url('index.php')."/admin/root/alterClass"; ?>',
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
		
		var className = $('#className').val();
		var classNum = $('#classNum').val();
		var start_work_time = $('#start_work_time').val();
		var end_work_time = $('#end_work_time').val();
		
		
		$.ajax({
			dataType: 'json',
			type:'post',
			url:'<?php echo base_url('index.php')."/admin/root/addclass"; ?>',
			data:{'name':className, 'num':classNum, 'start_work_time':start_work_time, 'end_work_time':end_work_time},
			success: function(data){
				if (data.s == 'ok') {
					alert('添加教室成功!');
					$('.bg').fadeOut(800);
        			$('#addDemo').fadeOut(800);
        			location.reload();
					return;
				}else if (data.s == 'no') {
					alert('添加教室失败!');
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
				$.post('<?php echo base_url('index.php').'/admin/root/delClass'; ?>',
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


</style>
