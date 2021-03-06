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
		<link rel="stylesheet" type="text/css" href="../css/common.css">
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
		        <a class="nav-link" id="entry" href="<?php echo Constants::ENTRY_URL?>">新規登録</a>
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

		<div class="row mt-5 mb-2">
			<br>
			<p class="account">
			</p>
		</div>
			<div class="card-group">
				<div class="row" id="roop">

				</div>
			</div>
		</div>
		<script type="module">
			import { WebApi,LoadingCircle,Modal } from "../js/common.js";
			const lc = new LoadingCircle({});

			const top = (() => {
				async function user_get(){
					try{
						const result = await new WebApi({}).call("/~testaki/known_animal_SPA/top/user_db.php","GET");

						let response = JSON.parse(result);
						if(response.result == true){
							let user_name = document.getElementsByClassName('account');
							user_name[0].textContent = 'ようこそ！'+ response.user.firstname + 'さん';
						}else{
							window.location.href = '/~testaki/known_animal_SPA/login/login.php';
						}
					}catch(e){
							let err = e;
							console.log(err.message);
					}
				}

				async function animal_get(){
					const result = await new WebApi({}).call("/~testaki/known_animal_SPA/top/animal_db.php","GET");
					console.log(result);
					let response = JSON.parse(result);
					console.log(response.result);
					if(response.result == true){
						console.log(response[0].length);
						let animal_count = response[0].length;

						let roop = document.getElementById('roop');
						for(let i=0; i<animal_count; i++){
							let newElement = document.createElement("div"); // div要素作成
							newElement.classList.add('col-sm-3');//クラス属性追加
	  					roop.appendChild(newElement);

							let newElement2 = document.createElement("div"); // div要素作成
							newElement2.classList.add('card');//クラス属性追加
							newElement.appendChild(newElement2);

							let newElement_img = document.createElement("img");
							const call_img = await new WebApi({}).call("/~testaki/known_animal_SPA/top/animal_image_db.php?imgNo="+response[0][i].no,"GET");
							console.log(call_img);
							console.log(5);
							let response_img = JSON.parse(call_img);
							let judgement = response_img.result;

							if(judgement == true){
								newElement_img.setAttribute("src","/~testaki/animal_photo/" + response[0][i].no +"_animal.jpg");
							}else{
								newElement_img.setAttribute("src","/~testaki/animal_photo/no_image.jpeg");
							}
							newElement_img.classList.add('card-img-top');
							newElement_img.setAttribute("height",220);
							newElement_img.setAttribute("width","auto");
							newElement2.appendChild(newElement_img);

							let newElement3 = document.createElement("div"); // div要素作成
							newElement3.classList.add('card-body');//クラス属性追加
							newElement2.appendChild(newElement3);

							let newElement4 = document.createElement("h5"); // div要素作成
							newElement4.classList.add('card-title');//クラス属性追加
							newElement4.textContent = response[0][i].name;
							newElement3.appendChild(newElement4);

							let newElement_p = document.createElement("p"); // div要素作成
							newElement_p.textContent = "科：" + response[0][i].family;
							newElement3.appendChild(newElement_p);

							let newElement_p2 = document.createElement("p"); // div要素作成
							newElement_p2.textContent = "特徴：" + response[0][i].features;
							newElement3.appendChild(newElement_p2);

							let newElement_p3 = document.createElement("p"); // div要素作成
							newElement_p3.textContent = "知った日：" + response[0][i].date;
							newElement3.appendChild(newElement_p3);

							let newElement_bt_e = document.createElement("button"); // div要素作成
							newElement_bt_e.textContent = "更新";
							newElement_bt_e.classList.add("btn","btn-primary");//クラス属性追加
							newElement_bt_e.setAttribute("type","submit");
							newElement_bt_e.setAttribute("onclick","location.href='/~testaki/known_animal_SPA/animal_edit/edit.php?update_animal="+ response[0][i].no +"'");
							newElement3.appendChild(newElement_bt_e);

							let newElement_bt_d = document.createElement("button"); // div要素作成
							newElement_bt_d.textContent = "削除";
							newElement_bt_d.classList.add("btn","btn-primary");//クラス属性追加
							newElement_bt_d.setAttribute("type","submit");
							newElement_bt_d.setAttribute("onclick","window.open('/~testaki/known_animal_SPA/delete/delete.php?delete_animal="+ response[0][i].no +"','Delete','width=800,height=600')");
							newElement3.appendChild(newElement_bt_d);
						}

						//let animal_d = document.getElementById('card');
						//let new_element1 = document.createElement('div');
						//new_element1.classList.add('card-body');
						//animal_d.after(new_element1);
						//let new_element2 = document.createElement('h5');
						//new_element2.classList.add('card-title');
						//new_element1.after(new_element2);
						//new_element2.textContent = response[0][0].name;
						//console.log(22);
						//user_name[0].textContent = 'ようこそ！'+ response.user.firstname + 'さん';
					}else{
						alert('まだ動物データは登録されていません');
					}
				}


				function _startup(){
					window.onload = function(){

						lc.show();
						user_get();
						animal_get();
						let btn = document.getElementById('entry');
						btn.addEventListener('click', function() {
							alert('クリックされました！');
						}, false);
						lc.hide();


					}

				}
				return {startup:_startup}
			})();
			top.startup();

		</script>
	</body>
</html>
