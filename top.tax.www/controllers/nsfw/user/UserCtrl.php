<?php

/*
	系统用户管理模块
*/
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define('BASE_PATH', 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/');

class UserCtrl extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->helper(array('form', 'url'));
	}

	// 展示用户页面
	public function listUI(){

		// 获取搜索关键词
		$keyword = $this->input->post('search');
		// 判断url是否带有keyword
		if (strpos(uri_string(), 'keyword') !== false) {
			# code...
			$params = $this->uri->uri_to_assoc();
			$keyword = $params['keyword'];
		}
		if ($keyword === null) {
			$keyword = '';
		}
		$data['keyword'] = $keyword;

		// 获取要跳转到的页面
		$pageNo = $this->input->post('pageNo');
		if (empty($pageNo)) {
			$pageNo = 1;
		}
		$data['pageNo'] = $pageNo;
		// 获取指定条件的总数
		$data['total'] = $this->UserModel->getTotal($keyword);
		$data['totalCount'] = $data['total'] % 10 == 0 ? ($data['total']/10) : (floor($data['total']/10) + 1);

		// 根据条件分页查询数据
		$user = $this->UserModel->list($keyword,$pageNo);
		$data['users'] = $user;

		// echo ROOT_PATH;
		// echo '</br>';
		
		$this->load->view('nsfw/user/listUI',$data);
	}

	// 进入到新增用户页面
	public function addUI(){

		// 获取搜索关键词
		$keyword = $this->input->post('search');
		if ($keyword === null) {
			$keyword = '';
		}
		$data_addUI['keyword'] = $keyword;
		
		// 测试角色，后面处理完角色管理后，从数据库查询在传值
		$data_addUI['roles'] = array(
			'成员','群主','管理员'
		);
		$this->load->view('nsfw/user/addUI',$data_addUI);
	}

	// 新增用户方法
	public function add(){

		// 获取表单数据
		$keyword = $this->input->post('keyword');
		// echo $keyword;
		$data_add['dept'] = $this->input->post('dept');
		$data_add['headImg'] = $this->upload(uniqid(),'headImg');
		$data_add['name'] = $this->input->post('name');
		$data_add['account'] = $this->input->post('account');
		$data_add['password'] = $this->input->post('password');
		$data_add['gender'] = $this->input->post('gender');
		$data_add['email'] = $this->input->post('email');
		$data_add['mobile'] = $this->input->post('mobile');
		$data_add['birthday'] = $this->input->post('birthday');
		$data_add['state'] = $this->input->post('state');
		$data_add['memo'] = $this->input->post('memo');
		// 角色数据单独取，后面存入另一个数据库
		$roles['roles'] = $this->input->post('roles');
		// var_dump($this->input->post('roles'));
		// 将数据存入数据库
		$this->UserModel->add($data_add);
		// 返回用户列表界面
		redirect('/nsfw/user/UserCtrl/listUI/keyword/'.$keyword,'auto');
		// $this->load->view('welcome_message');
	}

	// 表单验证方法
	public function validate(){
		$params = $this->uri->uri_to_assoc();
		$result = $this->UserModel->queryByAcc($params['account']);
		if (empty($result)) {
			echo json_encode(array('msg'=>'true'));
			exit;
		}else{
			echo json_encode(array('msg'=>'false'));
			exit;
		}
				
	}

	// 进入到编辑用户界面
	public function editUI(){

		// 获取搜索关键词
		$keyword = $this->input->post('search');
		if ($keyword === null) {
			$keyword = '';
		}
				
		$params = $this->uri->uri_to_assoc();
		// echo $params['id'];
		$data_editUI = $this->UserModel->queryById($params['id']);
		// 这句代码必须放在上句后面，因为此时$data_editUI才被定义，放在之前会不能赋值成功
		$data_editUI['keyword'] = $keyword;
		// 测试角色，后面处理完角色管理后，从数据库查询在传值
		$data_editUI['roles'] = array(
			'成员','群主','管理员'
		);

		// 后面从与用户库关联的表查询后传值，这里先模拟
		$data_editUI['cuRoles'] = array(
			'成员','群主'
		);

		// var_dump($data_editUI);
		$this->load->view('nsfw/user/editUI',$data_editUI);
	}


	// 编辑用户方法
	public function edit(){
		
		// 获取表单数据
		$keyword = $this->input->post('keyword');
		$id = $this->input->post('id');
		$data_edit['dept'] = $this->input->post('dept');
		$data_edit['name'] = $this->input->post('name');
		$data_edit['account'] = $this->input->post('account');
		$data_edit['password'] = $this->input->post('password');
		$data_edit['gender'] = $this->input->post('gender');
		$data_edit['email'] = $this->input->post('email');
		$data_edit['mobile'] = $this->input->post('mobile');
		$data_edit['birthday'] = $this->input->post('birthday');
		$data_edit['state'] = $this->input->post('state');
		$data_edit['memo'] = $this->input->post('memo');
		$data_edit['headImg'] = $this->upload(uniqid(),'headImg');
		
		if ($data_edit['headImg'] === '') {
			$data_edit['headImg'] = $this->UserModel->queryByHead($id)[0]['headImg'];
		}
		// echo $data_edit['headImg'];
		// 角色数据单独取，后面存入另一个数据库
		$roles['roles'] = $this->input->post('roles');

		// 将数据更新到数据库
		$this->UserModel->edit($data_edit,$id);
		// 返回用户列表界面
		redirect('/nsfw/user/UserCtrl/listUI/keyword/'.$keyword,'auto');
		// $this->load->view('upload_success');
	}


	// 删除用户方法
	public function delete(){
		
		// 获取id
		$params = $this->uri->uri_to_assoc();
		$id = $params['id'];
		// 获取表单数据
		$keyword = $this->input->post('search');
		// echo $keyword;
		// 角色数据单独取，后面存入另一个数据库
		// 这里从数据库查询数据在删除或者是直接删除用户，根据后面角色的设计来写代码
		// echo $id;
		// 将数据更新到数据库
		$result = $this->UserModel->delete($id);
		// var_dump($result);
		// 返回用户列表界面
		redirect('/nsfw/user/UserCtrl/listUI/keyword/'.$keyword,'auto');
		// $this->load->view('welcome_message');
	}

	public function do_upload(){
		$data['ddd'] = 'dddd';
		$result = $this->upload('fedfe','userfile');
		echo $result;
		$this->load->view('upload_success');
	}

	// 上传头像
	private function upload($filename,$field){
		$config['upload_path'] = 'F:/php_workplaces/top.tax.www/upload/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['file_name'] = $filename;


		$this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($field))
        {
        	// 这里不再前端页面提示错误，前端页面没设计，自己做的应该设计，这里可以记录在系统错误日志里
            $error = $this->upload->display_errors();
            return '';
        }
        else
        {
            $filename = array('upload_data' => $this->upload->data('file_name'));
            $real_path = BASE_PATH.'upload/'.$filename['upload_data'];

            return $real_path;
        }
	}
}