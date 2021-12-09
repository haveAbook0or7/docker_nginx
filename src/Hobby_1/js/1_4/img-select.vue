<template>
	<div class="img-select">
		<div class="modal" @mouseenter="childShow(true)" @mouseleave="childShow(false)">
			<img :src="preview" width="30" height="30">
			<choice-modal-img v-show="showFlg" @catch-icon="getIcon"></choice-modal-img>
		</div>
		<div class="disabled" v-show="isDisabled"></div>
	</div>
</template>

<script>
module.exports = {
	components: {
		'choice-modal-img': httpVueLoader('./choice-modal-img.vue'),
	},
	props: {
		init_img: {default:"../img/none.jpg"},
		value: {default: "-1"},
		disabled: {default: false}
	},
	computed: {
		isDisabled: {
			get () {
				return this.disabled;
			},
			set (value) {
				this.$emit('update:disabled', value);
			}
		}
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
			this.preview = this.init_img;
			this.buddy = "";
		},
		getIcon(key, value) {
			this.preview = '../img/Another/'+value;
			this.buddy = key;
			this.$emit('update:value', this.buddy);
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
	.img-select{
		width: 30px;
		height: 30px;
		position: relative;
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
	.disabled{
		position: absolute;
		height: 32px;
		width: 32px;
		z-index: 2;
		background-color: rgba(0, 0, 0, 0.4);
	}
</style>