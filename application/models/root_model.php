<?php

    class Root_model extends CI_Model {
    	private $con;
		private $hash;
    	function __contruct() {
    		parent::__construct();
			
    	}
		
		//判断管理员登陆
		function get($name, $pass) {
			$this->hash = 'monitor';
			
			$pass = md5($pass.$this->hash);
			
			$sql = "select * from admin where name='$name' and pass='$pass'";
			$res = $this->db->query($sql);
			return $res->result();
		}
		//获取教师信息
		function getTeacherInfo($page, $limit) {
			$sql = "select * from teacher limit $page, $limit";
			$res = $this->db->query($sql);
			return $res->result();
		}
		//获取教师总人数
		function getTeacherNum () {
			$sql = 'select * from teacher';
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//插入教师数据
		function insertTeacherInfo($info) {
			//$sql = "insert into teacher('name', 'sex', 'department', 'start_work_time', 'end_work_time') values('{$info["teacherName"]}', '{$info["sex"]}', '{$info["department"]}','{$info["start_work_time"]}', '{$info["end_work_time"]}')";
			//error_log($sql, 3, "d:/log/error_log");
			$data = array(
				'teacher_id' => $info['teacherId'],
				'name' => $info['teacherName'],
				'sex' => $info['sex'],
				'department' => $info['department'],
				'start_work_time' => $info['start_work_time'],
				'end_work_time' => $info['end_work_time']
			);
			$res = $this->db->insert('teacher', $data);
			return $res;
		}
		
		//删除教师数据
		function delTeacher($table, $where, $del) {
			
			$this->db->where_in($where, $del);
			$res = $this->db->delete($table);
			return $res;
		}
    }
