<?php
namespace app\user\model;

use think\Cache;
use think\Model;

Class User extends Model{

	static public function createUser($data){
		$user = new User;
		$items = json_decode($data,true);
		foreach($items as $item){
			$item['password'] = md5($item['password']);
			$user->allowField(true)->save($item);
		}
	}
	
	static public function index($item){
		$limit = $item['limit'];
		$where = [];
        $result = self::alias('u')
            ->order('id desc')
            ->where($where) 
            ->field("u.*")
            ->paginate($limit,false);
        $res['data'] = $result->items();
        $res['count'] = $result->total();
		return $res;
	}
	
	static public function read($item){
		$user = User::get(['id' => $item])->toArray();
		return $user;
	}
	
    static public function updateUser($id,$item){
		$item = json_decode($item,true);
		$user = new User;
		$user->save($item,['id' => $id]);
		return $user;
	}
	
}