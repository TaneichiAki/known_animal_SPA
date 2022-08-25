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
    $user_info = $_REQUEST['update_info'];
		$update_sql = 'update users set '.$user_info.' = ? where user_id = ?';
		$user = Dao::db()->mod_exec($update_sql,array($_REQUEST['user_up'],$_SESSION['login']));

    if($user["result"] == true){
      if($user_info == "mail") {
        $mail_result = send_mail($_REQUEST['user_up']);
        if($mail_result){
          $response = array(
            "result"=>mail_true
          );
          echo json_encode($response);
        }else{
          $response = array(
            "result"=>mail_false
          );
          echo json_encode($response);
        }
      }else{
        $response = array(
          "result"=>true
        );
        echo json_encode($response);
      }
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

  /*
  *メール送信処理
  */
  function send_mail($test){
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    $to = $test;
    $title = 'メールアドレス登録完了のお知らせ';
    $message = 'known_animalシステムからのお知らせです。'.PHP_EOL
    .'メールアドレスの登録が完了いたしました。'.PHP_EOL
    .'■メールアドレスの登録をリクエストされていない場合は本メールを削除してください。'.PHP_EOL
    .'他の方がメールアドレスを間違って入力したため本メールが送信された可能性があります。';

    $headers = "From: known_animal@test.com";

    if(mb_send_mail($to, $title, $message, $headers))
    {
      return true;
    }
    else
    {
      return false;
    }
  }

 ?>
