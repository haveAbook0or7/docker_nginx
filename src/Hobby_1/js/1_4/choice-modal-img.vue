<template>
	<div>
		<img v-for="buddy in buddyImg" 
			:src="'../img/Another/'+buddy.value" 
			:key="buddy.key" 
			@click="sendIcon(buddy.key, buddy.value)" 
			alt="" width="30" height="30">
	</div>
</template>

<script>
module.exports = {
	props: {
	},
	data: function () {
		let b = [{key: -1, value: 'none.jpg'}];
		return {
			buddyImg: [
				{key: 11, value: '11.jpg'},{key: 12, value: '12.jpg'},{key: 13, value: '13.jpg'},{key: 14, value: '14.jpg'},{key: 15, value: '15.jpg'},
				{key: 21, value: '21.jpg'},{key: 22, value: '22.jpg'},{key: 23, value: '23.jpg'},
				{key: 31, value: '31.jpg'},{key: 32, value: '32.jpg'},{key: 33, value: '33.jpg'},
				{key: 41, value: '41.jpg'},{key: 42, value: '42.jpg'},
				{key: 51, value: '51.jpg'},{key: 52, value: '52.jpg'},{key: 53, value: '53.jpg'},
				{key: 61, value: '61.jpg'},{key: 62, value: '62.jpg'},
				{key: 71, value: '71.jpg'},{key: 72, value: '72.jpg'},{key: 73, value: '73.jpg'},{key: 74, value: '74.jpg'},
				{key: 82, value: '82.jpg'},
				{key: -1, value: 'none.jpg'}
			],
			imgBuddy: {
				11: '11.jpg', 12: '12.jpg', 13: '13.jpg', 14: '14.jpg', 15: '15.jpg',
				21: '21.jpg', 22: '22.jpg', 23: '23.jpg',
				31: '31.jpg', 32: '32.jpg', 33: '33.jpg',
				41: '41.jpg', 42: '42.jpg',
				51: '51.jpg', 52: '52.jpg', 53: '53.jpg',
				61: '61.jpg', 62: '62.jpg',
				71: '71.jpg', 72: '72.jpg', 73: '73.jpg', 74: '74.jpg',
				82: '82.jpg', 99: 'none.jpg'
			},
			showFlg: true,
		}
	},
	methods:{
		sendIcon(key, value){
			/** クリックしたアイコンを親コンポーネントに送る */
			this.$emit('catch-icon', key, value);
		},
	}
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
		margin: 0;
		padding: 0;
		border: 0;
		font-size: 13px;
		text-align: left;
	}
	div{
		width: 180px;
		height: 210px;
		display: inline-block;
		position: absolute;
		top: 32px;
		left: 0;
		padding: 3px;
		border: 2px solid #e6b422;
		background-color: #2e2930;
		z-index: 1;
	}
	img{
		margin: 2px;
		border: 1px solid black;
	}
</style>