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

<?php
	require_once(__DIR__."/../classes/Dao.php");
	require_once(__DIR__."/../classes/constants.php");
	/**
	*グローバル変数定義
	*/
	$msg = "";
	$id = "";
	/**
	*パスワード更新処理
	*/
	function pass_update(){
		$update_sql = "update users set password = ? where user_id = '".$GLOBALS['id']."'";
		//新しいパスワードをハッシュ化してデータベースに更新登録
		$hash = password_hash($_REQUEST['new_pass'], PASSWORD_DEFAULT);
		Dao::db()->mod_exec($update_sql,array($hash));
	}
	/**
	*POST時処理
	*/
	function post(){
		if($_REQUEST['current_pass'] == ""){
			return "現在のパスワードを入力してください。";
		}
		if($_REQUEST['new_pass'] == ""){
			return  "新しいパスワードを入力してください。";
		}
		if($_REQUEST['re_new_pass'] == ""){
			return "新しいパスワードを再度入力してください。";
		}
		//ユーザーID
		$GLOBALS['id']= $_SESSION['login'];
		//ログインユーザーの情報を抽出
		$select_sql = "select * from users where user_id = ?";
		$user = Dao::db()->show_one_row($select_sql,array($GLOBALS['id']));
		//パスワード
		$pass = $user['data']['password'];
		if(password_verify($_REQUEST['current_pass'], $pass) == false){
			return "現在のパスワードが正しくありません。";
		}
		if($_REQUEST['new_pass'] != $_REQUEST['re_new_pass'] ){
			return "１回目と２回目で新しいパスワードが一致しません。";
		}
		//新しいパスワードが$patternの正規表現パターンにマッチしているか判定
		$pattern = '/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/';
		preg_match($pattern,$_REQUEST['new_pass'],$matches);
		if($matches == false){
			return "半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上のパスワードにしてください。";
		}
		pass_update();
		//下記ページに遷移する
		header ('Location:'.Constants::PASS_CHANGE_DONE_URL);
		exit;
	}
	/**
	*メイン処理
	*/
	function main() {
		session_start();
		//セッションIDがセットされていなかったらログインページに戻る
		if(! isset($_SESSION['login'])){
			header("Location:".Constants::LOGIN_URL);
			exit();
		}
		try{
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$GLOBALS['msg'] = post();
			}
		}catch(PDOException $e) {
			print('Error:'.$e->getMessage());
			die();
		}
	}
	/**
	*メイン処理実行
	*/
	main();
?>
