<template>
	<div>
		<img v-for="(char, index) in charArray" 
			:src="'../img/Another/'+imgChar[char]" 
			:key="index" 
			@click="$emit('change', char)" 
			alt="" width="30" height="30">
	</div>
</template>

<script>
module.exports = {
	model: {
		prop: 'value',
		event: 'change'
	},
	props: {
		value: {default: "-1"}
	},
	data: ()=>{
		return {
			charArray: [
				11, 12, 13, 14, 15,
				21, 22, 23,
				31, 32, 33,
				41, 42,
				51, 52, 53,
				61, 62,
				71, 72, 73, 74,
				82, -1
			],
			imgChar: {
				11: '11.jpg', 12: '12.jpg', 13: '13.jpg', 14: '14.jpg', 15: '15.jpg',
				21: '21.jpg', 22: '22.jpg', 23: '23.jpg',
				31: '31.jpg', 32: '32.jpg', 33: '33.jpg',
				41: '41.jpg', 42: '42.jpg',
				51: '51.jpg', 52: '52.jpg', 53: '53.jpg',
				61: '61.jpg', 62: '62.jpg',
				71: '71.jpg', 72: '72.jpg', 73: '73.jpg', 74: '74.jpg',
				82: '82.jpg', "-1": 'none.jpg'
			}
		}
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