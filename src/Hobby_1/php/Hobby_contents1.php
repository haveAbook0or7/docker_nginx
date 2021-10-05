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
	<card-custom></card-custom>
</div>
<script>
	new Vue({
		el: "#con",
		components: {
			// 'view-damage': httpVueLoader('http://localhost:8080/Hobby_1/js/view-damage.vue'),
			// 'view-buddy': httpVueLoader('http://localhost:8080/Hobby_1/js/view-buddy.vue'),
			// 'view-hpatk': httpVueLoader('http://localhost:8080/Hobby_1/js/view-hpatk.vue'),
			'custom-masic': httpVueLoader('http://localhost:8080/Hobby_1/js/1_2/custom-masic.vue'),
			'custom-buddy': httpVueLoader('http://localhost:8080/Hobby_1/js/1_2/custom-buddy.vue'),
			'custom-basic': httpVueLoader('http://localhost:8080/Hobby_1/js/1_2/custom-basic.vue'),
			'card-custom': httpVueLoader('http://localhost:8080/Hobby_1/js/1_2/card-custom.vue'),
			'card-select': httpVueLoader('http://localhost:8080/Hobby_1/js/1_1/card-select.vue'),
			'choice-modal-card': httpVueLoader('http://localhost:8080/Hobby_1/js/choice-modal-card.vue'),
		},
	});
</script>
</body>
</html>

