<?php
namespace app\user\controller;
use app\user\model\User;
use think\Request;

class Users extends Base
{
	public function __construct(Request $request = null)
    {
		$this->request = $request;
    }
    //GET list
    public function index()
    {
		$account = $this->checkToken();
		print_r(User::get(['id'=>$account['user_id']]));
    }
	//POST insert
	public function save(){
		$data = $this->request->post()['data'];
		User::createUser($data);
	}
	
    //GET read
	public function read($id){
		echo "read";
    }    
	
    //PUT update
    public function update($id){
		echo "edit";
    }   
	
    //DELETE delete
    public function delete($id){
		echo "delete";
    }   	
}
