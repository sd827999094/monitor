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
		$hash = 'monitor';
		$pass = md5('123456'.$hash);
		$data = array(
				'teacher_id' => $teacherInfo['teacherId'],
				'name' => $teacherInfo['teacherName'],
				'sex' => $teacherInfo['sex'],
				'department' => $teacherInfo['department'],
				'teacher_pass' => $pass,
				'status' => '0',
                'busyDate' => '',
                'monitor_times' => 0,
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
		
		$data = array(
			'name' => $classInfo['name'],
			'num' => $classInfo['num'],
            'time' => '',
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
		$res = $this->root_model->del('room', 'id', $arr_del);
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
		
		$arr = array($req_id);
		
		$res = $this->root_model->del('request','id', $arr);
        $res_r = $this->root_model->del('res', 'request_id', $arr);
		if ($res && $res_r) {
			echo json_encode(array('s' => 'ok'));
		} else {
			echo json_encode(array('s' => 'error'));
		}
	
	}
    
	
	//定时任务，每天13:00和24:00进行更新，处理监考需求
    //手动处理也放到这里处理
	public function dealRequestByRoot() {
		
        $id = $this->input->post();
        if ($id) {
            $sql = 'select * from request where id='.$id['id'];
        }else {
		    $sql = 'select * from request';
        }
		$res_req = $this->root_model->query_info($sql);
		
		if ($res_req) {
			foreach($res_req as $k => $v) {
                //先分配教室
                $arr_class = $this->chooseRoom($v);
                //教室分配成功
                if ($arr_class) {
                    $class_str = implode(',', $arr_class);
                    $monitor_id = $this->chooseTeacher($v);
                    //教师分配成功
                    if($monitor_id) {
                        //分配全部成功，更改申请状态
                        $up_status = array(
                            'status' => '通过',
                        );
                        $where = array($v->id);
                        $this->root_model->alterData($up_status, $where, 'request');
                        $sql_f = 'select name from teacher where teacher_id='.$v->teacher_id;
                        $res_f = $this->root_model->query_info($sql_f);
                        if ($res_f) {
                            foreach($res_f as $vf) {
                                $teacher_name = $vf->name;
                            }
                        }
                        $str_tea = '';
                        $arr_mon = explode(',',$monitor_id);
                        foreach($arr_mon as $v_mon) {
                            $sql_rom = 'select name from teacher where teacher_id='.$v_mon;
                            $res_rom = $this->root_model->query_info($sql_rom);
                            if ($res_rom) {
                                foreach($res_rom as $vr) {
                                    $str_tea .= $vr->name;
                                    $str_tea .= ',';
                                }
                            }
                        }
                        if ($str_tea) {
                           $str_tea = substr($str_tea, 0, strlen($str_tea)-1);

                        }
                        
                        $str_rom = '';
                        foreach($arr_class as $v_rom) {
                            $sql_rom = 'select name from room where id='.$v_rom;
                            $res_rom = $this->root_model->query_info($sql_rom);
                            if ($res_rom) {
                                foreach($res_rom as $vr) {
                                    $str_rom .= $vr->name;
                                    $str_rom .= ',';
                                }
                            }
                        }
                        if ($str_rom) {
                           $str_rom = substr($str_rom, 0, strlen($str_rom)-1);

                        }
                        //写入最后结果表
                        $insert = array(
                            'request_id' => $v->id,
                            'room_id' =>$class_str,
                            'monitor_id' => $monitor_id, 
                            'class_name' => $v->class_name,
                            'class_id' => $v->class_id,
                            'teacher_id' => $v->teacher_id,
                            'start_t' => $v->exam_start_time,
                            'end_t' => $v->exam_end_time,
                            'teacher_name' => $teacher_name,
                            'room_name' =>$str_rom,
                            'monitor_name'=> $str_tea,
                        );
                        $this->root_model->insertInfo($insert, 'res');
                        if ($id) {
                            echo json_encode(array('s'=>'ok'));
                        }
                    }else {
                        error_log('分配教师失败!',3, '/Users/yuyang/PHP/jkao/monitor/log/error.log');
                        //消除分配教室信息
                        foreach($arr_class as $v_class) {
                            $del_sql = 'select * from room where id='.$v_class;
                            $del_res = $this->root_model->query_info($del_sql);
                            if ($del_res) {
                                foreach($del_res as $del_v) {
                                    $time_del = $del_v->time;
                                    $time_del = substr($time_del, 0, strrpos($time_del, ','));
                                    $up_arr = array(
                                        'time' => $time_del,
                                    );
                                    $where = array($v_class);
                                    $this->root_model->alterData($up_arr, $where, 'room');
                                }
                            }
                        }
                        if ($id) {
                            echo json_encode(array('s'=>'noteacher'));
                        }

                    }
                }else {
                    error_log('分配教室失败!', 3, '/Users/yuyang/PHP/jkao/monitor/log/error.log');
                    if ($id) {
                        echo json_encode(array('s'=>'noroom'));
                    }
                }

			}
		}else {
            echo json_encode(array('s'=>'norequest'));
			return null;
		}
	}
    //选教师
    public function chooseTeacher($v) {
        //提出申请的老师必定监考
        $res_t = $v->teacher_id;
        $sql_t = 'select * from teacher where teacher_id='.$res_t;
        $res_one = $this->root_model->query_info($sql_t);
        if ($res_one) {
            $arr_one = array();
            foreach($res_one as $value) {
                $arr_one[] = $value;
            }
            $up_t = array(
                'busyDate' => $arr_one[0]->busyDate.','.$v->exam_start_time,
            );
            $where = array($res_t);
            $this->root_model->alterData($up_t, $where, 'teacher');
        }else {
            return null;
        }

        //判断需要的监考老师人数
        $num = ceil($v->num/30);
        $count = $num -1;
        for($i=0;$i<$count;$i++) {
            $res = $this->chooseOneTeacher($v);
            //如果老师不够，直接返回null并退出
            if (!$res) {
                return null;
                break;
            }
            $res_t .= ','.$res;
        }
        //返回监考列表，需要加入最终结果表
        return $res_t;
    }

    //选择一个教师
    public function chooseOneTeacher($v) {
       $sql = 'select * from teacher'; 
       $res_t = $this->root_model->query_info($sql);
       if ($res_t) {
            $t_arr = array();
            foreach($res_t as $teacher_v)  {
                $busyDate = $teacher_v->busyDate;
                //如果该老师不忙碌，挑选出来
                if (!$busyDate) {
                    $t_arr[] = $teacher_v;
                    continue;
                }else {
                    //如果该老师忙碌，但并不在这一天，加入
                    $busy_arr = explode(',', $busyDate);
                    $bool_t = true;
                    foreach($busy_arr as $t) {
                        $t = $t- $t%86400;
                        $v_t = $v->exam_start_time-$v->exam_start_time%86400;
                        if ($t == $v_t) {
                            $bool_t = false;
                            break;
                        }
                    }
                    if ($bool_t) {
                        $t_arr[] = $teacher_v;
                    }
                }
            }
            //对符合该条请求的所有老师按照监考次数排序
            $t_count = count($t_arr);
            if ($t_count) {
                for($i=1;$i<$t_count;$i++) {
                    for($j=0;$j<$t_count-$i;$j++) {
                        if ($t_arr[$j]->monitor_times > $t_arr[$j+1]->monitor_times) {
                            $temp = $t_arr[$j];
                            $t_arr[$j] = $t_arr[$j+1];
                            $t_arr[$j+1] = $temp;
                        }
                    }
                }
                //选出监考次数最少的老师
                $up_t = array(
                    'busyDate' => ($t_arr[0]->busyDate).','.$v->exam_start_time,
                    'monitor_times' => ($t_arr[0]->monitor_times)+1,
                );
                $where = array($t_arr[0]->teacher_id);
                $this->root_model->alterData($up_t, $where, 'teacher');
                return $t_arr[0]->teacher_id;
            }else {
                return null;
            }


       }else {
            return null;
       }
    }
    //选教室
    /*
     *
     *
     *@return 
     *      返回选中教室id数组
     *
     **/
    public function chooseRoom ($v) {

        //如果一间教室可以完成
        $room_arr = array();
        $count = 1;
        //10倍分率,已足够
        for($i=1;$i<10;$i++) {
            $res = $this->chooseOneRoom($v, $i);
            //如果分到了教室，则找到了分教室的标准
            if ($res) {
                $room_arr[0] = $res;
                for($j=1;$j<$count;$j++) {
                    $res = $this->chooseOneRoom($v, $i);
                    //内部不可再做分率
                    if ($res) {
                        $room_arr[$j] = $res;
                    }
                }
                break;
            }else {
                //否则记录还需分几次
                $count ++;
            }
        }
        return $room_arr;
    }

    //选择一间教室
    public function chooseOneRoom($v, $lv) {
        $sql_room = 'select * from room where num >='.$v->num/$lv;
        $res_room = $this->root_model->query_info($sql_room);
        $room_arr = array();
        $mini = 0;

        if ($res_room) {
            foreach($res_room as $v_room) {
                $room_arr[$mini] = $v_room;
                $mini ++;
            }

            //冒泡排序选出容量最小的教室
            for($i=1;$i<$mini;$i++) {
                for($j=0;$j<$mini-$i;$j++) {
                    if($room_arr[$j]->num > $room_arr[$j+1]->num) {
                        $temp = $room_arr[$j];
                        $room_arr[$j] = $room_arr[$j+1];
                        $room_arr[$j+1] = $temp;
                    }
                }
            }
            //查看最小教室是否被占用，如果没有，则选择之，否则向后顺延
            $date_array = '';
            for($m=0;$m<$mini;$m++) {
                if (!$room_arr[$m]->time) {
                    //选中该教室
                    //$sql_rup = 'update room set time = '.$v->exam_start_time.'-'.$v->exam_end_time.',';
                    $up_dt = array(
                        'time' => $v->exam_start_time.'-'.$v->exam_end_time,
                    );
                    $where = array($room_arr[$m]->id);
                    $this->root_model->alterData($up_dt, $where, 'room');
                    return $room_arr[$m]->id;
                }else {
                    //如果已经有占领，则判断其时间与请求时间是否冲突
                    $time = $room_arr[$m]->time;
                        $time_arr = explode(',',$time);
                    if ($m == 0) {
                        $date_array = $time;
                    }
                    $bool = true;
                    //如果时间不冲突，表明这间教室可以使用，标记使用
                    foreach($time_arr as $time_v) {
                        $arr_v = explode('-', $time_v);
                        if (($arr_v[0]>= $v->exam_start_time && $arr_v[0]>=$v->exam_end_time)||($arr_v[1]<=$v->exam_start_time && $arr_v[1]<=$v->exam_end_time)) {
                            continue;
                        }
                        $bool = false;

                    }
                    if ($bool) {
                        $time = $time.','.$v->exam_start_time.'-'.$v->exam_end_time;
                        $up_dt = array(
                            'time' => $time,
                        );
                        $where = array($room_arr[$m]->id);
                        $this->root_model->alterData($up_dt, $where, 'room');
                        return $room_arr[$m]->id;
                    }
                }
            }
            //如果所有教室都不满足期望时间,则系统自动设定
            $long = $v->hour_length;
            for($i=1;$i<=20;$i++) {
                $bool = true;
                //自动设置为请求时间的延后的相同时间
                $start_t = $v->exam_start_time + 86400*$i;
                $end_t = $v->exam_end_time + 86400*$i;
                $date_l = explode(',', $date_array);
                foreach($date_l as $time_v) {
                    $arr_l = explode('-', $time_v);
                    if (($arr_l[0]>= $v->exam_start_time && $arr_l[0]>=$v->exam_end_time)||($arr_l[1]<=$v->exam_start_time && $arr_l[1]<=$v->exam_end_time)) {
                        continue;
                    }
                    $bool = false;
                    break;   
                }
                if ($bool) {
                    $time = $date_array.','.$start_t.'-'.$end_t;
                    $up_dt = array(
                        'time' => $time,
                    );
                    $where = array($room_arr[0]->id);
                    $this->root_model->alterData($up_dt, $where, 'room');
                    //更改申请期望时间
                    $up_re = array(
                        'exam_start_time' => $start_t,
                        'exam_end_time' => $end_t,
                    );
                    $where = array($v->id);
                    $this->root_model->alterData($up_re, $where, 'request');
                    return $room_arr[0]->id;
                }
            }
        } else {
            //一间教室分不开
            return null;
        }
    }
} 

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
