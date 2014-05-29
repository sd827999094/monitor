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
		$this->arr['status'] = ($res[0]->status=='0')?'空闲':'忙碌';
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
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */