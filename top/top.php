<?php
		require_once(__DIR__."/../classes/Dao.php");
		require_once(__DIR__."/../classes/constants.php");
		session_start();
		//ログアウトボタン押下後、セッションIDを削除する
		if( !empty($_GET['btn_logout']) ) {
			unset($_SESSION['login']);
		}

		//セッションIDがセットされていなかったらログインページに戻る
		if(! isset($_SESSION['login'])){
			header("Location:".Constants::LOGIN_URL);
			exit();
		}
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<!-- Required meta tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="./top.css">
		<title>TOP</title>
	</head>
	<body>
		<div class="container-fluid">
		<div class="row mb-2">
		<!-- ナビゲーションバー -->
		<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
		  <!-- タイトル -->
		  <a class="navbar-brand" href="#">
				<img src="../image/KnownAnimalLogo.png" width="180" height="auto" class="d-inline-block align-top" alt="">
			</a>
		  <!-- ハンバーガーメニュー -->
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <!-- ナビゲーションメニュー -->
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav">
		      <li class="nav-item active">
		        <a class="nav-link" href="<?php echo Constants::ENTRY_URL?>">新規登録</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href='<?php echo Constants::USER_EDIT_URL?>'>ユーザー情報の編集</a>
		      </li>
		      <li class="nav-item">
						<form name="logout" method="get" action="">
							<a class="nav-link" id="logout" href='#'>ログアウト</a>
							<input type="hidden" id="hidden" name="btn_logout" value="ログアウト">
						 </form>
						 <script>
						  var a_link = document.getElementById("logout");

						  a_link.addEventListener('click', function() {
						    //submit()でフォームの内容を送信
						    document.logout.submit();
						  })
							console.dir(document.getElementById("hidden"));
						</script>

		      </li>
		    </ul>
		  </div>
		</nav>
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
 		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script type="module">
			import { WebApi,LoadingCircle,Modal } from "../js/common.js";
			const top = (() => {
				async function apiCallTest(){
    			const result = await new WebApi({}).call("/~testaki/known_animal_SPA/top/test_user.php","GET");
    			let response = JSON.parse(result);
					console.log(response);
					if(response.s_result == false){
						window.location.href = '/~testaki/known_animal_SPA/login/login.php';
					}
				}
				function _startup(){
					window.onload = function(){
						apiCallTest();
					}

				}
				return {startup:_startup}
			})();
			top.startup();
		</script>
		<div class="row mt-5 mb-2">
			<br>
			<p class="account">
			</p>
		</div>
		<div class="row">
			<?php echo $_REQUEST["update_message"] ?>
		</div>
			<div class="card-group">
				<div class="row">
					<?php for($i = 0;$i < $count; $i++): ?>
  				<div class="col-sm-3">
						<div class="card">

						</div>
					</div>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</body>
</html>
