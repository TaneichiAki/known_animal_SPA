<?php
	require_once(__DIR__."/../classes/Logger.php");
	require_once(__DIR__."/../classes/Dao.php");
	require_once(__DIR__."/../classes/constants.php");
	require_once(__DIR__."/../classes/knownAnimalBase.php");

	$logger = new Logger(Constants::LOGPATH);

	$GLOBALS['logger']->loggerInfo(__FILE__.":".__LINE__);

	//セッション処理開始
	session_start();
	/*
	*メッセージ
	*/
	$msg = "";
	/*
	*メッセージ出力ファンクション
	*/
	function getMsg($name,$password){
		if($name == ""){
			return "ユーザーIDを入力してください。";
		}elseif($password == ""){
			return "パスワードを入力してください。";
		}else{
			return "";
		}
	}

	//リクエストメソッドが「POST」（ログインボタン押下後）ならば
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$msg = getMsg($_REQUEST['username'],$_REQUEST['password']);
		//メッセージが空ならば
		if($msg == ""){
			try{
				//データベースに接続し、ユーザーIDが一致するものを抽出
				$sql = "select * from users where user_id = ?";
				$user = Dao::db()->show_one_row($sql,array($_REQUEST['username']));

				//$userに値が入っていて、かつ　パスワードがデータベース内で指定したユーザー名のものと一致したら
				if($user['result'] && password_verify($_REQUEST['password'], $user['data']['password']) == true) {
					//セッションIDを再生成し
					session_regenerate_id(TRUE);
					$_SESSION['login'] = $_REQUEST['username'];
					//TOPページに遷移
					header ('Location:'.Constants::TOP_URL);
					exit;
				//IDとパスワードの照合がとれなければ
				}else{
					$msg = "IDまたはパスワードが違います。";
				}

			//例外バグ検出時に下記を実行（外部のアプリと連携するときによく使う）
			}catch (PDOException $e) {
				print('Error:'.$e->getMessage());
				die();
			}
		}
	}

?>
<link rel="stylesheet" href="login.css" type="text/css">
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../css/common.css">
		<title>ログイン</title>
	</head>
	<body>
		<section id="pass_resetting_modal" class="__modal__area hidden">
			<div id="modal_bg" class="__modal__bg"></div>
			<div class="__modal__wrapper">
				<div class="__modal__contents">
					<div class="row">
						<div id="modal_title" class="col-12 p-2 text-center">
							<h5>パスワード再設定</h5>
						</div>
								<div class="col-12 mt-3 p-2">
									<p>known_animalシステムアカウントに関連づけられているEメールアドレスを入力してください。</p>
								</div>
								<form method="post" id="mailForm">
									<div class="col-12 mt-3 p-2">
										<label class="form-label mb-2" id="mail_set" for="mail_input" class="control-label">メールアドレス:</label>
										<input type="mail" class="form-control" id="mail_input" name="mail_set" placeholder="メールアドレス">
									</div>
								</form>
							<div class="__modal__buttons">
								<button id="close" class="__modal__button __modal__close__btn">閉じる</botton>
								<button id="pass_resetting" class="__modal__button __modal__exec__btn">パスワードを再設定</botton>
							</div>
					</div>
				</div>
			</div>
		</section>

		<div class="container-fluid">
			<div class="row">
				<form class="border offset-1 col-10 offset-md-4 col-md-4 rounded bg-light mt-5" method="post">
					<div class="row">
						<img class="offset-3 col-6 text-center mt-5 img-fluid" src="../image/KnownAnimalLogo.png">
					</div>
					<div class="row">
						<div class="offset-2 col-8 text-center mt-3">
							<?php
								if ($msg != ""){
									echo "<center><div>".$msg."</div></center>";
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="offset-2 col-8 text-center mt-3">
									<input type="id" class="form-control mb-0" name="username" placeholder="ユーザーID">
						</div>
					</div>
					<div class="row">
						<div class="offset-2 col-8 text-center">
									<input type="password" class="form-control mt-0" name="password" placeholder="Password">
						</div>
					</div>
					<div class="row">
						<div class="offset-2 col-8 text-center">
							<button class="btn btn-primary btn-sm mt-2 mb-3" type="submit">ログイン</button>
						</div>
					</div>
					<div class="row">
						<div class="offset-2 col-8 text-center mb-3">
							<a id="pass_forget" class="link-primary">パスワードを忘れた方はこちら</a>
						</div>
					</div>
					<div class="row">
						<div class="offset-2 col-8 text-center">
							<div>初めてご利用の方はこちら</div>
						</div>
					</div>
					<div class="row">
						<div class="offset-2 col-8 text-center mb-5">
							<button class="btn btn-primary btn-sm" type="button" onclick="location.href='<?php echo Constants::NEW_ACCOUNT_URL?>'">新規アカウントを作成</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<script type="module">
			import { WebApi,LoadingCircle,Modal } from "../js/common.js";

			let mail_input = document.getElementById("mail_input");
			//入力チェック
			function input_check() {
				let msg = "";
				if(mail_input.value == "") {
					msg = "メールアドレスを入力してください。";
				}
				return msg;
			}
			//パスワード再設定ファンクション
			async function pass_reset() {
				let msg = input_check();
				if(msg != "") {
					alert(msg);
				}else{
					const url = '../pass_forget/pass_forget.php';
					const method = 'POST';
					const formdata = new FormData(document.getElementById("mailForm"));
					const result = await new WebApi({}).call(url,method,formdata);
					let response = JSON.parse(result);
					console.log(response);
					if(response.result === "mail_false") {
						alert("入力したアドレスは登録がありません");
					}else if(response.result === true) {
						alert("入力したメールアドレスに仮パスワード発行のメールを送りました。\nメールの受信をご確認ください。");
						setTimeout(function(){
						window.location.href='<?php echo Constants::LOGIN_URL?>';
					}, 1*1000);
					}else{
						alert("メール送信失敗です。");
					}
				}
			}

			//イベントファンクション
			function bind() {
				let pass_forget = document.getElementById("pass_forget");
				let close = document.getElementById("close");
				let modal_bg = document.getElementById("modal_bg");
				let pass_reset_mdl = document.getElementById("pass_resetting_modal");
				let pass_reset_btn = document.getElementById("pass_resetting")

				pass_forget.addEventListener('click', () => {
					pass_reset_mdl.classList.remove("hidden");
				})
				close.addEventListener('click', () => {
					pass_reset_mdl.classList.add("hidden");
				},false);

				modal_bg.addEventListener('click', () => {
					pass_reset_mdl.classList.add("hidden");
				},false);

				pass_reset_btn.addEventListener('click', () => {
					pass_reset();
				},false);
			}

			bind();
		</script>
	</body>
</html>
