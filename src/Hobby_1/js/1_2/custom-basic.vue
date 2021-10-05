<template>
	<table border="0">
        <tr>
			<td>Lv</td>
            <td>
                <select-own :id="this.id_name+'_cardlv'" :op="'opCard'" ref="cardlv" @up-value="changeLv"></select-own>
            </td>
        </tr>
        <tr>
            <td>HP</td>
            <td>
                <input :id="this.id_name+'_hp'" type="text" :value="this.hp">
            </td>
        </tr>
        <tr>
            <td>ATK</td>
            <td>
                <input :id="this.id_name+'_atk'" type="text" :value="this.atk">
            </td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
		// 'select-own': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/select-own.vue'),
        'select-own': httpVueLoader('http://localhost:8080/Hobby_1/js/select-own.vue'),
    },
	props: {
		id_name: {default:"myselectimg"},
	},
	data: function () {
		return {
			cardLv: 0,
            hp: 0,
            atk: 0,
		}
	},
	methods: {
        // 受け取ったデータを保存
        applyHPATK(values){
            this.cardLv = values;
            this.hp = values.hp;
            this.atk = values.atk;
        },
		changeLv(value){

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