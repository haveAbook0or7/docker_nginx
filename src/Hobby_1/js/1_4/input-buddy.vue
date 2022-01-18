<template>
	<table border="0">
        <tr>
            <th colspan="3">バディ</th>
        </tr>
        <tr>
            <td><img-select v-model="v_b1_char"></img-select></td>
            <td><img-select v-model="v_b2_char"></img-select></td>
            <td><img-select v-model="v_b3_char"></img-select></td>
        </tr>
        <tr>
            <td><select-option op="opAddB" v-model="b1[0]" @change="$emit('update:b1_type', b1.join('') == '' ? null : b1.join(''))"></select-option></td>
            <td><select-option op="opAddB" v-model="b2[0]" @change="$emit('update:b2_type', b2.join('') == '' ? null : b2.join(''))"></select-option></td>
            <td><select-option op="opAddB" v-model="b3[0]" @change="$emit('update:b3_type', b3.join('') == '' ? null : b3.join(''))"></select-option></td>
        </tr>
        <tr>
            <td><select-option op="opAddB" v-model="b1[1]" @change="$emit('update:b1_type', b1.join('') == '' ? null : b1.join(''))"></select-option></td>
            <td><select-option op="opAddB" v-model="b2[1]" @change="$emit('update:b2_type', b2.join('') == '' ? null : b2.join(''))"></select-option></td>
            <td><select-option op="opAddB" v-model="b3[1]" @change="$emit('update:b3_type', b3.join('') == '' ? null : b3.join(''))"></select-option></td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
        'select-option': httpVueLoader('../select-option.vue'),
        'img-select': httpVueLoader('./img-select.vue')
    },
	props: {
        b1_char: {default: -1},
        b2_char: {default: -1},
        b3_char: {default: -1},
        b1_type: {default: null},
        b2_type: {default: null},
        b3_type: {default: null},
	},
    computed: {
		v_b1_char:{
			get(){return this.$props.b1_char},
			set(value){
				this.$emit('update:b1_char', value)
			}
		},
		v_b2_char:{
			get(){return this.$props.b2_char},
			set(value){
				this.$emit('update:b2_char', value)
			}
		},
        v_b3_char:{
			get(){return this.$props.b3_char},
			set(value){
				this.$emit('update:b3_char', value)
			}
		}
	},
    data:()=>{
        return{
            b1: ["", ""],
            b2: ["", ""],
            b3: ["", ""],
        }
    }
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
    *{
		background: #2e2930;
		color: white;
	}
    table{
        border-collapse: collapse;
    }
    th{
        height: 25px;
        background: rgba(255, 255, 255, 0.1);
    }
    .img-select{
        margin: 0 auto;
    }
</style>