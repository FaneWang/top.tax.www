<?php

class User{
	private $id;
    private $dept;
    private $name;
    private $account;
    private $password;
    private $headImg;
    private $gender;
    private $state;
    private $mobile;
    private $email;
    private $birthday;
    private $memo;


    /*
        php的魔术方法，类似java的getter、setter方法，不同点在于写法更简便，同时并不直接调用方法，
        而是直接访问私有变量，访问时会自动调用__get、__set 方法。
    */
    public function __set($vname,$value){
        // echo '为私有化成员变量赋值的时候，调用了__set方法';
        $this->$vname = $value;
    }

    public function __get($vname){
        // echo '在获取私有变量成员的时候，调用了__get方法';

        if (isset($this->$vname)) {
            return $this->$vname;
        }else{
            return null;
        }
    }
}