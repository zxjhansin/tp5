<?php
namespace app\user\controller;
use app\user\model\User;
use think\Request;
use think\Config;
class Users extends Base
{
	public function __construct(Request $request = null)
    {
		$this->request = $request;
		$this->code = Config::get("code");
    }
    //GET list
    public function index()
    {
		$this->checkToken();
		$users = User::index($_GET);
		$this->returnJson($this->code['success']['code'],$this->code['success']['msg'],$users['data'],$users['count']);
    }
	//POST insert
	public function save(){
		$data = $this->request->post()['data'];
		User::createUser($data);
	}
	
    //GET read
	public function read($id){
		$user = User::read($id);
		$this->returnJson($this->code['success']['code'],$this->code['success']['msg'],$user);
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
