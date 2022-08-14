<?php
  require_once(__DIR__."/../classes/Dao.php");
  require_once(__DIR__."/../classes/constants.php");

  session_start();
  //セッションIDがセットされていなかったらログインページに戻る
  if(! isset($_SESSION['login'])){
    $response = array(
      "s_result"=>false
    );
    //echo json_encode($response);
    //exit;
  }

  try{
		//ログインしているユーザーのユーザー情報を取得
		$user_sql = 'select * from users  where user_id = ?';
		$user = Dao::db()->show_one_row($user_sql,array($_SESSION['login']));
		//ユーザーID
		$memberid = $user['data']['id'];
		//テキストボックスで入力した新規動物情報をデータベースに登録
		$insert_sql = 'insert into animal(name,family,features,date,memberid) values(?,?,?,?,?)';
		$insert_id = Dao::db()->add_one_row($insert_sql,array($_REQUEST['animal_name'],$_REQUEST['animal_family'],$_REQUEST['animal_features'],$_REQUEST['animal_date'],$memberid));
		//アップロードされたファイルを一時フォルダから指定のフォルダへファイル名「（insert_id）_animal.jpg」にして移動
		move_uploaded_file($_FILES['fileupload']['tmp_name'] , Constants::ANIMAL_PHOTO_SERVER.$insert_id['id'].'_animal.jpg' );

    if($insert_id["result"] == true){
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
