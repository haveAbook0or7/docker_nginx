<?php
session_start();
// リクエストのbodyを取り出す。
$JSON_string = file_get_contents('php://input');
// JSON文字列を変換。arrayにするためにはtrueが必要です。
$JSON_array = JSON_decode($JSON_string,true);
//データベース定義
// define('HOST', 'mysql1.php.xdomain.ne.jp');
// define('USR', 'haveabook_user1');
// define('PASS', 'waka7ari');
// define('DB', 'haveabook_db');
define('HOST', 'db');
define('USR', 'db_user');
define('PASS', 'pass');
define('DB', 'db_hobby');

// ログインデータを取得
if($JSON_array != NULL){
    $id = $JSON_array["user"];
    $ps = $JSON_array["pass"];
    //データベースサーバに接続
    if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
        die('データベースに接続できません');
    }
    //クエリの文字コードを設定
    mysqli_set_charset($conn, 'utf8');
    //SQL文の作成
    $sql = "SELECT ID, CONCAT(mybase, Dno) FROM H1_4_Users WHERE ID LIKE \"$id\" AND pass LIKE \"$ps\";";
    //ステートメントン実行準備
    $stmt = mysqli_prepare($conn, $sql);
    //SQLステートメントの実行
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_store_result($stmt);
    $num = mysqli_stmt_num_rows($stmt);
    $data["flg"] = false;
    if($num > 0){
        //データの取得
        //取り出した値を変数に入れる
        mysqli_stmt_bind_result($stmt, $id, $mybase);
        mysqli_stmt_fetch($stmt);
        $data["flg"] = true;
        $data["user"] = $id;
        $data["mybase"] = $mybase;    
    } 
    //データベースの接続を閉じる
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    if($data["flg"]){
        $_SESSION['userID'] = $data["user"];
        $_SESSION['myTB'] = $data["mybase"];
    }
    $arr["data"] = $data;
    $arr["message"] = $data["flg"] ? "" : "IDかパスワードが間違っています。";
    print json_encode($arr, JSON_PRETTY_PRINT);
}
?>