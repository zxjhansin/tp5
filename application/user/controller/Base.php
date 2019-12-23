<?php
namespace app\user\controller;

use think\Request;
use Firebase\JWT\JWT;

use think\Controller;

class Base extends Controller{
	public function _initialize(){
		parent::_initialize();
	}
	public function checkToken(){
		$header = Request::instance()->header();
		if(!isset($header['authorization']) || $header['authorization'] == 'null'){
			echo  json_encode([
				'status'=> 1002,
				'msg' => 'Token不存在，拒绝访问'
			],JSON_UNESCAPED_UNICODE);
			exit;
			
		}else{
			$checkJwtToken = $this->verifyJwt($header['authorization']);
			if($checkJwtToken['status'] == 1001){
				return $checkJwtToken;
			}
		}
	}
	
	//校验jwt权限API
	protected function verifyJwt($jwt){
		$key = md5("pingeban");
		try{
			$jwtArr = explode(" ",$jwt);
			$jwt = $jwtArr[1];
			//$jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJpc3MiOiJodHRwOlwvXC9iZC5waW5nZWJhbi5jbiIsImF1ZCI6Imh0dHA6XC9cL2JkLnBpbmdlYmFuLmNuIiwiaWF0IjoxNTc3MDcxMzQ2LCJuYmYiOjE1NzcwNzEzNDYsImV4cCI6MTU3NzA4NTc0Nn0.lGaID1I1NlTJJtDDQLiOJz85OwIqOUcgygwc24ULePE";
			$jwtAuth = json_encode(JWT::decode($jwt,$key,array('HS256')));
			$authInfo = json_decode($jwtAuth,true);
			$msg = [];
			if(!empty($authInfo['user_id'])){
				$msg = [
					'status'=> 1001,
					'msg'=> 'Token验证通过',
					'user_id'=>$authInfo['user_id']
				];
			}else{
				$msg = [
					'status'=>1002,
					'msg'=>'Token验证不通过,用户不存在'
				];
			}
			return $msg;
		} catch (\Firebase\JWT\SignatureInvalidException $e) {
			echo json_encode([
                'status' => 1002,
                'msg' => 'Token无效'
            ],JSON_UNESCAPED_UNICODE);
            exit;
		} catch (\Firebase\JWT\ExpiredException $e) {
            echo json_encode([
                'status' => 1003,
                'msg' => 'Token过期'
            ],JSON_UNESCAPED_UNICODE);
            exit;
        } catch (Exception $e) {
            return $e;
        }
	}
}
