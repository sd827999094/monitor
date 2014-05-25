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
				$this->load->view('admin/teacher_list');
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/main', $this->arr);
				return;
			}
			
		} else {
			$res = $this->root_model->get($sess['teacher_id'], $sess['teacher_pass'], 'teacher');
			if ($res) {
				$this->load->view('admin/teacher_list');
				
			} else {
				$this->arr['error'] = 'error';
				
				$this->load->view('admin/main', $this->arr);
				return;
			}
		}
		$this->load->view('footer/footer');
		
		
	}
	
	//教师个人信息
	public function teacherInfo() {
		$this->arr['title'] = '教师信息';
		$this->load->view('header/header', $this->arr['title']);
		$this->load->view('admin/teacherInfo');
		$this->load->view('footer/footer');
	}
	
	
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */