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

if($JSON_array != NULL){
    // トークン照合処理
    if($JSON_array["flg"] == "mounted"){
        $token = $JSON_array["token"];
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        //SQL文の作成
        $sql = "SELECT email FROM H1_4_preRegister WHERE token LIKE \"$token\";";
        //ステートメントン実行準備
        $stmt = mysqli_prepare($conn, $sql);
        //SQLステートメントの実行
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_store_result($stmt);
        $num = mysqli_stmt_num_rows($stmt);
        $flg = false;
        $res = "";
        if($num != 0){
            mysqli_stmt_bind_result($stmt, $email);
            mysqli_stmt_fetch($stmt);
            $flg = true;
            $res = $email;
        }
        //データベースの接続を閉じる
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        // フラグを返す
        $arr["data"]["flg"] = $flg;
        $arr["data"]["email"] = $res;
        print json_encode($arr, JSON_PRETTY_PRINT);
        return;
    }

    // 登録処理
    if($JSON_array["flg"] == "signup"){
        $id = $JSON_array["id"];
        $pass = $JSON_array["pass"];
        $email = $JSON_array["email"];
        // まずはIDが既に登録されているものではないかチェック
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        //SQL文の作成
        $sql = "SELECT * FROM H1_4_Users WHERE ID LIKE \"$id\";";
        //ステートメントン実行準備
        $stmt = mysqli_prepare($conn, $sql);
        //SQLステートメントの実行
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_store_result($stmt);
        $num = mysqli_stmt_num_rows($stmt);
        $flg = false;
        if($num == 0){
            $flg = true;
        }
        //データベースの接続を閉じる
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        // 既に使用されているIDならエラーメッセージを返す。
        if(!$flg){
            $arr["data"]["flg"] = $flg;
            $arr["data"]["err"] = "idErr";
            $arr["message"] = "すでに使用されているIDは使えません。";
            print json_encode($arr, JSON_PRETTY_PRINT);
            return;
        }

        // ここから登録
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        //SQL文の作成
        $sql =  "INSERT INTO H1_4_Users(ID, pass, email) VALUES(?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $id, $pass, $email);
        $flg = false;
        for($i = 0; $i < 10; $i++){
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_affected_rows($stmt) > 0){
                $flg = true;
                break;
            }
        }
        //データベースの接続を閉じる
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        // うまくいかなかったらエラーメッセージを返す
        if(!$flg){
            $arr["data"]["flg"] = $flg;
            $arr["data"]["err"] = "err";
            $arr["message"] = "エラー(001)。もう一度仮登録からやり直してください。";
            print json_encode($arr, JSON_PRETTY_PRINT);
            return;
        }

        // ユーザ専用テーブル作成1
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        //SQL文の作成
        $sql =  "SELECT CONCAT(mybase, Dno) FROM H1_4_Users WHERE ID LIKE \"$id\"";
        $stmt = mysqli_prepare($conn, $sql);
        $flg = false;
        $myDbase = null;
        for($i = 0; $i < 10; $i++){
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);
            if($num > 0){
                mysqli_stmt_bind_result($stmt, $mybase);
                mysqli_stmt_fetch($stmt);
                $flg = true;
                $myDbase = $mybase;
                break;
            }
        }
        //データベースの接続を閉じる
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        // うまくいかなかったらエラーメッセージを返す
        if(!$flg){
            $arr["data"]["flg"] = $flg;
            $arr["data"]["err"] = "err";
            $arr["message"] = "エラー(002)。もう一度仮登録からやり直してください。";
            print json_encode($arr, JSON_PRETTY_PRINT);
        }
        // ユーザ専用テーブル作成2
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        //SQL文の作成
        $sql = "CREATE TABLE $myDbase (SELECT * FROM H1_2_DefaultData)";
        $stmt = mysqli_prepare($conn, $sql);
        $flg = false;
        for($i = 0; $i < 10; $i++){
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_error($stmt) == ""){
                $flg = true;
                break;
            }
        }
        //データベースの接続を閉じる
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        // うまくいかなかったらエラーメッセージを返す
        if(!$flg){
            $arr["data"]["flg"] = $flg;
            $arr["data"]["err"] = "err";
            $arr["message"] = "エラー(003)。もう一度仮登録からやり直してください。";
            print json_encode($arr, JSON_PRETTY_PRINT);
        }
        // 本登録完了
        $arr["data"]["flg"] = $flg;
        $arr["message"] = "登録完了しました。";
        print json_encode($arr, JSON_PRETTY_PRINT);
    }
}
?>