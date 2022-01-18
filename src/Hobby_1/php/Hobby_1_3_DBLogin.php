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
    $sql = "SELECT ID, CONCAT(\"H1_3_UserData_\", ID) FROM H1_4_Users WHERE ID = ? AND pass = ?;";
    //ステートメントン実行準備
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $id, $ps);
    //SQLステートメントの実行
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_store_result($stmt);
    $num = mysqli_stmt_num_rows($stmt);
    $arr["data"]["flg"] = false;
    if($num == 1){
        mysqli_stmt_bind_result($stmt, $resid, $mybase);
        mysqli_stmt_fetch($stmt);
        $arr["data"]["flg"] = true;
        $arr["data"]["user"] = $resid;
        $_SESSION['userID'] = $resid;
        $arr["data"]["mybase"] = $mybase;
        $_SESSION['myTB'] = $mybase;
    }
    //データベースの接続を閉じる
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    $arr["message"] = $arr["data"]["flg"] ? "" : "IDかパスワードが間違っています。";
    print json_encode($arr, JSON_PRETTY_PRINT);
}
?>