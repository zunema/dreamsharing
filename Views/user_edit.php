<?php

require_once(ROOT_PATH . "Controllers/Controller.php");

if (!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$edit = new DreamsharingController();
$params = $edit->edit_control();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>アカウント編集</title>
</head>

<body>
<?php include('login_header.php');?>
  <div class="container">

    <div class="row pt-5">
      <div class="col-3 offset-2">
        <h4>アカウント編集</h4>
      </div>
      <div class="col-3">
        <a href="mypage.php?id=<?= $params["userDate"]["id"] ?>" class="col-12">マイページへ戻る</a>
      </div>
    </div>

    <form action="user_edit.php?id=<?= $params["userDate"]['id'] ?>" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= htmlspecialchars($params["userDate"]["id"] ?? ""); ?>"><br>
      <div class="row mt-3">
        <div class="col-7 offset-2">
          <label>プロフィール画像：</label>
          <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
          <input name="image" id="selectImage" type="file" accept="image/*" />
          <script>
          var elm = document.getElementById("selectImage");
          elm.onchange = function(evt){
            var selectFiles = evt.target.files;
            if(selectFiles.length != 0) {
              var fr = new FileReader();
              fr.readAsDataURL(selectFiles[0]);
              fr.onload = function(evt) {
                document.getElementById('boxImage').innerHTML = '<img src="' + fr.result + '" alt="" style="min-width:250px;min-height:250px;max-width:250px;max-height:250px;border:1px solid #666;">'; //readAsDataURLで得た結果を、srcに入れたimg要素を生成して挿入
              }
            }
          }
          </script>
        </div>

      </div>

      <div class="row">
        <div class="col-2 offset-4 mt-3" id='boxImage'></div>
      </div>

      <div class="row mt-3">
        <div class="col-7 offset-2">
          <label class="mt-1" for="name">名　前：</label>
          <?php if (isset($params["err"]["name"]) && $params["err"]["name"] === "blank") : ?>
            <p class="err" style="color:red">名前を入力して下さい。</p>
          <?php endif; ?>
          <input type="text" name="name" id="name" class="form-control mb-4" value="<?php echo htmlspecialchars($params["userDate"]["name"]); ?>">
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-7 offset-2">
          <label class="mt-1" for="name">メールアドレス：</label>
          <?php if (isset($params["err"]["email"]) && $params["err"]["email"] === "blank") : ?>
            <p class="err" style="color:red">メールアドレスを入力して下さい。</p>
          <?php endif; ?>
          <input type="email" name="email" id="email" class="form-control mb-4" value="<?php echo htmlspecialchars($params["userDate"]["email"]); ?>">
        </div>
      </div>

      <div class="row mt-3 user-edit-footer">
        <div class="col-2 offset-2">
          <button type="submit" class="btn btn-outline-info" onclick='return confirm("編集しますか？");'>編集する</button>
        </div>
    </form>

      <form action="withdrawal.php?id=<?= $params["userDate"]['id'] ?>" method="POST">
        <div class="col-3 offset-2">
          <button type="submit" class="btn btn-outline-danger" onclick='return confirm("本当に退会しますか？");'>退会する</button>
        </div>
      </form>
    </div>
  </div>
  <?php include('footer.php');?>

</body>

</html>