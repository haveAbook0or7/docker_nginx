<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Vue.jsテスト</title>
<script src="../lib/vue.js"></script> 
<script src="https://unpkg.com/http-vue-loader"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style>

</style>
</head>

<body>
	
<form id="con" method="post" action="Hobby_contents1.php" enctype="multipart/form-data">
    <card-select></card-select>
</form>
<script>
	new Vue({
		el: "#con",
		components: {
			'select-own': httpVueLoader('http://localhost:8080/Hobby_1/js/select-own.vue'),
			'select-effect': httpVueLoader('http://localhost:8080/Hobby_1/js/select-effect.vue'),
			'select-effect2': httpVueLoader('http://localhost:8080/Hobby_1/js/select-effect2.vue'),
			'choice-modal-img': httpVueLoader('http://localhost:8080/Hobby_1/js/choice-modal-img.vue'),
			'img-select': httpVueLoader('http://localhost:8080/Hobby_1/js/img-select.vue'),
			'input-file-own': httpVueLoader('http://localhost:8080/Hobby_1/js/input-file-own.vue'),
			'radio-element': httpVueLoader('http://localhost:8080/Hobby_1/js/radio-element.vue'),
			// 'view-damage': httpVueLoader('http://localhost:8080/Hobby_1/js/view-damage.vue'),
			// 'view-buddy': httpVueLoader('http://localhost:8080/Hobby_1/js/view-buddy.vue'),
			// 'view-hpatk': httpVueLoader('http://localhost:8080/Hobby_1/js/view-hpatk.vue'),
			'card-select': httpVueLoader('http://localhost:8080/Hobby_1/js/1_1/card-select.vue'),
			'choice-modal-card': httpVueLoader('http://localhost:8080/Hobby_1/js/choice-modal-card.vue'),
		},
	});
</script>
</body>
</html>

