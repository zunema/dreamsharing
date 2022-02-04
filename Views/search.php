<?php

require_once(ROOT_PATH."Controllers/Controller.php");


if(!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_POST) === true) {
  $_SESSION["searchAll"] = $_POST;
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$search = new DreamsharingController();
$params = $search->search($_SESSION["searchAll"]);
$today = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>検索画面</title>
</head>

<body>
<?php include('login_header.php');?>
  <div class="container">

    <div class="row pt-5">
      <div class="col-12">
        <form action="search.php" method="post">
          <table class="index-search">
            <tr>
              <th><label class="mt-1" for="search_name">検索内容：</label></th>
              <th class="search-item"><label class="mt-1" for="emotion">感情：</label></th>
              <th class="search-item"><label class="mt-1">検索したい期間：</th>
              <th class="search-item"></th>
              <th class="search-item"></th>
            </tr>
            <tr>
              <td><input type="text" name="search_name" class="form-control" placeholder="例）楽しい夢"></td>
              <td class="search-item">
                <select name="emotion" class="form-control">
                <option value ="0">選択しない</option>
                <?php foreach($params["emotionDate"] as $emotion):?>
                <option value ="<?= $emotion["id"]?>"><?= $emotion["emotion"] ?></option>
                <?php endforeach;?>
                </select>
              </td>
              <td class="search-item"><input type="date" name="date_start" class="form-control"></td>
              <td class="search-item"><input type="date" name="date_end" class="form-control" value="<?=$today?>"></td>
              <td class="search-item"><button type="submit" name="submit" class="btn btn-outline-secondary">送信</button></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <div class="row mt-3 mb-3">
      <div class="col-12 text-center">
        <h4>- 検索結果 -</h4>
        <?php if($params["pages"] === 0): ?>
          <p class="mt-5">検索内容に一致する投稿はありませんでした。</p>
        <?php endif; ?>
        <p></p>
      </div>
    </div>

    <div class="row pb-5">
      <?php foreach($params["searchAll"] as $post):?>
        <div class="col-md-5 index-item">
          <label>ユーザ名：<a href="mypage.php?id=<?=$post["user_id"] ?>"><?=htmlspecialchars($post["name"],ENT_QUOTES,"UTF-8");?></a></label><br>
          <label>タイトル：<?=htmlspecialchars($post["title"],ENT_QUOTES,"UTF-8");?></label><br>
          <label>感情　　：<?=htmlspecialchars($post["emotion"],ENT_QUOTES,"UTF-8");?></label><br>
          <label>見た日　：<?=htmlspecialchars($post["date"],ENT_QUOTES,"UTF-8");?></label><br>
          <?php $like = $search->likes($post["id"]); ?>
          <p>いいね！：<?= $like["count(post_id)"]; ?> 件　　　　　<a href="detail.php?id=<?=$post["id"] ?>">詳細はこちら、、、</a>
        </div>
      <?php endforeach;?>
    </div>

    <div class="row text-center page-item">
      <div class="col-md-12 pt-1">
        <?php
        for($i=0;$i<=$params['pages'];$i++) {
          if(isset($_GET['page']) && $_GET['page'] == $i) {
            echo $i+1;
          } else {
            echo "<a href = '?page=".$i."'> ".($i+1)."</a>";
          }
        }
        ?>
      </div>
    </div>

  </div>
  <?php include('footer.php');?>

</body>

</html>