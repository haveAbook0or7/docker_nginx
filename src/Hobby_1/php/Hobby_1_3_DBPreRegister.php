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

function get_token(){
    $TOKEN_LENGTH = 16;
    $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
    return bin2hex($bytes);
}
// ログインデータを取得
if($JSON_array != NULL){
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
             *  まずは既に登録されているものではないかチェック
             */
            $sql = "SELECT ID FROM H1_4_Users WHERE email = ?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            //SQLステートメントの実行
            mysqli_stmt_execute($stmt); 
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);
            // 既に登録ユーザがいたらエラーメッセージを返す。
            if($num != 0){
                throw new Exception("すでに登録されているメールアドレスは使えません。");
            }
            /** 
             * ここから仮登録 
             */
            $token = get_token();
            $deleteday = date("Y-m-d H:i:s", strtotime('0 day') + 6 * 60 * 60);
            //SQL文の作成
            $sql =  "INSERT INTO H1_4_preRegister(email, token, deletedate) VALUES(?,?,?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'sss', $email, $token, $deleteday);
            mysqli_stmt_execute($stmt);
            // うまくいかなかったらエラーメッセージを返す。
            if(mysqli_stmt_affected_rows($stmt) != 1){
                throw new Exception("エラー。もう一度始めからやり直してください。");
            }
            /**
             * メール配信
             */
            mb_language("ja");
            mb_internal_encoding("UTF-8");
            $to = $email; //登録メアド
            $subject = "仮登録完了及び本登録URL通知";
            // $message = "http://haveabook.php.xdomain.jp/Hobby_1/php/Hobby_1_3_Register.php?token=".$token;
            $message = "
            こちらのURLから本登録へお進みください。\n
            なお、こちらのURLの有効期限は約6時間です。有効期限が過ぎた場合はもう一度仮登録からやり直して下さい。\n
            http://localhost:8080/Hobby_1/php/Hobby_1_3_Register.php?token=".$token;
            $headers = array(
                'From' => 'noreply@test.com',
                'MIME-Version' => '1.0',
                'Content-Transfer-Encoding' => '8bit',
                'Content-Type' => 'text/plain; charset=UTF-8',
            ); 
            if(!mb_send_mail($to, $subject, $message, $headers)){
                throw new Exception("エラー。もう一度始めからやり直してください。");
            }
            // コミット
            $conn->commit();
            $msg = "仮登録完了しました。";
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
     * 完了
     */
    $arr["data"]["flg"] = $flg;
    $arr["message"] = $msg;
    print json_encode($arr, JSON_PRETTY_PRINT);
}
?>