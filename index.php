<?php
	include 'DB.class.php';
	header("content-Type: text/html; charset=utf-8");
	if(!is_file('wqsoos.txt')){
		$_mysql = new DB();
		if($_mysql->_query("create table admin(id int(11) not null primary key auto_increment,adminuser varchar(255),adminpwd varchar(255),notice varchar(255))") && $_mysql->_query("create table recharge(id int(11) not null primary key auto_increment,rcgkey varchar(255),time int(11),type int(11),softname varchar(255))") && $_mysql->_query("create table user(id int(11) not null primary key auto_increment,username varchar(255),password varchar(255),QQ int(11),softname varchar(255),addtime datetime,attime datetime)")){
			if($_mysql->_query("insert into admin(id,adminuser,adminpwd) values (null,'admin','wqs888')")){
				if(file_put_contents('wqsoos.txt', '如需重新初始化请删除此文件')){
					echo "初始化完成，您的管理员用户名为:admin 密码为:wqs888";
				}else{
					echo "初始化失败！";
				}
			}else{
				echo "初始化失败！";
			}
		}else{
			echo "初始化失败！";
		}
	}else{
		echo "请勿重复初始化！";
	}
?>