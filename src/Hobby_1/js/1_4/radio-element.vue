<template>
	<div class="radio-element">
		<span v-for="item in items" :key="item.key">
			<input type="radio" :id="id+item.value" :name="id" :value="item.value" v-model="selected">
			<label :for="id+item.value">
				<img :src="'../img/Element/'+item.key" width="32" height="32">
			</label>
		</span>
	</div>
</template>

<script>
module.exports = {
	model: {
		prop: 'element',
		event: 'change'
	},
	props: {
		id: {default:"radio", required: true},
		element: {default: 0},
	},
	computed: {
		selected:{
			get(){return this.$props.element},
			set(value){this.$emit('change', value)}
		}
	},
	data: function () {
		return {
			items: [
				{key: "Nomal.jpg", value: "0"},
				{key: "Fire.jpg", value: "1"},
				{key: "Tree.jpg", value: "2"},
				{key: "Water.jpg", value: "3"},
			],
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
	}
	div{
		text-align: center;
	}
	span{
		display: inline-flex;
		justify-content: center;
		align-items: center;
		margin: 5px;
	}
    input[type=radio] {
		display:none; 
    }
    label {
		width: 32px;
		height: 32px;
    }
	img{
		opacity: 0.5;
	}
	input[type=radio]:checked + label img{
		box-sizing: border-box;
		border: 2px inset #e6b422;
		opacity: 1;
	}
</style>