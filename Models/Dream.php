<?php
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'Models/Db.php');

class Dream extends Db {

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // emotionsデータ取得
  /**
   * emotionsテーブルからすべてデータを取得
   * @param integer $id
   * @return Array $result 全ユーザデータ
   */
  public function emotionAll() {
    $sql = 'SELECT id, emotion FROM emotions';
    $sth = $this->dbh->query($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 新規投稿
  /**
   * 新規投稿する
   * @param array $postData
   * @return bool $result
   */
  public function post_insert($postData) {
    $this->dbh->beginTransaction();
    try {
      $result = false;
      $sql = 'INSERT INTO posts (user_id, emotion_id, title, body, date) VALUES (:user_id, :emotion_id, :title, :body, :date)';
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':user_id', (int)$postData['id'], PDO::PARAM_INT);
      $sth->bindValue(':emotion_id', (int)$postData['emotion'], PDO::PARAM_INT);
      $sth->bindValue(':title', $postData['title'], PDO::PARAM_STR);
      $sth->bindValue(':body', $postData['body'], PDO::PARAM_STR);
      $sth->bindValue(':date', $postData['date'], PDO::PARAM_STR);
      $result = $sth->execute();
      $this->dbh->commit();
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollback();
      return $result;
    }
  }

  // postsの全データ取得
  /**
   * postsテーブルからすべてデータを取得
   * @return Array $result 全投稿データ
   */
  public function post_All($page = 0) {
    $sql = 'SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion
            FROM posts p
            JOIN users u ON p.user_id = u.id
            JOIN emotions e ON p.emotion_id = e.id
            ORDER BY p.id DESC
            LIMIT 10 OFFSET '.(10 * $page);
    $sth = $this->dbh->query($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // postID取得
  /**
   * postsテーブルからデータを取得
   * @param integer $id
   * @return Array $result 全ユーザデータ
   */
  public function postId($id) {
    $sql = 'SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion
            FROM posts p
            JOIN users u ON p.user_id = u.id
            JOIN emotions e ON p.emotion_id = e.id
            WHERE p.id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }


  public function dream_update($postData) {
    $this->dbh->beginTransaction();
    try {
      $sql = 'UPDATE posts SET emotion_id = :emotion_id, title = :title, body = :body, date = :date WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':emotion_id', (int)$postData['emotion'], PDO::PARAM_INT);
      $sth->bindValue(':title', $postData['title'], PDO::PARAM_STR);
      $sth->bindValue(':body', $postData['body'], PDO::PARAM_STR);
      $sth->bindValue(':date', $postData['date'], PDO::PARAM_STR);
      $sth->bindValue(':id', $postData['id'], PDO::PARAM_INT);
      $result = $sth->execute();
      $this->dbh->commit();
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollback();
      return $result;
    }
  }

  public function getPostData($p_id) {
    $sql = 'SELECT * FROM posts WHERE id = :p_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':p_id', (int)$p_id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  // postsのデータ件数を取得
  /**
   * postsテーブルからすべてデータ数を取得
   * @return Int $count 全投稿の件数
   */
  public function countAll():Int {
    $sql = 'SELECT count(*) as count FROM posts';
    $sth = $this->dbh->query($sql);
    $sth->execute();
    $count = $sth->fetchColumn();
    return $count;
  }

  // 検索データ取得
  /**
   * postsテーブルからすべてデータを取得
   * @return Array $result 全投稿データ
   */
  public function seek($search,$page = 0) {
    $title = $search["search_name"];
    $emotion = $search["emotion"];
    $dateStart = $search["date_start"];
    $dateEnd = $search["date_end"];
    if($emotion === "0") {
      if($dateStart === "") {
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title
                ORDER BY p.id DESC
                LIMIT 10 OFFSET ".(10 * $page);
      }else{
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title AND p.date BETWEEN '".$dateStart."' AND '".$dateEnd."'
                ORDER BY p.id DESC
                LIMIT 10 OFFSET ".(10 * $page);
      }
    }else{
      if($dateStart === ""){
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title AND p.emotion_id = ".$emotion."
                ORDER BY p.id DESC
                LIMIT 10 OFFSET ".(10 * $page);
      }else{
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title AND p.emotion_id = ".$emotion." AND p.date BETWEEN '".$dateStart."' AND '".$dateEnd."'
                ORDER BY p.id DESC
                LIMIT 10 OFFSET ".(10 * $page);
      }
    }
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(":title", '%'.$title.'%', PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 検索データの件数取得
  /**
   * postsテーブルからすべてデータを取得
   * @return Array $result 全投稿データ
   */
  public function seek_page($search) {
    $title = $search["search_name"];
    $emotion = $search["emotion"];
    $dateStart = $search["date_start"];
    $dateEnd = $search["date_end"];
    if($emotion === "0") {
      if($dateStart === "") {
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title ";
      }else{
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title AND p.date BETWEEN '".$dateStart."' AND '".$dateEnd."' ";
      }
    }else{
      if($dateStart === ""){
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title AND p.emotion_id = ".$emotion." ";
      }else{
        $sql = "SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, u.name, u.image, e.emotion, p.update_at
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN emotions e ON p.emotion_id = e.id
                WHERE p.title LIKE :title AND p.emotion_id = ".$emotion." AND p.date BETWEEN '".$dateStart."' AND '".$dateEnd."' ";
      }
    }
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(":title", '%'.$title.'%', PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 削除処理
   * @param integer $id
   */
  public function post_delete($id) {
    $this->dbh->beginTransaction();
    try{
      $sql = "DELETE FROM posts WHERE id = :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':id', (int)$id, PDO::PARAM_INT);
      $sth->execute();
      $this->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
      return $result;
    }
  }

  /**
   * postsテーブルからマイページの投稿データを取得
   * @return Array $result 全投稿データ
   */
  public function mypageData($id) {
    $sql = 'SELECT p.id, p.user_id, p.emotion_id, p.title, p.body, p.date, e.emotion
            FROM posts p
            JOIN emotions e ON p.emotion_id = e.id
            WHERE p.user_id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

}
?>