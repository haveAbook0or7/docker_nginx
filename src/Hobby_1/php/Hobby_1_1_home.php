<?php
    session_start();
    function login(){
        if(isset($_GET['logout'])){
            $_SESSION['userID'] = "";
            $_SESSION['myTB'] = "H1_2_DefaultDataMax";
        }
        if($_SESSION['userID'] != "" && $_SESSION['myTB'] != ""){
            if($_SESSION['userID'] == "wakana"){ // 管理者
                return $_SESSION['userID'].
                        '<span><a href="Hobby_1_2_custom.php" id="customlink">カードステータス編集</a> 
                        <a href="Hobby_1_4_add.php" id="addlink">カード追加</a> 
                        <a href="Hobby_1_1_home.php?logout='.$_SESSION['userID'].'">ログアウト</a></span>';
            }
            return $_SESSION['userID'].
                    '<span><a href="Hobby_1_2_custom.php" id="customlink">カードステータス編集</a> 
                    <a href="Hobby_1_1_home.php?logout='.$_SESSION['userID'].'">ログアウト</a></span>';
        }        
        $_SESSION['myTB'] = "H1_2_DefaultDataMax";
        return 'ゲスト <span><a href="Hobby_1_2_custom.php" id="customlink" target="_blank">カードステータス閲覧</a> 
                <a href="Hobby_1_3_login.php">ログイン</a></span>';
    }
    $log = login();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>twstカード編成ツール</title>
        <meta charset="UTF-8">
        <meta name = "authr" content="有本 和奏" charset="utf-8">
        <link href="../css/H_common.css" rel="stylesheet">
        <script src="../lib/vue.js"></script> 
        <script src="https://unpkg.com/http-vue-loader"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    </head>
    <body>
        <header>
            <h1>twstカード編成ツール<a href="Hobby_1_3_preRegister.php"  target="_self">新規登録</a></h1>
        </header>
        <main id="app">
            <br><br>
            <h2>ユーザーID: <?= $log?></h2>
            <card-select :mydbname="'<?= $_SESSION['myTB'] ?>'"></card-select>
        </main>
        <script>
            new Vue({
                el: "#app",
                components: {
                    'card-select': httpVueLoader('../js/1_1/card-select.vue'),
                }
            });
        </script>
    </body>
</html>