<?php
date_default_timezone_set('Asia/Tokyo');

echo date("Y/m/d H:i:s", strtotime('0 day') + 4 * 60 * 60) . "<br>"; //「2015/03/09 06:00:00」
echo date("Y/m/d", strtotime('last Saturday')) . "<br>"; //「2015/03/07」
echo date("Y/m/d 10:00:00", strtotime('last Saturday', strtotime('2015-03-07'))); //「2015/02/28 10:00:00」
echo date("Y/m/d 10:00:00", strtotime('last Saturday', strtotime('2015-03-03') + 7 * 24 * 60 * 60)); //「2015/03/07 10:00:00」
if(isset($_GET["token"])) {
	$token = trim(htmlspecialchars($_GET["token"], ENT_QUOTES, 'UTF-8'));
}else{
	$token = null;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>作業場</title>
<script src="../lib/vue.js"></script> 
<script src="https://unpkg.com/http-vue-loader"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue-router@2.0.0/dist/vue-router.js"></script>
<style>
</style>
</head>

<body>
<div id="con">
<register-form token="<?= $token ?>"></register-form>
</div>
<script>
	new Vue({
		el: "#con",
		components: {
			'register-form': httpVueLoader('../js/1_3/register-form.vue'),
			'custom-buddy': httpVueLoader('../js/1_2/custom-buddy.vue'),
			'custom-basic': httpVueLoader('../js/1_2/custom-basic.vue'),
			'card-custom': httpVueLoader('../js/1_2/card-custom.vue'),
			'card-select': httpVueLoader('../js/1_1/card-select.vue'),
			'choice-modal-card': httpVueLoader('../js/choice-modal-card.vue'),
		},
	});
</script>
</body>
</html>

