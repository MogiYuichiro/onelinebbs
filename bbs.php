
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

</head>
<body>
    <form action="bbs.php" method="post">
      <input type="text" name="nickname" placeholder="nickname" required>
      <textarea type="text" name="comment" placeholder="comment" required></textarea>
      <button type="submit" >つぶやく</button>
    </form>

    <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:20</span></h2>
    <p>つぶやきコメント</p>

    <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:10</span></h2>
    <p>つぶやきコメント2</p>

</body>
</html>

<?php
  //POST送信が行われたら、下記の処理を実行
  //テストコメント
  //データーベースに接続
$dsn = 'mysql:dbname=oneline_bbs;host=localhost'; //←ローカルホストのoneline_bbsに
      
      //接続するためのユーザー情報
      $user = 'root';//←「root」権限で
      $password ='';

      //DB接続オブジェクトを作成
      $dbh = new PDO($dsn,$user,$password);//←データベースに接続

      //接続したオブジェクトで文字コードutf8を使うように指定
      $dbh->query('SET NAMES utf8');//←命令内容記述。query('命令実行するSQL文');

    
      if(isset($_POST) && !empty($_POST)){
      $nickname = ($_POST['nickname']);
      $comment = ($_POST['comment']);
       date_default_timezone_set("Asia/Manila");//日付/時刻関数で 使用されるデフォルトタイムゾーンを設定します。


      $created = new DateTime();
      $nickname = htmlspecialchars($nickname);
      $comment = htmlspecialchars($comment);

      
    //SQL文作成(INSERT文)
      //データベースエンジンにSQL文で司令を出す
      $sql = 'INSERT INTO `posts`(`nickname`, `comment`, `created`) VALUES ("'.$nickname.'","'.$comment.'","'.$created->format('Y-m-d H:i:s').'")';
      $stmt = $dbh -> prepare($sql);
      $stmt -> execute();

      // $dbh = null;
    header("Location: bbs.php");
    exit;
        
    //INSERT文実行

      //司令 データを全部くださいというSQL文！
      }
      $sql = 'SELECT * FROM posts WHERE 1';
      $stmt = $dbh->prepare($sql);//←「SQL文」で命令を出す準備。
      $stmt -> execute();
      while(1) //←無限ループ
      {
      $rec = $stmt -> fetch(PDO::FETCH_ASSOC); //←順番に1レコード取り出す命令
      if($rec == false) //←取り出すレコードが「無くなったら」
      {
        break; 
      }

     
      echo $rec['id'];
      echo $rec['nickname'];
      echo $rec['comment'];
      echo $rec['created'];
      echo '<br />';
    }

    //データベースから切断
    $dbh = null;
    // header("Location: bbs.php");
     // exit;
    
    
?>



