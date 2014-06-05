<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Root extends CI_Controller {

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
		$this->load->model('root_model');
		$this->load->library('session');
	 }
	//登录界面
	public function index()
	{
		$this->arr['title'] = '管理员后台管理';
		$this->load->view("header/header", $this->arr);
		$this->load->view('admin/rootMain');
		$this->load->view('footer/footer');
	}
	
	//主页面
	public function main() {
		$this->arr['title'] = '管理员后台管理';
		$this->load->view('header/header', $this->arr);
		$sess = $this->session->all_userdata();
		if (!isset($sess['user_name']) || !isset($sess['user_pass'])) {
			$user = $this->input->post();
		
			$res = $this->root_model->get($user['user_name'], $user['user_pass'], 'admin');
			if ($res) {
				$this->session->set_userdata($user);
				$this->load->view('admin/list');
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/rootMain', $this->arr);
				
			}
			
		} else {
			$res = $this->root_model->get($sess['user_name'], $sess['user_pass'], 'admin');
			if ($res) {
				$this->load->view('admin/list');
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/rootMain', $this->arr);
				
			}
		}
		$this->load->view('footer/footer');
		
		
	}
	
	//教师管理页面
	public function teacherManage($page=1, $limit=40) {
		if ($page < 1) {
			$page = 1;
		}
		$nu = $this->root_model->getNum('teacher');
		
		if (ceil($nu/$limit) < $page) {
			$page = ceil($nu/$limit);
		}
		$this->arr['title'] = '教师管理页面';
		$this->arr['page'] = $page?$page:1;
		$page = ($this->arr['page']-1)*$limit;
		$this->arr['teacherInfo'] = $this->root_model->getInfo($page, $limit, 'teacher');
		$this->arr['limit'] = $limit;
		$this->load->view('header/header', $this->arr);
		$this->load->view('admin/teacherManage');
		$this->load->view('footer/footer');
	}
	
	public function addteacher() {
		$teacherInfo = $this->input->post();
		$teacherInfo['start_work_time'] = $teacherInfo['start_work_time'] ? $teacherInfo['start_work_time'] : 0;
		$teacherInfo['end_work_time'] = $teacherInfo['end_work_time'] ? $teacherInfo['end_work_time'] : 0;
		$teacherInfo['start_work_time'] = strtotime($teacherInfo['start_work_time']);
		$teacherInfo['end_work_time'] = strtotime($teacherInfo['end_work_time']);
		$hash = 'monitor';
		$pass = md5('123456'.$hash);
		$data = array(
				'teacher_id' => $teacherInfo['teacherId'],
				'name' => $teacherInfo['teacherName'],
				'sex' => $teacherInfo['sex'],
				'department' => $teacherInfo['department'],
				'start_work_time' => $teacherInfo['start_work_time'],
				'end_work_time' => $teacherInfo['end_work_time'],
				'teacher_pass' => $pass,
				'status' => '0',
			);
		$res = $this->root_model->insertInfo($data, 'teacher');
		if($res) {
			echo json_encode(array('s'=>'ok'));
		} else {
			echo json_encode(array('s'=>'no'));
		}
	}
	//添加教室
	public function addclass() {
		
		$classInfo = $this->input->post();
		$classInfo['start_work_time'] = $classInfo['start_work_time'] ? $classInfo['start_work_time'] : 0;
		$classInfo['end_work_time'] = $classInfo['end_work_time'] ? $classInfo['end_work_time'] : 0;
		$classInfo['start_work_time'] = strtotime($classInfo['start_work_time']);
		
		$data = array(
			'name' => $classInfo['name'],
			'num' => $classInfo['num'],
			'work_start' => $classInfo['start_work_time'],
			'work_end' => $classInfo['end_work_time'],
		);
		$res = $this->root_model->insertInfo($data, 'room');
		if ($res) {
			echo json_encode(array('s'=>'ok'));
		} else {
			echo json_encode(array('s'=>'no'));
		}
	}
	
	
	//删除教师
	public function delTeacher(){
		$del_id = $this->input->post();
		
		$arr_del = explode(',', $del_id['del_id']);
		
		$res = $this->root_model->del('teacher','teacher_id',$arr_del);
		if ($res) {
			echo json_encode(array('s'=>'ok'));
		}else {
			echo json_encode(array('s'=>'faild'));
		}
	}
	//删除教室
	public function delClass() {
		$del_id = $this->input->post();
		$arr_del = explode(',', $del_id['del_id']);
		$res = $this->root_model->del('room', 'id', $del_id);
		if ($res) {
			echo json_encode(array('s'=>'ok'));
		}else {
			echo json_encode(array('s'=>'no'));
		}
	}
    //修改教师统一信息
    public function alterteacher(){
        $data = $this->input->post();
		$data['teacher_id'] = substr($data['teacher_id'], 0, strlen($data['teacher_id'])-1);
		$teacher_select = explode(',', $data['teacher_id']);
		unset($data['teacher_id']);
		if (isset($data['sex'])) {
			if ($data['sex'] == '1'){
				$data['sex'] = '男'; 
			} else if ($data['sex'] == '2') {
				$data['sex'] = '女';
			}
		}
		$res = $this->root_model->alterData($data, $teacher_select, 'teacher');
		if ($res) {
			echo json_encode(array('s'=>'ok'));
		}else {
			echo json_decode(array('s'=>'no'));
		}
    }
	
	 //修改教室统一信息
    public function alterClass(){
        $data = $this->input->post();
		$data['id'] = substr($data['id'], 0, strlen($data['id'])-1);
		$data_select = explode(',', $data['id']);
		unset($data['id']);
		
		
		$res = $this->root_model->alterData($data, $data_select, 'room');
		if ($res) {
			echo json_encode(array('s'=>'ok'));
		}else {
			echo json_decode(array('s'=>'no'));
		}
    }
	//教室管理页面
	public function classManage($page=1, $limit=40) {
		
		if ($page < 1) {
			$page = 1;
		}
		$nu = $this->root_model->getNum('room');
		
		
		if (ceil($nu/$limit) < $page) {
			$page = ceil($nu/$limit);
		}

		$this->arr['title'] = '教室管理页面';
		$this->arr['page'] = $page?$page:1;
		$page = ($this->arr['page']-1)*$limit;
		$this->arr['classInfo'] = $this->root_model->getInfo($page, $limit, 'room');
		$this->arr['limit'] = $limit;
		$this->load->view('header/header', $this->arr);
		$this->load->view('admin/classManage');
		$this->load->view('footer/footer');
	
	}
	//教师提交信息管理页面
	public function requestManage() {
		$sql = 'select * from request';
		$res_list = $this->root_model->query_info($sql);
		$this->arr['title'] = '教师请求管理';
		$this->load->view('header/header',$this->arr);
		$data_list_str = array();
		if ($res_list) {
			
			foreach($res_list as $v) {
				$data_list = array();
				
				$sql_name = 'select name from teacher where teacher_id='.$v->teacher_id;
				$name = $this->root_model->query_info($sql_name);
				if ($name) {
					foreach($name as $val_n) {
						$name_str = $val_n->name;
					}
				}else {
					$name_str = '';
				}
				
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
		
		$this->load->view('admin/requestManage', $this->arr);
		$this->load->view('footer/footer');
	}
	
	
	//查找
	public function search() {
		$search = $this->input->post('search');
		$type = $this->input->post('hidden');
		
		$this->arr['page'] = 1;
		$this->arr['limit'] = 40;
		$this->arr['title'] = '教师管理页面';
		$this->load->view('header/header', $this->arr);
		if (!$search) {
			$this->arr['teacherInfo'] = array();
			
			$this->load->view('admin/'.$type.'.php', $this->arr);
		} else {
			if ($type == 'teacherManage'){
				$res = $this->root_model->search($search, 'teacher');
				$this->arr['teacherInfo'] = $res;
			}
			else if ($type == 'classManage') {
				$res = $this->root_model->search($search, 'room');
				$this->arr['classInfo'] = $res;
			}
			$this->load->view('admin/'.$type.'.php', $this->arr);
		}
		$this->load->view('footer/footer');
	}


	//删除
	public function delReq() {
		$req_id = $this->input->post('id');
		//先判断系统有没有处理，如果处理过了，驳回操作
		
		$arr = array($req_id);
		
		$res = $this->root_model->del('request','id', $arr);
		if ($res) {
			echo json_encode(array('s' => 'ok'));
		} else {
			echo json_encode(array('s' => 'error'));
		}
	
	}
	
	
	//定时任务，每天13:00和24:00进行更新，处理监考需求
	public function dealRequestByRoot() {
		
		$sql = 'select * from request';
		$res_req = $this->root_model->query_info($sql);
		
		if ($res_req) {
			foreach($res_req as $k => $v) {
				//遍历教室容量,取教室最小的
				$sql_room = 'select * from room where num >='.$v->num;
				$res_room = $this->root_model->query_info($sql_room);
				$room_arr = array();
				$mini = 0;
				//如果一个教室可以承载
				if ($res_room) {
					foreach($res_room as $v_room) {
						$room_arr[$mini] = $v_room;
						$mini ++;
					}
					
					//冒泡排序选出容量最小的教室
					for($i=1;$i<$mini;$i++) {
						for($j=0;$j<$mini-$i;$j++) {
							if($res_room[$j]->num > $res_room[$j+1]->num) {
								$temp = $res_room[$j];
								$res_room[$j] = $res_room[$j+1];
								$res_room[$j+1] = $temp;
							}
						}
					}
					//查看最小教室是否被占用，如果没有，则选择之，否则向后顺延
					for($m=0;$m<$mini;$m++) {
						if (!$res_room[$m]->status) {
							//选中该教室
							//$sql_rup = 'update room set time = '.$v->exam_start_time.'-'.$v->exam_end_time.',';
							$up_dt = array(
								'time' => $v->exam_start_time.'-'.$v->exam_end_time,
							);
							$where = array($res_room[$m]->id);
							$this->root_model->alterData($sql_rup, $where, 'room');
							
							
							
						}
					}
				}else {
					
				}
			}
		}else {
			return null;
		}
	}
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
