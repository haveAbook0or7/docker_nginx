<template>
	<table border="0">
        <tr>
			<td>Lv</td>
            <td>
                <select-own :id="this.id_name+'_cardlv'" :op="'opCard'" :initial="this.cardLv" ref="cardlv" @up-value="changeData"></select-own>
            </td>
        </tr>
        <tr>
            <td>HP</td>
            <td>
                <input :id="this.id_name+'_hp'" type="text" :value="this.hp" @change="changeData">
            </td>
        </tr>
        <tr>
            <td>ATK</td>
            <td>
                <input :id="this.id_name+'_atk'" type="text" :value="this.atk" @change="changeData">
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
        init_lv: {default: 0},
        init_hp: {default: 0},
        init_atk: {default: 0},
	},
	data: function () {
		return {
			cardLv: this.init_lv,
            hp: this.init_hp,
            atk: this.init_atk,
		}
	},
	methods: {
        changeData(){
            this.$emit('change', this.id_name);
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
</style>