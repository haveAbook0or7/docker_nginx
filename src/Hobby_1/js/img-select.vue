<template>
	<div @mouseenter="childShow(true)" @mouseleave="childShow(false)">
		<img :src="preview" width="30" height="30">
		<input type="hidden" :id="this.id_name" :name="this.id_name" :value="buddy">
		<choice-modal-img 
			:class="this.class" 
			@catch-icon="getIcon"></choice-modal-img>
	</div>
</template>

<script>
module.exports = {
	components: {
		// 'choice-modal-img': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/choice-modal-img.vue'),
		'choice-modal-img': httpVueLoader('http://localhost:8080/Hobby_1/js/choice-modal-img.vue'),
	},
	props: {
		id_name: {default:"myselectimg"},
		defaImg: {default:"../img/none.jpg"}
	},
	data: function () {
		return {
			preview: this.defaImg,
			buddy: "",
			class: "hide"
		}
	},
	methods: {
		initialize(){
			this.preview = "../img/none.jpg";
			this.buddy = "";
		},
		getIcon(value) {
			this.preview = '../img/Another/'+value;
			this.buddy = value.substr(0, 2);
		},
		childShow(flg){
			this.class = flg ? "show" : "hide";
		}
	},
	
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	img{
		border: 1px solid black;
	}
	div{
		display: inline-grid;
		position: absolute;
		top: 5px;
		left: 5px;
	}
	.show{
		top: 30px;
		left: 0px;
		z-index: 1;
		width: 180px;
		height: 205px;
		display: inline;
		padding: 3px;
		border: 2px solid gray;
		background-color: rgb(251, 250, 245);
	}
	.hide{
		display: none;
	}
</style>