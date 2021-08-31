<?php
//データベース定義
// define('HOST', 'mysql1.php.xdomain.ne.jp');
// define('USR', 'haveabook_user1');
// define('PASS', 'waka7ari');
// define('DB', 'haveabook_db');
define('HOST', 'db');
define('USR', 'db_user');
define('PASS', 'pass');
define('DB', 'db_hobby');

//データベースサーバに接続
if (!$conn = mysqli_connect(HOST, USR, PASS, DB)) {
    die('データベースに接続できません');
}

//クエリの文字コードを設定
mysqli_set_charset($conn, 'utf8');
$_SESSION['myTB'] = "H1_3_UserData1";
$myTB = $_SESSION['myTB'];
//SQL文の作成
$sql = "SELECT  d1.cdno, d1.chno, d1.cimg, d2.lv, d2.hp, d2.atk, 
                d1.m1_1, d1.m2_1, d1.m1buf_1, d1.m2buf_1, 
                d1.m1_5, d1.m2_5, d1.m1buf_5, d1.m2buf_5, 
                d1.m1_10, d1.m2_10, d1.m1buf_10, d1.m2buf_10, 
                d2.m1lv, d2.m2lv, 
                d1.b1, d1.b2, d1.b3, d1.b1type, d1.b2type, d1.b3type, d2.b1lv, d2.b2lv, d2.b3lv, 
                d4.hp, d4.atk, 
                d3.hp, d3.atk 
        FROM H1_1_CardData AS d1 INNER JOIN $myTB AS d2 ON d1.cdno = d2.cdno 
        INNER JOIN H1_2_DefaultDataMax AS d3 ON d2.cdno = d3.cdno 
        INNER JOIN H1_2_DefaultDataMiddle AS d4 ON d3.cdno = d4.cdno 
        ORDER BY d1.cdno ASC";

//ステートメントン実行準備
$stmt = mysqli_prepare($conn, $sql);
        
//SQLステートメントの実行
mysqli_stmt_execute($stmt); 
mysqli_stmt_store_result($stmt);
$num = mysqli_stmt_num_rows($stmt);            
if($num > 0){
    //データの取得
    //取り出した値を変数に入れる
    $i = 0;
    mysqli_stmt_bind_result($stmt,  $cdN, $chN, $cimg, $clv, $chp, $catk,
                                    $m1_1, $m2_1, $m1b_1, $m2b_1,
                                    $m1_5, $m2_5, $m1b_5, $m2b_5,
                                    $m1_10, $m2_10, $m1b_10, $m2b_10,
                                    $m1lvl, $m2lvl,
                                    $bd1, $bd2, $bd3, $b1T, $b2T, $b3T, $b1lvl, $b2lvl, $b3lvl,
                                    $middlehp, $middleatk, $maxhp, $maxatk);

    while(mysqli_stmt_fetch($stmt)){
        $arr["data"][$i]["cdno"] = $cdN;
        $arr["data"][$i]["chno"] = $chN;
        $arr["data"][$i]["img"] = $cimg;
        $arr["data"][$i]["lv"] = $clv;
        $arr["data"][$i]["hp"] = $chp;
        $arr["data"][$i]["atk"] = $catk;
        $arr["data"][$i]["m1_1"] = $m1_1;
        $arr["data"][$i]["m2_1"] = $m2_1;
        $arr["data"][$i]["m1_5"] = $m1_5;
        $arr["data"][$i]["m2_5"] = $m2_5;
        $arr["data"][$i]["m1_10"] = $m1_10;
        $arr["data"][$i]["m2_10"] = $m2_10;
        $arr["data"][$i]["m1buf_1"] = $m1b_1;
        $arr["data"][$i]["m2buf_1"] = $m2b_1;
        $arr["data"][$i]["m1buf_5"] = $m1b_5;
        $arr["data"][$i]["m2buf_5"] = $m2b_5;
        $arr["data"][$i]["m1buf_10"] = $m1b_10;
        $arr["data"][$i]["m2buf_10"] = $m2b_10;
        $arr["data"][$i]["m1lv"] = $m1lvl;
        $arr["data"][$i]["m2lv"] = $m2lvl;
        $arr["data"][$i]["b1"] = $bd1;
        $arr["data"][$i]["b2"] = $bd2;
        $arr["data"][$i]["b3"] = $bd3;
        $arr["data"][$i]["b1type"] = $b1T;
        $arr["data"][$i]["b2type"] = $b2T;
        $arr["data"][$i]["b3type"] = $b3T;
        $arr["data"][$i]["b1lv"] = $b1lvl;
        $arr["data"][$i]["b2lv"] = $b2lvl;
        $arr["data"][$i]["b3lv"] = $b3lvl;
        $arr["data"][$i]["hpmiddle"] = $middlehp;
        $arr["data"][$i]["atkmiddle"] = $middleatk;
        $arr["data"][$i]["hpmax"] = $maxhp;
        $arr["data"][$i]["atkmax"] = $maxatk;
        $arr["data"][$i]["m1max"] = $m1_10;
        $arr["data"][$i]["m1bufmax"] = $m1b_10;
        $arr["data"][$i]["m2max"] = $m2_10;
        $arr["data"][$i]["m2bufmax"] = $m2b_10;

        $i++;
    }
    $arr["message"] = "OK";
}else{
    $arr["message"] = "NO";
}
//データベースの接続を閉じる
mysqli_stmt_free_result($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);


// 配列をjson形式にデコードして出力, 第二引数は、整形するためのオプション
print json_encode($arr, JSON_PRETTY_PRINT);
?>