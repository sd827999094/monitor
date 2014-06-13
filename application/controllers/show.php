<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Show extends CI_Controller {
    private $arr;
    public function __construct(){
        parent::__construct();
        $this->load->model('root_model');
        $this->load->helper('url');
        $this->load->helper('download');
    }

    //前端显示
    public function index($page=1, $limit=40) {
		if ($page < 1) {
			$page = 1;
		}
        $nu = $this->root_model->getNum('res');
		if (ceil($nu/$limit) < $page) {
			$page = ceil($nu/$limit);
		}
		$this->arr['title'] = '监考查询';
		$this->arr['page'] = $page?$page:1;
        $this->arr['limit'] = $limit;
		$page = ($this->arr['page']-1)*$limit;
        $this->load->view('header/header',$this->arr );

        $sql = "select * from res limit $page, $limit";
        $this->list_view($sql);
        $this->load->view('footer/footer');

    }
    //查询结果显示
    public function search() {

        $search = $this->input->post('search');
        $type = $this->input->post('hidden');

        $this->arr['page'] = 1;
        $this->arr['limit'] = 40;
        $this->arr['title'] = '监考查询';
        $this->load->view('header/header', $this->arr);
        if (!$search) {
            $this->arr['list'] = array();
            $this->load->view('res_list', $this->arr);

        } else {
            if ($type == 'viewer'){
                $sql_vw = 'select * from res where teacher_name ="'.$search.'" or teacher_id="'.$search.'" or class_name="'.$search.'" or class_id="'.$search.'"';
                $this->list_view($sql_vw);
            }
            else {
                $this->arr['list'] = array();
                $this->load->view('res_list', $this->arr);
            }
        }
        $this->load->view('footer/footer');
    }
    //查询结果包装
    public function list_view($sql) {
        $res = $this->root_model->query_info($sql);
        $arr_list = array();
        if ($res) {
            foreach($res as $v) {
                $v_arr = array();
                $sql_rq = 'select * from request where id ='.$v->request_id;
                $res_rq = $this->root_model->query_info($sql_rq);
                if ($res_rq) {
                    foreach($res_rq as $v_rq) {
                        $v_arr['class_name'] = $v_rq->class_name;
                        $v_arr['class_id'] = $v_rq->class_id;
                        $v_arr['teacher_id'] = $v_rq->teacher_id;
                        $v_arr['start_t'] = $v_rq->exam_start_time;
                        $v_arr['end_t'] = $v_rq->exam_end_time;
                    }
                $sql_tc = 'select name from teacher where teacher_id='.$v_arr['teacher_id'];
                $res_tc = $this->root_model->query_info($sql_tc);
                if ($res_tc) {
                    foreach($res_tc as $v_tc) {
                        $v_arr['teacher_name'] = $v_tc->name;
                    }
                }
                $room = explode(',', $v->room_id);
                $str_rm = '';
                foreach($room as $rm) {
                    $v_rm = array();
                    $sql_rm = 'select * from room where id='.$rm;
                    $res_rm = $this->root_model->query_info($sql_rm);
                    if ($res_rm) {
                        foreach($res_rm as $v_rm) {
                            $str_rm .= $v_rm->name;
                        }
                    }
                    $str_rm .= ',';
                }
                if ($str_rm)
                    $str_rm = substr($str_rm, 0, strlen($str_rm)-1);
                $v_arr['room_name'] = $str_rm;
                $arr_monitor = explode(',', $v->monitor_id);
                $str = '';
                foreach($arr_monitor as $v_mo) {
                    $sql_mo = 'select name from teacher where teacher_id='.$v_mo;
                    $res_mo = $this->root_model->query_info($sql_mo);
                    if ($res_mo) {
                        foreach($res_mo as $v_mo) {
                            $str .= $v_mo->name;
                            $str .= ',';
                        }
                    }
                }
                if ($str) {
                    $str = substr($str, 0, strlen($str)-1);
                }
                $v_arr['monitor_name'] = $str;
                }

                $arr_list[] = $v_arr;
            }
            $this->arr['list'] = $arr_list;
            $this->load->view('res_list', $this->arr);
        }else {
            $this->arr['list'] = array();
            $this->load->view('res_list', $this->arr);
        }
    }

    //数据库导出
    public function outData() {
        ini_set('date.timezone','Asia/Shanghai');

        $path = '/Users/yuyang/PHP/jkao/monitor/export/'.date('Ymd',time()).'.csv';

        /*
        $ec = "select class_id,class_name,teacher_name, start_t, end_t,room_name, monitor_name  from res  into outfile '$path' FIELDS TERMINATED BY ',' ENCLOSED BY '\"'  ESCAPED BY '\\\' LINES TERMINATED BY '\n';";
        exec('mysql -uroot -D monitor -e "'.$ec.'"');
        $sh = 'mysql -uroot -D monitor -e "select class_id,class_name,teacher_name, start_t, end_t,room_name, monitor_name  from res  into outfile \''.$path.    '\' FIELDS TERMINATED BY \',\' ENCLOSED BY \'\"\'  LINES TERMINATED BY \'\n\';"';
        error_log($sh, 3, '/Users/yuyang/PHP/jkao/monitor/log/error.log');

        //exec($sh);
        exec("mysql -uroot -D monitor -e 'select class_id,class_name,teacher_name, start_t, end_t,room_name, monitor_name  from res  into outfile \"/Users/yuyang/PHP/liyan22222.csv\" '");
         */
        $header_str =  iconv("utf-8",'gbk',"课程编号,课程名称,授课老师,考试开始时间,考试结束时间,考试地点,监考老师\n\t");
        $file_str = '';
        $sql_q = 'select * from res';
        $res = $this->root_model->query_info($sql_q);
        if ($res) {
            foreach($res as $v) {
                $file_str .= $v->class_id.','.$v->class_name.','.$v->teacher_name.','.$v->start_t.','.$v->end_t.','.$v->room_name.','.$v->monitor_name."\n\t";
            }
        }
        $file_str=  iconv("utf-8",'gbk',$file_str);
        $header_str .= $file_str;
        if (!$path) {
            exec('touch '.$path);
        }
        file_put_contents($path, $header_str);      

        $path = str_replace('/','_', $path);
        echo json_encode(array('s'=>'ok',
            'h' => $path,
        ));
    }
    //下载
    public function downData($path = '') {
        if ($path) {
            $path = str_replace('_', '/', $path);
            /*
            $data = file_get_contents($path);
            $name = '监考表';
            force_download($name, $data);
             */
            $file=fopen($path,"r");
            header("Content-Type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Accept-Length: ".filesize($path));
            header("Content-Disposition: attachment; filename=监考表.csv");
            echo fread($file,filesize($path));
            fclose($file);
        }
    }
}
