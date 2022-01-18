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
    /**
     * トークン照合処理
     */
    if($JSON_array["flg"] == "mounted"){
        $token = $JSON_array["token"];
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        //SQL文の作成
        $sql = "SELECT email FROM H1_4_preRegister WHERE token = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $token);
        //SQLステートメントの実行
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_store_result($stmt);
        $num = mysqli_stmt_num_rows($stmt);
        $arr["data"]["flg"] = false;
        if($num == 1){
            mysqli_stmt_bind_result($stmt, $resemail);
            mysqli_stmt_fetch($stmt);
            $arr["data"]["flg"] = true;
            $arr["data"]["email"] = $resemail;
        }
        //データベースの接続を閉じる
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        // フラグを返す
        print json_encode($arr, JSON_PRETTY_PRINT);
        return;
    }
    /**
     * 登録処理
     */
    if($JSON_array["flg"] == "signup"){
        $id = $JSON_array["id"];
        $pass = $JSON_array["pass"];
        $email = $JSON_array["email"];
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        try{
            // トランザクション開始
            $conn->begin_transaction();
            try{
                /**
                 * まずはIDが既に登録されているものではないかチェック
                 */
                $sql = "SELECT * FROM H1_4_Users WHERE ID = ?;";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $id);
                //SQLステートメントの実行
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_store_result($stmt);
                $num = mysqli_stmt_num_rows($stmt);
                // 既に使用されているIDならエラーメッセージを返す。
                if($num != 0){
                    throw new Exception("idErr:すでに使用されているIDは使えません。");
                }
                /**
                 * ここから登録
                 */
                $sql =  "INSERT INTO H1_4_Users(ID, pass, email) VALUES(?,?,?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'sss', $id, $pass, $email);
                mysqli_stmt_execute($stmt);
                // うまくいかなかったらエラーメッセージを返す
                if(mysqli_stmt_affected_rows($stmt) != 1){
                    throw new Exception("err:エラー(001)。もう一度仮登録からやり直してください。");
                }
                /**
                 * ユーザ専用テーブル作成
                 */
                $sql = "CREATE TABLE H1_3_UserData_{$id} LIKE H1_2_DefaultData";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_execute($stmt);
                // うまくいかなかったらエラーメッセージを返す
                if(mysqli_stmt_error($stmt) != ""){
                    throw new Exception("err:エラー(002)。もう一度仮登録からやり直してください。");
                }
                /**
                 * 初期データ追加
                 */
                $sql = "INSERT INTO H1_3_UserData_{$id} SELECT * FROM H1_2_DefaultData";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt) < 1){
                    throw new Exception("err:エラー(003)。もう一度仮登録からやり直してください。");
                }
                /**
                 * 仮登録消す(別に失敗してもいい)
                 */
                //SQL文の作成
                $sql = "DELETE FROM H1_4_preRegister WHERE email = ?;";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 's', $email);
                mysqli_stmt_execute($stmt);
                // コミット
                $conn->commit();
                $msg = "登録完了しました。";
                $flg = true;
            }catch(Exception $e){
                // エラーが発生したらロールバック
                $conn->rollback();
                throw $e;
            }
        }catch(Exception $e){
            $msg = $e->getMessage();
            $flg = false;
        }
        //データベースの接続を閉じる
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        /**
         * 本登録完了
         */
        $arr["data"]["flg"] = $flg;
        $arr["message"] = $msg;
        print json_encode($arr, JSON_PRETTY_PRINT);
    }
}
?>