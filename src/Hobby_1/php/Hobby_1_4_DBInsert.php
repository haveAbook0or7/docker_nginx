<?php
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

// 更新データを取得
if($JSON_array != NULL){
    $datas = $JSON_array["data"];
    //データベースサーバに接続
    if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
        die('データベースに接続できません');
    }
    //クエリの文字コードを設定
    mysqli_set_charset($conn, 'utf8');
    $cnt = 0;
    for($i = 0; $i < count($datas); $i++){
        //SQL文の作成
        $sql = "UPDATE H1_3_UserData1 
                SET lv = {$datas[$i]["lv"]}, hp = {$datas[$i]["hp"]}, atk = {$datas[$i]["atk"]}, m1lv = {$datas[$i]["m1lv"]}, m2lv = {$datas[$i]["m2lv"]}, b1lv = {$datas[$i]["b1lv"]}, b2lv = {$datas[$i]["b2lv"]}, b3lv = {$datas[$i]["b3lv"]} 
                WHERE cdno = {$datas[$i]["cdno"]};";
        //ステートメント実行準備
        $stmt = mysqli_prepare($conn, $sql);
        //SQLステートメントの実行
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt) > 0){
            $c += mysqli_stmt_affected_rows($stmt);
        }
    }
    $msg = "{$c}個のデータを更新しました。";	
    //データベースの接続を閉じる
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    $arr["msg"] = $msg;
    print json_encode($arr, JSON_PRETTY_PRINT);
}
?>