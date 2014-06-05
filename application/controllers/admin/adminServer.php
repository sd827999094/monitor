<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminServer extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 private $arr;
	 public function __construct() {
	 	
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('root_model');
	 }
	public function index()
	{
		$arr['title'] = '后台管理';
		$this->load->view("header/header", $arr);
		$this->load->view('admin/main');
		$this->load->view('footer/footer');
	}
	
	//主页面
	public function main() {
		$this->arr['title'] = '教师后台管理';
		$this->load->view('header/header', $this->arr);
		$sess = $this->session->all_userdata();
		if (!isset($sess['teacher_id']) || !isset($sess['teacher_pass'])) {
			$user = $this->input->post();
		
			$res = $this->root_model->get($user['teacher_id'], $user['teacher_pass'], 'teacher');
			if ($res) {
				$this->session->set_userdata($user);
				$this->arr['id'] = $user['teacher_id'];
				$sql = 'select * from request where teacher_id='.$user['teacher_id'];
				$res_list = $this->root_model->query_info($sql);
				
				$sql_name = 'select name from teacher where teacher_id='.$user['teacher_id'];
				$name = $this->root_model->query_info($sql_name);
				if ($name) {
					foreach($name as $val_n) {
						$name_str = $val_n->name;
					}
				}else {
					$name_str = '';
				}
				$data_list_str = array();
				if ($res_list) {
					
					foreach($res_list as $v) {
						$data_list = array();
						$data_list['id'] = $v->id;
						$data_list['teacher_id'] = $v->teacher_id;
						
						$data_list['name'] = $name_str;
						$data_list['className'] = $v->class_name;
						$data_list['req_t'] = date('Y-m-d H:i:s',$v->req_t);
						$data_list['num'] = $v->num;
						$data_list['status'] = $v->status;
						$data_list['hour_length'] = $v->hour_length;
						
						$sql = "select room.name from res, room where res.request_id=".$v->id ." and res.room_id = room.id";
						$data_join = $this->root_model->query_info($sql);
						if ($data_join) {
							 foreach($data_join as $val){
								$data_list['class_address'] = $val->name;
							 }
						 }else {
						 	$data_list['class_address'] = '';
						 }
						$data_list['test_t'] = date('Y-m-d H:i:s',$v->exam_start_time).'----'.date('Y-m-d H:i:s',$v->exam_end_time);
						
						$sql_teacher = 'select monitor_id from res where request_id='.$v->id;
						$data_teacher = $this->root_model->query_info($sql_teacher);
						if($data_teacher) {
						foreach($data_teacher as $val_teacher) {
							$data_list['class_teacher_id'] = $val_teacher->monitor_id;
						}
						}else {
							$data_list['class_teacher_id'] = "";
						}
						$data_list_str[] = $data_list;
					}
					
				}
				$this->arr['res'] = $data_list_str;
				
				$this->load->view('admin/teacher_list', $this->arr);
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/main', $this->arr);
				return;
			}
			
		} else {
			$res = $this->root_model->get($sess['teacher_id'], $sess['teacher_pass'], 'teacher');
			if ($res) {
				$this->arr['id'] = $sess['teacher_id'];
				$sql = 'select * from request where teacher_id='.$sess['teacher_id'];
				$res = $this->root_model->query_info($sql);
				
				$sql_name = 'select name from teacher where teacher_id='.$sess['teacher_id'];
				$name = $this->root_model->query_info($sql_name);
				foreach($name as $val_n) {
					$name_str = $val_n->name;
				}
				$data_list_str = array();
				
				if ($res) {
					
					foreach($res as $v) {
						$data_list = array();
						$data_list['id'] = $v->id;
						$data_list['teacher_id'] = $v->teacher_id;
						
						$data_list['name'] = $name_str;
						$data_list['className'] = $v->class_name;
						$data_list['req_t'] = date('Y-m-d H:i:s',$v->req_t);
						$data_list['num'] = $v->num;
						$data_list['status'] = $v->status;
						$data_list['hour_length'] = $v->hour_length;
						
						$sql = "select room.name from res, room where res.request_id=".$v->id ." and res.room_id = room.id";
						$data_join = $this->root_model->query_info($sql);
						if ($data_join) {
						 foreach($data_join as $val){
							$data_list['class_address'] = $val->name;
						 }
						}else {
							$data_list['class_address'] = '';
						}
						$data_list['test_t'] = date('Y-m-d H:i:s',$v->exam_start_time).'----'.date('Y-m-d H:i:s',$v->exam_end_time);
						
						$sql_teacher = 'select monitor_id from res where request_id='.$v->id;
						$data_teacher = $this->root_model->query_info($sql_teacher);
						if ($data_teacher) {
							foreach($data_teacher as $val_teacher) {
								$data_list['class_teacher_id'] = $val_teacher->monitor_id;
							}
						}else {
							$data_list['class_teacher_id'] = '';
						}
						$data_list_str[] = $data_list;
					}
				}
				$this->arr['res'] = $data_list_str;
				
				$this->load->view('admin/teacher_list', $this->arr);
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/main', $this->arr);
				return;
			}
		}
		$this->load->view('footer/footer');
		
		
	}
	
	//教师个人信息
	public function teacherInfo($id) {
		$this->arr['title'] = '教师信息';
		$res = $this->root_model->searchById($id, 'teacher');
		error_log(print_r($res, true),3,'d:/log/error.log');
		$this->arr['status'] = ($res[0]->status=='1')?'空闲':'忙碌';
		$this->load->view('header/header', $this->arr);
		$this->load->view('admin/teacherInfo');
		$this->load->view('footer/footer');
	}
	
	//教师修改密码
	public function changePass() {
		$teacher_pass = $this->input->post();
			
		if ($teacher_pass['newPass'] !== $teacher_pass['passAgain']) {
			echo json_encode(array('s' => 'dif'));
			return;
		} 
		$sess = $this->session->all_userdata();
		$res = $this->root_model->get($sess['teacher_id'], $teacher_pass['oldPass'], 'teacher');
		if (!$res) {
			echo json_encode(array('s' => 'no'));
			
		}else {
			$newPass = md5($teacher_pass['newPass'].'monitor');
			$up_data = array('teacher_pass'=>$newPass);
			
			$this->root_model->update($up_data, $sess['teacher_id'], 'teacher');
			echo json_encode(array('s'=>'ok'));
		}
	}
	
	//更新教师状态
	public function changeStatus(){
		$status = $this->input->post();
		$sess = $this->session->all_userdata();
		
		$up_data = array(
			'status' => $status['status']
		);
		$res = $this->root_model->update($up_data, $sess['teacher_id'], 'teacher');
		echo json_encode(array('s'=>'ok'));
	}

	//教师提交监考信息请求
	public function subReq($id) {
		$this->arr['title'] = '教师监考提交';
		$this->arr['id'] = $id;
		$this->load->view('header/header', $this->arr);
		$this->load->view('admin/subReq');
		$this->load->view('footer/footer');
	} 
	
	//处理教师监考申请
	public function insertReq($id) {
		$req = $this->input->post();
		$classNum = $req['classNum'];
		$studentNum = $req['studentNum'];
		$start_t = strtotime($req['start_t']);
		$end_t = strtotime($req['end_t']);
		$className = $req['className'];
		$hour_length = $req['hour_length'];
		
		$now = time();
		if ($start_t <= $now || $end_t <= $start_t) {
			echo json_encode(array('s'=>'timeOut'));
			return;
		}
		

		$insert_data = array(
			'class_name' => $className,
			'class_id' => $classNum,
			'num' => $studentNum,
			'exam_start_time' => $start_t,
			'exam_end_time' => $end_t,
			'req_t' => time(),
			'teacher_id' => $id,
			'hour_length' => $hour_length,
		);
		$insert_res = $this->root_model->insertInfo($insert_data, 'request');
		if($insert_res) {
			echo json_encode(array('s'=>'ok'));
			
		}else {
		 	echo json_encode(array('s' => 'null'));
		}
	}
	
	//教师可以删除提交申请
	public function delReq($id) {
		$req_id = $this->input->post('id');
		//先判断系统有没有处理，如果处理过了，驳回操作
		
		$sql = 'select status from request where id='.$req_id;
		error_log($sql, 3, 'd:/log/error.log');
		$res = $this->root_model->query_info($sql);
		$bool = true;
		if ($res) {
			foreach($res as $v) {
				if ($v->status) {
					$bool = false;
					break;
				}
			}
		}
		if ($bool) {
		
			$arr = array($req_id);
			
			$res = $this->root_model->del('request','id', $arr);
			if ($res) {
				echo json_encode(array('s' => 'ok'));
			} else {
				echo json_encode(array('s' => 'error'));
			}
		}else {
			echo json_encode(array('s' => 'no'));
		}
	}
	
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */