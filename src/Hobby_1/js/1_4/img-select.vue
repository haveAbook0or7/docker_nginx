<template>
	<div class="base">
		<div class="modal" @mouseenter="childShow(true)" @mouseleave="childShow(false)">
			<img :src="preview" width="30" height="30">
			<choice-modal-img v-show="showFlg" @catch-icon="getIcon"></choice-modal-img>
		</div>
	</div>
</template>

<script>
module.exports = {
	components: {
		'choice-modal-img': httpVueLoader('./choice-modal-img.vue'),
	},
	props: {
		init_img: {default:"../img/none.jpg"}
	},
	data: function () {
		return {
			preview: this.init_img,
			buddy: "",
			showFlg: false
		}
	},
	methods: {
		initialize(){
			this.preview = "../img/none.jpg";
			this.buddy = "";
		},
		getIcon(key, value) {
			this.preview = '../img/Another/'+value;
			this.buddy = key;
			this.$emit('select', this.buddy);
		},
		childShow(flg){
			this.showFlg = flg;
		}
	},
	
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
		margin: 0;
		padding: 0;
		border: 0;
		font-size: 13px;
	}
	.base{
		width: 30px;
		height: 30px;
		position: relative;
		margin: 10px;
	}
	.modal{
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
	}
	img{
		border: 1px solid #e6b422;
	}
</style>