<?php



class UserModel extends CI_Model {
	    
    public function __construct(){
    	parent::__construct();
    	$this->load->database();

    }

    // 新增用户
    public function add($user){
    	$this->db->insert('User',$user);
    }

    // 编辑用户
    public function edit($user,$id){
    	$this->db->where('id',$id);
    	$this->db->update('User',$user);
    }

    // 查询所有用户
    /*public function list(){
    	$query = $this->db->query('select * from User;');
    	$row = $query->result_array();
    	$result = null;
    	for ($i=0; $i < count($row); $i++) { 

			$result['user'.$i] = $row[$i];
    	}
    	return $result;
    }*/

    public function getTotal($keyword){
		if (!is_null($keyword)) {
    		$this->db->like('name',$keyword);
    	}
    	return $this->db->count_all_results('User');
    }

    // 根据用户名（模糊）页数查询所有用户
    public function list($keyword,$number = 1){
    	if (!is_null($keyword)) {
    		$this->db->like('name',$keyword);
    	}
    	
    	$index = ($number - 1) * 10;
    	$query = $this->db->get('User',10,$index);
    	$row = $query->result_array();
    	$result = null;
    	for ($i=0; $i < count($row); $i++) { 

			$result['user'.$i] = $row[$i];
    	}
    	return $result;
    }

    // 根据指定条件查询(=)
    // $table:表名
    // $cols:如果只有一个条件，为单个字符串，如果有多个条件，字符串中间以逗号隔开
    // $cons:标准sql语句where后面的语句
    /*public function queryBy($table,$cols,$cons){
    	$this->db->select($cols);
    	$this->db->where($cons);
    	$query = $this->db->get($table);
    	return $query->result_array();
    }*/

    // 根据账户查询
    public function queryByAcc($cons){
    	$this->db->select('account');
    	$this->db->where('account',$cons);
    	$query = $this->db->get('User');
    	return $query->result_array();
    }

    // 根据头像查询
    public function queryByHead($cons){
    	$this->db->select('headImg');
    	$this->db->where('id',$cons);
    	$query = $this->db->get('User');
    	return $query->result_array();
    }

    // 根据id查询
    public function queryById($cons){
    	$query = $this->db->get_where('User',array('id' => $cons));
    	$result = $query->result_array();
    	return $result[0];
    }

    // 删除用户
    public function delete($id){
    	$this->db->where('id',$id);
    	$this->db->delete('User');
    }

}