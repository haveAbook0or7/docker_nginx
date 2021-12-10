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
	beforeCreate() {
		this.buddyImg = {
			11: '11.jpg', 12: '12.jpg', 13: '13.jpg', 14: '14.jpg', 15: '15.jpg',
			21: '21.jpg', 22: '22.jpg', 23: '23.jpg',
			31: '31.jpg', 32: '32.jpg', 33: '33.jpg',
			41: '41.jpg', 42: '42.jpg',
			51: '51.jpg', 52: '52.jpg', 53: '53.jpg',
			61: '61.jpg', 62: '62.jpg',
			71: '71.jpg', 72: '72.jpg', 73: '73.jpg', 74: '74.jpg',
			82: '82.jpg',
			"-1": 'none.jpg', 
		};
	},
	props: {
		value: {default: "-1"},
		disabled: {default: false}
	},
	computed: {
		isDisabled: {
			get () {
				console.log(this.disabled)
				if(this.disabled){
					this.getIcon("-1", 'none.jpg');
				}
				return this.disabled;
			},
			set (value) {
				this.$emit('update:disabled', value);
			}
		}
	},
	data: function () {
		return {
			preview: "../img/Another/"+this.buddyImg[this.value],
			buddy: "",
			showFlg: false,
			buddyImg: {}
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
			this.$emit('select', this.buddy);
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