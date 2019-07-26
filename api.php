<?php
	/*
	WQS网络验证，如不会使用请联系我，请勿用记事本打开此文件！编码:utf-8
	 */
	header("content-Type: text/html; charset=utf-8");
	include 'DB.class.php';
	date_default_timezone_set("PRC");
	$_softkey = 'feb0d75ba7pbzxn82cjx46lvtytypned';
	if($_GET['type'] === "register"){
		if($_POST['softkey'] === $_softkey && $_POST['username'] != "" && $_POST['password'] != "" && $_POST['QQ'] != "" && $_POST['softname'] != ""){
			$_mysql = new DB();
			$_username = $_POST['username'];
			$_password = $_POST['password'];
			$_QQ = $_POST['QQ'];
			$_softname = $_POST['softname'];
			$_addtime = date("Y-m-d H:i:s");
			$_attime = date("Y-m-d H:i:s");
			$_sel_sql = $_mysql->_query("select * from `user` where username='$_username' and softname='$_softname'");
			$_sel_num = $_sel_sql->num_rows;
			if ($_sel_num > 0){
				echo "用户名已存在";
				exit();
			}
			if($_mysql->_query("insert into user(id,username,password,QQ,softname,addtime,attime) values (null,'$_username','$_password',$_QQ,'$_softname','$_addtime','$_attime')")){
				echo "注册成功！";
			}else{
				echo "注册失败！";
			}

		}else{
			echo "未知的错误！";
		}
	}
	if($_GET['type'] === 'land'){
		if($_POST['softkey'] === $_softkey && $_POST['username'] != "" && $_POST['password'] != "" && $_POST['softname'] != ""){
			$_mysql = new DB();
			$_username = $_POST['username'];
			$_password = $_POST['password'];
			$_softname = $_POST['softname'];
			$_dqtime = date("Y-m-d H:i:s");
			$_sel_sql = $_mysql->_query("select * from `user` where username='$_username' and softname='$_softname'");
			$_sel_num = $_sel_sql->num_rows;
			if($_sel_num >0){
				$_sel_sql1 = $_mysql->_query("select * from `user` where username='$_username' and password='$_password' and softname='$_softname'");
				$_sel_num1 = $_sel_sql1->num_rows;
				if($_sel_num1 > 0){
					$_sel_sql2 = $_mysql->_query("select attime from user where username='$_username' and softname='$_softname'");
					$_sel_time = $_sel_sql2->fetch_row();
					if($_sel_time['0'] > $_dqtime){
						echo "登陆成功，到期时间：".$_sel_time['0'];
					}else{
						echo "账号已到期！";
					}
				}else{
					echo "密码错误！";
				}
			}else{
				echo "账号不存在!";
			}
		}
	}
	if($_GET['type'] === 'recharge'){
		if($_POST['softkey'] === $_softkey && $_POST['username'] !="" && $_POST['password'] !="" && $_POST['softname'] !="" && $_POST['rcgka'] != ""){
			$_mysql = new DB();
			$_username = $_POST['username'];
			$_password = $_POST['password'];
			$_softname = $_POST['softname'];
			$_rcgka = $_POST['rcgka'];
			$_sel_sql = $_mysql->_query("select * from `user` where username='$_username' and softname='$_softname'");
			$_sel_num = $_sel_sql->num_rows;
			if($_sel_num >0){
				$_sel_sql1 = $_mysql->_query("select * from `user` where username='$_username' and password='$_password' and softname='$_softname'");
				$_sel_num1 = $_sel_sql1->num_rows;
				if($_sel_num1 >0){
					$_sel_sql2 = $_mysql->_query("select * from `recharge` where rcgkey='$_rcgka' and softname='$_softname'");
					$_sel_num2 = $_sel_sql2->num_rows;
					if($_sel_num2 > 0){
						$_sel_sql3 = $_mysql->_query("select type from recharge where rcgkey='$_rcgka' and softname='$_softname'");
						$_sel_type = $_sel_sql3->fetch_row();
						if($_sel_type['0'] === '0'){
							$_dqtime = date("Y-m-d H:i:s");
							$_sel_sql4 = $_mysql->_query("select attime from user where username='$_username' and softname='$_softname'");
							$_attime = $_sel_sql4->fetch_row();
							if($_dqtime > $_attime['0']){
								$_sel_sql5 = $_mysql->_query("select time from recharge where rcgkey='$_rcgka' and softname='$_softname'");
								$_sel_time = $_sel_sql5->fetch_row();
								if($_sel_time['0'] === '1'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_dqtime.' +1 day'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}elseif($_sel_time['0'] === '7'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_dqtime.' +7 day'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}elseif($_sel_time['0'] === '30'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_dqtime.' +1 month'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}elseif($_sel_time['0'] === '365'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_dqtime.' +1 year'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}else{
									echo "未知的充值卡信息！";
								}
							}else{
								$_sel_sql5 = $_mysql->_query("select time from recharge where rcgkey='$_rcgka' and softname='$_softname'");
								$_sel_time = $_sel_sql5->fetch_row();
								if($_sel_time['0'] === '1'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_attime['0'].' +1 day'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}elseif($_sel_time['0'] === '7'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_attime['0'].' +7 day'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}elseif($_sel_time['0'] === '30'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_attime['0'].' +1 month'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}elseif($_sel_time['0'] === '365'){
									$dq_time = date("Y-m-d H:i:s", strtotime($_attime['0'].' +1 year'));
									if($_mysql->_query("update user set attime = '$dq_time' where username='$_username' and softname='$_softname'") && $_mysql->_query("update recharge set type = 1 where rcgkey='$_rcgka' and softname='$_softname'")){
										echo "充值成功，到期时间:".$dq_time;
									}else{
										echo "充值失败！";
									}
								}else{
									echo "未知的充值卡信息！";
								}
							}

						}else{
							echo "充值卡已使用！";
						}
					}else{
						echo "卡号不存在！";
					}
				}else{
					echo "密码错误！";
				}
			}else{
				echo "账号不存在！";
			}
		}
	}
	if($_GET['type'] === 'rcgka'){
		if($_POST['adminuser'] != "" && $_POST['adminpwd'] != "" && $_POST['softname'] && $_POST['num'] != "" && $_POST['time'] !=""){
			$_mysql = new DB();
			$_adminuser = $_POST['adminuser'];
			$_adminpwd = $_POST['adminpwd'];
			$_softname = $_POST['softname'];
			$_num = $_POST['num'];
			$_time = $_POST['time'];
			$_sel_sql = $_mysql->_query("select * from `admin` where adminuser='$_adminuser' and adminpwd='$_adminpwd'");
			$_sel_num = $_sel_sql->num_rows;
			if($_sel_num >0){
				for($i=0;$i<$_num;$i++){
					$_rcgka = "WQS".randcode(36);
					if($_mysql->_query("insert into recharge(id,rcgkey,time,type,softname) values (null,'$_rcgka',$_time,0,'$_softname')")){
						echo $_rcgka."|";
					}else{
						echo "生成充值卡失败！";
					}
				}
			}else{
				echo "管理员账号或密码错误！";
			}
		}
	}
	if($_GET['type'] === 'notice'){
		$_mysql = new DB();
		$_sel_sql = $_mysql->_query("select notice from admin");
		$_sel_notice = $_sel_sql->fetch_row();
		echo $_sel_notice['0'];
	}
	if($_GET['type'] === 'addnotice'){
		if($_POST['adminuser'] != "" && $_POST['adminpwd'] != "" && $_POST['notice'] != ""){
			$_mysql = new DB();
			$_adminuser = $_POST['adminuser'];
			$_adminpwd = $_POST['adminpwd'];
			$_notice = $_POST['notice'];
			if($_mysql->_query("update admin set notice = '$_notice' where adminuser='$_adminuser' and adminpwd='$_adminpwd'")){
				echo "公告修改成功";
			}else{
				echo "公告修改失败！";
			}
		}
	}
	function randcode($num){
		for($i=0;$i<$num;$i++){
			$code .= chr(rand(97,122)); 
		}
		return $code;
	}
	?>
