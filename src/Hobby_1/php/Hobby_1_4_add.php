<?php
    session_start();
    function login(){
        if($_SESSION['userID'] != "" && $_SESSION['myTB'] != ""){
            return $_SESSION['userID'];
        }        
        $_SESSION['myTB'] = "H1_2_DefaultDataMax";
        return 'ゲスト';
    }
    $log = login();
?>

<!DOCTYPE html>
<html>
<head>
        <title>ツイステカード編成ツール</title>
        <meta charset="UTF-8"><meta name = "authr" content="有本 和奏">
        <link href="../css/H_common.css" rel="stylesheet">
        <script src="../lib/vue.js"></script> 
        <script src="https://unpkg.com/http-vue-loader"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    </head>
    <body>
        <header>
            <h1>ツイステカード編成ツール<a href="./Hobby_1_1_home.php" id="homelink">ホームへ戻る</a></h1>
        </header>
        <main id="app">
            <br><br>
            <card-add
                :mydbname="'<?= $_SESSION['myTB'] ?>'" 
                :init_msg="'<?= $log == 'ゲスト' ? "" : "ユーザーID:$log" ?>'"
            ></card-add>
        </main>
        <script>
            new Vue({
                el: "#app",
                components: {
                    'card-add': httpVueLoader('../js/1_4/card-add.vue'),
                    'select-own': httpVueLoader('../js/select-own.vue'),
                    'select-effect': httpVueLoader('../js/select-effect.vue'),
                    'select-effect2': httpVueLoader('../js/select-effect2.vue'),
                    'choice-modal-img': httpVueLoader('../js/choice-modal-img.vue'),
                    'img-select': httpVueLoader('../js/img-select.vue'),
                    'input-file-own': httpVueLoader('../js/input-file-own.vue'),
                    'radio-element': httpVueLoader('../js/radio-element.vue'),
                }
            });
        </script>
    </body>
</html>
