<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>JavaScriptのFileAPIで画像のプレビュー</title>
<script src="../lib/vue.js"></script> 
<script src="https://unpkg.com/http-vue-loader"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>

<body>
	<form id="con" method="post" action="Hobby_contents1.php" enctype="multipart/form-data">
    <!-- <view-hpatk :id="'card1'"></view-hpatk>
		<view-buddy :id="'card1'"></view-buddy>
    <view-damage :id="'card1'"></view-damage> -->
    <card-select></card-select>
    
		<!-- <div class="columns medium-3" v-for="result in results">
  <div class="card">
    <div class="card-divider">
      {{ this.results }}
    </div>
  </div>
</div> -->
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
			'view-damage': httpVueLoader('http://localhost:8080/Hobby_1/js/view-damage.vue'),
			'view-buddy': httpVueLoader('http://localhost:8080/Hobby_1/js/view-buddy.vue'),
			'view-hpatk': httpVueLoader('http://localhost:8080/Hobby_1/js/view-hpatk.vue'),
			'card-select': httpVueLoader('http://localhost:8080/Hobby_1/js/card-select.vue'),
			'choice-modal-card': httpVueLoader('http://localhost:8080/Hobby_1/js/choice-modal-card.vue'),
		},
	});
</script>

</body>

</html>

