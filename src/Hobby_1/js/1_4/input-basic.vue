<template>
	<table border="0">
        <tr>
            <th class="left"></th><th>Lv1</th><th>無凸MAX</th><th>MAX</th>
        </tr>
        <tr>
            <th class="left">Lv</th>
            <td><select-option op="opAddCard" v-model="this.lv_1" @change="$emit('update:lv_1', this.lv_1)"></select-option></td>
            <td><select-option op="opAddCard" v-model="this.lv_mid" @change="$emit('update:lv_mid', this.lv_mid)"></select-option></td>
            <td><select-option op="opAddCard" v-model="this.lv_max" @change="$emit('update:lv_max', this.lv_max)"></select-option></td>
        </tr>
        <tr>
            <th class="left">HP</th>
            <td><input type="text" maxlength="5" v-model.number="v_hp_1"></td>
            <td><input type="text" maxlength="5" v-model.number="v_hp_mid"></td>
            <td><input type="text" maxlength="5" v-model.number="v_hp_max"></td>
        </tr>
        <tr>
            <th class="left">ATK</th>
            <td><input type="text" maxlength="5" v-model.number="v_atk_1"></td>
            <td><input type="text" maxlength="5" v-model.number="v_atk_mid"></td>
            <td><input type="text" maxlength="5" v-model.number="v_atk_max"></td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
        'select-option': httpVueLoader('../select-option.vue'),
    },
	props: {
        lv_1: {default: 0},
        lv_mid: {default: 0},
        lv_max: {default: 0},
        hp_1: {default: 0},
        hp_mid: {default: 0},
        hp_max: {default: 0},
        atk_1: {default: 0},
        atk_mid: {default: 0},
        atk_max: {default: 0},
	},
    computed: {
		v_hp_1:{
			get(){return this.$props.hp_1},
			set(value){
				const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
					this.$emit('update:hp_1', value)
				}
			}
		},
		v_hp_mid:{
			get(){return this.$props.hp_mid},
			set(value){
				const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
					this.$emit('update:hp_mid', value)
				}
			}
		},
        v_hp_max:{
			get(){return this.$props.hp_max},
			set(value){
				const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
					this.$emit('update:hp_max', value)
				}
			}
		},
        v_atk_1:{
			get(){return this.$props.atk_1},
			set(value){
				const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
					this.$emit('update:atk_1', value)
				}
			}
		},
		v_atk_mid:{
			get(){return this.$props.atk_mid},
			set(value){
				const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
					this.$emit('update:atk_mid', value)
				}
			}
		},
        v_atk_max:{
			get(){return this.$props.atk_max},
			set(value){
				const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
					this.$emit('update:atk_max', value)
				}
			}
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
    table{
        border-collapse: collapse;
    }
    th{
        height: 25px;
        background: rgba(255, 255, 255, 0.1);
    }
    .left{
        width: 55px;
    }
    td{
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-right-width: 2px;
    }
    input[type=text]:read-write{
		height: 18px;
		width: 50px;
		text-align: right;
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
		border-radius: 2px;
        caret-color: #2e2930;
	}
</style>