<?php session_start();?>
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
            <br><br><br><br>
            <login-form></login-form>
        </main>
        <script>
            new Vue({
                el: "#app",
                components: {
                    'login-form': httpVueLoader('../js/1_3/login-form.vue'),
                }
            });
        </script>
    </body>
</html>
