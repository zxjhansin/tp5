<?php
namespace app\user\controller;

use Firebase\JWT\JWT;
use think\Request;
use app\user\model\User;
class login{
	
	public function __construct(Request $request = null)
    {
		$this->request = $request;
    }
	
	public function save(){
		$data = $this->request->post();
		$username = $data['username'];
		$password = $data['password'];
		$user =  User::where(['username'=>$username])->find();
		if(!empty($user)){
			if($username == $user['username'] && $password == $user['password']){
                $msg = [
                    'status' => 1001,
                    'msg' => '登录成功',
                    'jwt' => self::createJwt($user['id'])
                ];
                
			}else{
				$msg = [
                    'status' => 1002,
                    'msg' => '账号密码错误'
                ];
			}
		}else{
			$msg = [
                'status' => 1002,
                'msg' => '请输入账号密码'
            ];
		}
		return json($msg);
	}
	
	public function createJwt($userId)
    {
        $key = md5('pingeban'); //jwt的签发密钥，验证token的时候需要用到
        $time = time(); //签发时间
        $expire = $time + 14400; //过期时间
        $token = array(
            "user_id" => $userId,
            "iss" => "http://bd.pingeban.cn",//签发组织
            "aud" => "http://bd.pingeban.cn", //签发作者
            "iat" => $time,
            "nbf" => $time,
            "exp" => $expire
        );
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }
}