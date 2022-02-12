<?php
// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

require_once(ROOT_PATH . "Controllers/Controller.php");

if (!isset($_SERVER["HTTP_REFERER"])) {
  header("location:login.php");
}
if(!empty($_SESSION["login_user"]) === false) {
  header("location:login.php");
}

$UserDate = new DreamsharingController();
$params = $UserDate->user_date();
$postDate = $UserDate->mypage();

$image = $params['userDate']['image'];

// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
  $ym = $_GET['ym'];
} else {
  // 今月の年月を表示
  $ym = date('Y-m');
}

// タイムスタンプを作成し、フォーマットをチェックする
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
  $ym = date('Y-m');
  $timestamp = strtotime($ym . '-01');
}

// 今日の日付 フォーマット　例）2021-06-3
$today = date('Y-m-d');
// カレンダーのタイトルを作成　例）2021年6月
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か　0:日 1:月 2:火 ... 6:土
$youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
$week .= str_repeat('<td></td>', $youbi);

for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

  // 0000-00-00の形式にする
  if($day <= 9){
    $date = $ym . '-' . 0 . $day;
  } else {
    $date = $ym . '-' . $day;
  }

  if ($today == $date) {
      // 今日の日付の場合は、class="today"をつける
      $week .= '<td class="today" style="color: red">' . $day;
  } else {
      $week .= '<td>' . $day;
  }

  // 投稿データの日付とカレンダーの日付が一緒なら投稿タイトルをリンクで表示させる
  foreach($postDate["postDate"] as $post){
    if ($post["date"] == $date){
      $post_id = $post["id"];
      $post_title = $post["title"];
      $week .="<br/>". "<a href='detail.php?id=$post_id'>$post_title</a>";
    }
  }

  $week .= '</td>';

  // 週終わり、または、月終わりの場合
  if ($youbi % 7 == 6 || $day == $day_count) {

      if ($day == $day_count) {
          // 月の最終日の場合、空セルを追加
          // 例）最終日が水曜日の場合、木・金・土曜日の空セルを追加
          $week .= str_repeat('<td></td>', 6 - $youbi % 7);
      }

      // weeks配列にtrと$weekを追加する
      $weeks[] = '<tr>' . $week . '</tr>';

      // weekをリセット
      $week = '';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <title>マイページ</title>
</head>

<body>
  <?php include('login_header.php');?>
  <div class="container">
    <div class="row">
      <h4 class="mt-4 mb-4"> - ユーザ情報 - </h4>
    </div>
    <div class="row align-items-center">
      <div class="col-2">
        <?php if(file_exists("./img/$image")): ?>
          <img src="/img/<?= $image ?>" class="detail_img">
        <?php else: ?>
          <img src="/img/noimage.png" class="detail_img">
        <?php endif; ?>
      </div>
      <div class="col-3">
        <label class="mt-1" for="name">名前：</label>
        <?= htmlspecialchars($params['userDate']["name"], ENT_QUOTES, "UTF-8"); ?><br>
        <a href="good_index.php?id=<?= $params['userDate']['id'] ?>">いいねした記事一覧</a>
      </div>
      <div class="col-7">
      <?php if($params['userDate']['id'] === $_SESSION['login_user']['id']): ?>
          <label class="mt-1" for="name">メールアドレス：</label>
          <?= htmlspecialchars($params['userDate']["email"], ENT_QUOTES, "UTF-8"); ?><br>
          <?php endif; ?>
          <?php if($params['userDate']['id'] === $_SESSION['login_user']['id']): ?>
          <a href="user_edit.php?id=<?= $params['userDate']['id'] ?>">プロフィール編集</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <h3 class="mt-4 mb-2"><a href="?ym=<?php echo $prev; ?>&id=<?=$params["userDate"]["id"] ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>&id=<?=$params["userDate"]["id"] ?>">&gt;</a></h3>
      <table class="table table-bordered">
        <tr>
            <th>日</th>
            <th>月</th>
            <th>火</th>
            <th>水</th>
            <th>木</th>
            <th>金</th>
            <th>土</th>
        </tr>
        <?php foreach ($weeks as $week) { echo $week; }?>
      </table>
    </div>

  </div>
  <?php include('footer.php');?>

</body>

</html>