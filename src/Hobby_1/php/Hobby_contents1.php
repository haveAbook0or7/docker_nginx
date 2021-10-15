<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>作業場</title>
<script src="../lib/vue.js"></script> 
<script src="https://unpkg.com/http-vue-loader"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style>

</style>
</head>

<body>
<div id="con">
    <!-- <card-select></card-select> -->
	<!-- <custom-basic></custom-basic>
	<custom-masic></custom-masic>
	<custom-buddy></custom-buddy> -->
	<card-custom :mydbname="'H1_3_UserData1'"></card-custom>
</div>
<script>
	new Vue({
		el: "#con",
		components: {
			'custom-masic': httpVueLoader('../js/1_2/custom-masic.vue'),
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

