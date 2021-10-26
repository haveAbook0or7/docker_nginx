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

	<login-form></login-form>
</div>
<script>
	new Vue({
		el: "#con",
		components: {
			'login-form': httpVueLoader('../js/1_3/login-form.vue'),
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

