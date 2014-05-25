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
		
			$res = $this->root_model->get($user['user_name'], $user['user_pass']);
			if ($res) {
				$this->session->set_userdata($user);
				$this->load->view('admin/list');
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/rootMain', $this->arr);
				return;
			}
			
		} else {
			$res = $this->root_model->get($sess['user_name'], $sess['user_pass']);
			if ($res) {
				$this->load->view('admin/list');
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/rootMain', $this->arr);
				return;
			}
		}
		
		
		
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
		$page = ($page-1)*$limit;
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
		
		$data = array(
				'teacher_id' => $teacherInfo['teacherId'],
				'name' => $teacherInfo['teacherName'],
				'sex' => $teacherInfo['sex'],
				'department' => $teacherInfo['department'],
				'start_work_time' => $teacherInfo['start_work_time'],
				'end_work_time' => $teacherInfo['end_work_time']
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
		$res = $this->root_model->del('teacher','teacher_id',$del_id);
		if ($res) {
			echo json_encode(array('s'=>'ok'));
		}else {
			echo json_encode(array('s'=>'faild'));
		}
	}
	//删除教室
	public function delClass() {
		$del_id = $this->input->post();
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
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
