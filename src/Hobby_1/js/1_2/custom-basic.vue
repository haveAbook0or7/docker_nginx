<template>
	<table border="0">
        <tr>
			<td>Lv</td>
            <td>
                <select-own :id="this.id_name+'_cardlv'" :op="'opCard'" :initial="cardLv" :disabled="this.disabled" ref="cardlv" @up-value="changeData"></select-own>
            </td>
        </tr>
        <tr>
            <td>HP</td>
            <td>
                <input :id="this.id_name+'_hp'" type="text" ref="uu" v-model="hp" :readonly="this.disabled" @change="changeData">
            </td>
        </tr>
        <tr>
            <td>ATK</td>
            <td>
                <input :id="this.id_name+'_atk'" type="text" v-model="atk" :readonly="this.disabled" @change="changeData">
            </td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
        'select-own': httpVueLoader('../select-own.vue'),
    },
	props: {
		id_name: {default:"own"},
        show_flg: {default: true},
        init_lv: {default: 0},
        init_hp: {default: 0},
        init_atk: {default: 0},
	},
    computed: {
		disabled: {
            get(){
                // 閲覧モードなら操作できないようにする
                return !this.show_flg;
			}
        }
	},
	data: function () {
		return {
			cardLv: this.init_lv,
            hp: this.init_hp,
            atk: this.init_atk,
		}
	},
	methods: {
        changeData(id, value){
            if(id == this.id_name+'_cardlv'){
                this.cardLv = value;
            }
            this.$emit('change', this.id_name, "basic",  {cardLv: parseInt(this.cardLv), hp: parseInt(this.hp), atk: parseInt(this.atk)});
        },
        getData(){
            return {cardLv: this.cardLv, hp: this.hp, atk: this.atk};
        }
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
    *{
		background: #2e2930;
		color: white;
	}
    input[type=text]:read-write{
		height: 18px;
		width: 40px;
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
		border-radius: 2px;
        caret-color: #2e2930;
	}
    input[type=text]:read-only{
		height: 18px;
		width: 40px;
		border: 1px solid #aaaaaa;
		border-radius: 2px;
	}
</style>