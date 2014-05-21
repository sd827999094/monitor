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
		$nu = $this->root_model->getTeacherNum();
		
		if (ceil($nu/$limit) < $page) {
			$page = ceil($nu/$limit);
		}
		$this->arr['title'] = '教师管理页面';
		$this->arr['page'] = $page?$page:1;
		$page = ($page-1)*$limit;
		$this->arr['teacherInfo'] = $this->root_model->getTeacherInfo($page, $limit);
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
		$res = $this->root_model->insertTeacherInfo($teacherInfo);
		if($res) {
			echo json_encode(array('s'=>'ok'));
		} else {
			echo json_encode(array('s'=>'no'));
		}
	}
	
	//删除教师
	public function delTeacher(){
		$del_id = $this->input->post();
		$res = $this->root_model->delTeacher('teacher','teacher_id',$del_id);
		if ($res) {
			echo json_encode(array('s'=>'ok'));
		}else {
			echo json_encode(array('s'=>'faild'));
		}
	}
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */