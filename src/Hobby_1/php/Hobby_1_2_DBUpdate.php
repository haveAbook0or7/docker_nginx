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
define('MYDBSTART', 'H1_3_UserData_');

if($JSON_array != NULL){
    try{
        // 更新するテーブル名取得
        if(substr($_SESSION['myTB'], 0, strlen(MYDBSTART)) == MYDBSTART){
            $myTB = $_SESSION['myTB'];
        }else{
            throw new Exception("ユーザー認証に失敗しました。ログインしてやり直してください。");
        }
        // 更新データを取得
        $datas = $JSON_array["data"];
        $cnt = 0;
        $errlog = array();
        //データベースサーバに接続
        if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
            die('データベースに接続できません');
        }
        //クエリの文字コードを設定
        mysqli_set_charset($conn, 'utf8');
        // 一つずつデータを更新
        for($i = 0; $i < count($datas); $i++){
            $datas[$i]["cdno"] = (int)$datas[$i]["cdno"];
            $datas[$i]["lv"] = (int)$datas[$i]["lv"];
            $datas[$i]["hp"] = (int)$datas[$i]["hp"];
            $datas[$i]["atk"] = (int)$datas[$i]["atk"];
            $datas[$i]["m1lv"] = (int)$datas[$i]["m1lv"];
            $datas[$i]["m2lv"] = (int)$datas[$i]["m2lv"];
            $datas[$i]["b1lv"] = (int)$datas[$i]["b1lv"];
            $datas[$i]["b2lv"] = (int)$datas[$i]["b2lv"];
            $datas[$i]["b3lv"] = (int)$datas[$i]["b3lv"];
            try{
                // トランザクション開始
                $conn->begin_transaction();
                try{
                    $sql = "UPDATE {$myTB} 
                            SET lv = ?, hp = ?, atk = ?, m1lv = ?, m2lv = ?, b1lv = ?, b2lv = ?, b3lv = ? 
                            WHERE cdno = ?;";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "iiiiiiiii", 
                        $datas[$i]["lv"], $datas[$i]["hp"], $datas[$i]["atk"], 
                        $datas[$i]["m1lv"], $datas[$i]["m2lv"], 
                        $datas[$i]["b1lv"], $datas[$i]["b2lv"], $datas[$i]["b3lv"], 
                        $datas[$i]["cdno"]
                    );
                    mysqli_stmt_execute($stmt);
                    if(mysqli_stmt_affected_rows($stmt) != 1){
                        throw new Exception("Error:{$datas[$i]["cdno"]}");
                    }
                    $conn->commit();
                    $cnt++;
                }catch(Exception $e){
                    // エラーが発生したらロールバック
                    $conn->rollback();
                    throw $e;
                }
            }catch(Exception $e){
                $errlog[] = $e->getMessage();
            }
        }
        $msg = "{$cnt}個のデータを更新しました。";
        //データベースの接続を閉じる
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }catch(Exception $e){
        $msg = $e->getMessage();
    }
    $arr["msg"] = $msg;
    $arr["errlog"] = $errlog;
    print json_encode($arr, JSON_PRETTY_PRINT);
}
?>