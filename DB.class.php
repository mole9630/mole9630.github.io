<?php
	class DB{
		
		public $links_name;
		
		function __construct(){
			$db_host = 'localhost'; //数据库地址
			$db_user = 'wqsbeta';  //数据库账号
			$db_pwd = 'password';  //数据库密码
			$db_name = 'wqsbeta';  //数据库名
			$this->links_name = new mysqli($db_host,$db_user,$db_pwd,$db_name);
			if(mysqli_connect_errno()){
				echo mysqli_connect_error();
				exit();
			}
			$this->links_name->set_charset('utf8');
		}
		
		function _query($_sql){
			return $this->links_name->query($_sql);
		}

		function __destruct(){
			$this->links_name->close();
		}
	}

?>