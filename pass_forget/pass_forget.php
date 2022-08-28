<?php
  require_once(__DIR__."/../classes/Dao.php");
  require_once(__DIR__."/../classes/constants.php");
	/**
	*グローバル変数定義
	*/
	$number = "";

  try{
		$select_sql = 'select * from users where mail = ?';
		$used_mail = Dao::db()->show_one_row($select_sql,array($_REQUEST['mail_set']));

    if($used_mail["result"] == false){
			$response = array(
				"result"=>mail_false
			);
			echo json_encode($response);
		}else{
			pass_issuance();
			$result = send_mail();
			if($result == true) {
				$response = array(
					"result"=>true
				);
				echo json_encode($response);
			}else{
				$response = array(
					"result"=>false
				);
				echo json_encode($response);
			}
		}
	}catch(PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
	/*
	*メール送信処理
	*/
	function send_mail(){
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		$to = $_REQUEST['mail_set'];
		$title = '仮パスワード発行のお知らせ';
		$message = 'known_animalシステムからのお知らせです。'.PHP_EOL
		.'仮パスワードを発行しました。'.PHP_EOL
		.'仮パスワードは下記の通りです。'.PHP_EOL
		.'仮パスワード：'.$GLOBALS['number'];
		$headers = "From: known_animal@test.com";

		if(mb_send_mail($to, $title, $message, $headers)){
			return true;
		}else{
			return false;
		}
	}
	/*
	*仮パスワード発行処理
	*/
	function pass_issuance(){
		$ar01 = array(0,1,2,3,4,5,6,7,8,9);
		$ar02 = array(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z);
		$ar03 = array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
		$ar04 = array(0,1,2);
		for($i = 0; $i <= 1; $i++){
			$key_[0] = $ar01[array_rand($ar01)];
			$key_[1] = $ar02[array_rand($ar02)];
			$key_[2] = $ar03[array_rand($ar03)];
			shuffle($ar04);
			$GLOBALS['number'] =$GLOBALS['number']. $key_[$ar04[0]] . $key_[$ar04[1]] . $key_[$ar04[2]].$key_[rand(0,2)];
		}
		//上記で発行したパスワードをデータベース上に更新登録
		$update_sql = "update users set password = ? where mail = ?";
		$hash = password_hash($GLOBALS['number'], PASSWORD_DEFAULT);
		Dao::db()->mod_exec($update_sql,array($hash,$_REQUEST['mail_set']));
	}

?>
