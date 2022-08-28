<?php
  require_once(__DIR__."/../classes/Dao.php");
  require_once(__DIR__."/../classes/constants.php");

  session_start();
  //セッションIDがセットされていなかったらログインページに戻る
  if(! isset($_SESSION['login'])){
    $response = array(
      "s_result"=>false
    );
  }

  try{
		//ログインユーザーの情報を抽出
		$select_sql = "select * from users where user_id = ?";
		$user = Dao::db()->show_one_row($select_sql,array($_SESSION['login']));
		//パスワード
		$pass = $user['data']['password'];
		if(password_verify($_REQUEST['old_pass'], $pass) == false){
			$response = array(
				"result"=>old_pass_false
			);
			echo json_encode($response);
			exit;
		}
		//新しいパスワードが$patternの正規表現パターンにマッチしているか判定
		$pattern = '/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/';
		preg_match($pattern,$_REQUEST['user_up'],$matches);
		if($matches == false){
			$response = array(
				"result"=>pass_pattern_false
			);
			echo json_encode($response);
			exit;
		}

		$update_sql = "update users set password = ? where user_id = ?";
		//新しいパスワードをハッシュ化してデータベースに更新登録
		$hash = password_hash($_REQUEST['user_up'], PASSWORD_DEFAULT);
		$pass_change = Dao::db()->mod_exec($update_sql,array($hash,$_SESSION['login']));

		if($pass_change["result"] == true){
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

	}catch(PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
?>
