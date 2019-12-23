<?php
namespace app\user\model;

use think\Cache;
use think\Model;

Class User extends Model{
	
	static public function createUser($data){
		$user = new User;
		$items = json_decode($data,true);
		foreach($items as $item){
			$user->allowField(true)->save($item);
		}
	}
	
}