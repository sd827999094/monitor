<?php

    class Root_model extends CI_Model {
    	private $con;
		private $hash;
    	function __contruct() {
    		parent::__construct();
			
    	}
		
		//判断管理员登陆
		function get($name, $pass, $table) {
			$this->hash = 'monitor';
			error_log($pass, 3, 'd:/log/error.log');
			$pass = md5($pass.$this->hash);
			if ($table == 'admin') {
				$sql = "select * from ".$table." where name='$name' and pass='$pass'";
			}else if ($table == 'teacher') {
				$name = (int)$name;
				$sql = "select * from ".$table." where teacher_id=$name and teacher_pass='$pass'";
				error_log($sql, 3, 'd:/log/error.log');
			}
			$res = $this->db->query($sql);
			return $res->result();
		}
		//获取教师或教室信息
		function getInfo($page, $limit, $table) {
			$sql = "select * from ".$table." limit $page, $limit";
			$res = $this->db->query($sql);
			return $res->result();
		}
		//获取教师或教室总人数
		function getNum ($table) {
			$sql = 'select * from '.$table;
			$query = $this->db->query($sql);
			return $query->num_rows();
		}
		
		//插入数据
		function insertInfo($info, $table) {
			//$sql = "insert into teacher('name', 'sex', 'department', 'start_work_time', 'end_work_time') values('{$info["teacherName"]}', '{$info["sex"]}', '{$info["department"]}','{$info["start_work_time"]}', '{$info["end_work_time"]}')";
			//error_log($sql, 3, "d:/log/error_log");
			
			$res = $this->db->insert($table, $info);
			return $res;
		}
		
		//通用查询
		function query_info($sql) {
			$res = $this->db->query($sql);
			if ($res->num_rows() > 0) {
				return $res->result();
			}else {
				return null;
			}
		}
		
		//删除教师数据
		function del($table, $where, $del) {
			
			$this->db->where_in($where, $del);
			$res = $this->db->delete($table);
			return $res;
		}
		//统一更新数据
		function alterData($data, $where, $table) {
			if ($table == 'teacher') {
				if ($where) {
					$this->db->where_in('teacher_id', $where);
				}
				$res = $this->db->update('teacher', $data);
			}else if($table == 'room') {
				if ($where) {
					$this->db->where_in('id', $where);
				}
				$res = $this->db->update('room', $data);
			}
			return $res;
		}
		
		//查找数据
		function search($search, $table) {
			if ($table == 'teacher') {
				$sql = 'select * from '.$table. ' where name='.'"'.$search.'";';
			} else if ($table == 'room') {
				$sql = 'select * from '.$table. ' where id='. $search;
			}
			$res = $this->db->query($sql);
			return $res->result();
		}
		
		function update($data, $where, $table){
			$this->db->where('teacher_id', $where);
			if (is_array($data)) {
				$this->db->update($table, $data);
			}
		}
		
		function searchById($id, $table) {
			$sql = "select * from $table where teacher_id=$id";
			$res = $this->db->query($sql);
			return $res->result();
			
		}
    }
