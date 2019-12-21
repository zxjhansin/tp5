<?php
namespace app\user\controller;

class User
{
    //GET list
    public function index()
    {
		echo "index";
    }
	//POST insert
	public function save(){
		
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
