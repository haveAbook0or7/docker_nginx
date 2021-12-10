<template>
	<div>
        <file-select class="imgfile" @change="getFile"></file-select>
        <span class="no">
            <label class="text">カードNo<input type="text" maxlength="4" v-model.number="v_carc_no"></label>
            <img-select :value.sync="this.char_no" @update:value="$emit('update:char_no', this.char_no)"></img-select>
        </span>
    </div>
</template>

<script>
module.exports = {
	components: {
        'file-select': httpVueLoader('./file-select.vue'),
        'img-select': httpVueLoader('./img-select.vue')
    },
	props: {
		card_no: {default: null},
		char_no: {default: "-1"},
		img_file: {default: null},
		img_name: {default: null}
	},
    computed: {
		v_carc_no:{
			get(){return this.$props.card_no},
			set(value){this.$emit('update:card_no', value)}
		}
	},
	methods: {
        getFile(filejpeg, filename){
			this.$emit('update:img_file', filejpeg);
			this.$emit('update:img_name', filename);
        },
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
    *{
		background: #2e2930;
		color: white;
	}
	div{
		text-align: left;
		display: flex;
		justify-content: space-between;
	}
	.no{
		display: flex;
		justify-content: flex-end;
		align-items: flex-end;
	}
	.text{
		margin-bottom: 15px;
	}
    input[type=text]:read-write{
		height: 18px;
		width: 30px;
		text-align: right;
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
		border-radius: 2px;
        caret-color: #2e2930;
		outline: none;
	}
	.img-select{
		margin: 10px;
	}
</style>