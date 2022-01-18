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
    $msg = "";
    $count = 0;
    //データベースサーバに接続
    if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
        die('データベースに接続できません');
    }
    //クエリの文字コードを設定
    mysqli_set_charset($conn, 'utf8');
    for($i = 0; $i < count($datas); $i++){
        $datas[$i]["cdno"] = (int)$datas[$i]["cdno"];
        $datas[$i]["chno"] = (int)$datas[$i]["chno"];
        $datas[$i]["b1"] = (int)$datas[$i]["b1"];
        $datas[$i]["b2"] = (int)$datas[$i]["b2"];
        $datas[$i]["b3"] = (int)$datas[$i]["b3"];
        $datas[$i]["lvone"] = (int)$datas[$i]["lvone"];
        $datas[$i]["lvmiddle"] = (int)$datas[$i]["lvmiddle"];
        $datas[$i]["lvmax"] = (int)$datas[$i]["lvmax"];
        $datas[$i]["hpone"] = (int)$datas[$i]["hpone"];
        $datas[$i]["hpmiddle"] = (int)$datas[$i]["hpmiddle"];
        $datas[$i]["hpmax"] = (int)$datas[$i]["hpmax"];
        $datas[$i]["atkone"] = (int)$datas[$i]["atkone"];
        $datas[$i]["atkmiddle"] = (int)$datas[$i]["atkmiddle"];
        $datas[$i]["atkmax"] = (int)$datas[$i]["atkmax"];
        try{
            // トランザクション開始
            $conn->begin_transaction();
            try {
                // H1_1_CardData
                $sql1 = "INSERT INTO H1_1_CardData 
                        VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = mysqli_prepare($conn, $sql1);
                mysqli_stmt_bind_param($stmt, "iisssssssssssssisisis", 
                    $datas[$i]["cdno"], $datas[$i]["chno"], $datas[$i]["imgname"], 
                    $datas[$i]["m1_1"], $datas[$i]["m1buf_1"], $datas[$i]["m2_1"], $datas[$i]["m2buf_1"], 
                    $datas[$i]["m1_5"], $datas[$i]["m1buf_5"], $datas[$i]["m2_5"], $datas[$i]["m2buf_5"], 
                    $datas[$i]["m1_10"], $datas[$i]["m1buf_10"], $datas[$i]["m2_10"], $datas[$i]["m2buf_10"], 
                    $datas[$i]["b1"], $datas[$i]["b1type"], 
                    $datas[$i]["b2"], $datas[$i]["b2type"], 
                    $datas[$i]["b3"], $datas[$i]["b3type"]
                );
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt) != 1){
                    throw new Exception("Error-H1_1");
                }
                // H1_2_DefaultData
                $sql2 = "INSERT INTO H1_2_DefaultData VALUE(?,?,?,?,?,?,?,?,?)";
                $stmt = mysqli_prepare($conn, $sql2);
                $initM = 1; $initB = array(1, $datas[$i]["b2"] != -1 ? 1 : 0, $datas[$i]["b3"] != -1 ? 1 : 0); 
                mysqli_stmt_bind_param($stmt, "iiiiiiiii", 
                    $datas[$i]["cdno"], $datas[$i]["lvone"], 
                    $datas[$i]["hpone"], $datas[$i]["atkone"], 
                    $initM, $initM, 
                    $initB[0], $initB[1], $initB[2]
                );
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt) != 1){
                    throw new Exception("Error-H1_2");
                }
                // H1_2_DefaultDataMiddle
                $sql3 = "INSERT INTO H1_2_DefaultDataMiddle VALUE(?,?,?,?,?,?,?,?,?)";
                $stmt = mysqli_prepare($conn, $sql3);
                $initM = 5; $initB = array(10, $datas[$i]["b2"] != -1 ? 10 : 0, $datas[$i]["b3"] != -1 ? 10 : 0);
                mysqli_stmt_bind_param($stmt, "iiiiiiiii", 
                    $datas[$i]["cdno"], $datas[$i]["lvmiddle"], 
                    $datas[$i]["hpmiddle"], $datas[$i]["atkmiddle"], 
                    $initM, $initM, 
                    $initB[0], $initB[1], $initB[2]
                );
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt) != 1){
                    throw new Exception("Error-H1_2_Mid");
                }
                // H1_2_DefaultDataMax
                $sql4 = "INSERT INTO H1_2_DefaultDataMax VALUE(?,?,?,?,?,?,?,?,?)";
                $stmt= mysqli_prepare($conn, $sql4);
                $initM = 10; $initB = array(10, $datas[$i]["b2"] != -1 ? 10 : 0, $datas[$i]["b3"] != -1 ? 10 : 0); 
                mysqli_stmt_bind_param($stmt, "iiiiiiiii", 
                    $datas[$i]["cdno"], $datas[$i]["lvmax"], 
                    $datas[$i]["hpmax"], $datas[$i]["atkmax"], 
                    $initM, $initM, 
                    $initB[0], $initB[1], $initB[2]
                );
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt) != 1){
                    throw new Exception("Error-H1_2_Max");
                }
                // Userのテーブル取得
                $sql5 = "SELECT CONCAT(\"H1_3_UserData_\", ID) FROM H1_4_Users";
                $stmt = mysqli_prepare($conn, $sql5);
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_store_result($stmt);
                $num = mysqli_stmt_num_rows($stmt); 
                $arrUT = array();
                if($num > 0){
                    mysqli_stmt_bind_result($stmt, $concat);
                    while(mysqli_stmt_fetch($stmt)){
                        $arrUT[] = $concat;
                    }
                }
                // Userのテーブルに初期値追加
                for($j = 0; $j < count($arrUT); $j++){
                    $sql6 = "INSERT INTO {$arrUT[$j]} SELECT * FROM H1_2_DefaultData WHERE cdno = ?";
                    $stmt= mysqli_prepare($conn, $sql6);
                    mysqli_stmt_bind_param($stmt, "i", $datas[$i]["cdno"]);
                    mysqli_stmt_execute($stmt);
                    if(mysqli_stmt_affected_rows($stmt) != 1){
                        throw new Exception("Error-H1_2_".$arrUT[$j]);
                    }
                }
                // コミット
                $conn->commit();
                $msg = "CommitOK";
                $flg = true;
            } catch( Exception $e ){
                // エラーが発生したらロールバック
                $conn->rollback();
                throw $e;
            }
            $count++;
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $flg = false;
        }
    }
    //データベースの接続を閉じる
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    $arr["message"] = $msg;
    $arr["data"]["flg"] = $flg;
    $arr["data"]["count"] = $count;
    print json_encode($arr, JSON_PRETTY_PRINT);
}
?>