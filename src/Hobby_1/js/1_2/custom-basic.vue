<template>
	<table border="0" :class="media" :style="variable">
        <tr>
			<td>Lv</td>
            <td>
                <select-own :id="this.id_name+'_cardlv'" :op="'opCard'" :initial="cardLv" :disabled="this.disabled" ref="cardlv" @up-value="changeData"></select-own>
            </td>
        </tr>
        <tr>
            <td>HP</td>
            <td>
                <input :id="this.id_name+'_hp'" type="text" v-model="hp" :readonly="this.disabled" @change="changeData">
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
    mounted(){
        // 端末の種類取得
		this.media = getMedia();
    },
    computed: {
        variable() {
			switch(this.media){
				case "PC":
					return {
						"--h2H": "48px",
						"--buttonW": "50px",
						"--buttonH": "18px",
						"--buttonR": "32px",
						"--buttonFS": "10px",
						"--updwW": "20px",
						"--updwH": "20px",
						"--resL": "70px",
						"--resFS": "16px",
						"--spaceH": "60px",
						"--cardW": "120px",
					}
				case "TabletPC":
					return {
						"--h2H": "65px",
						"--buttonW": "80px",
						"--buttonH": "36px",
						"--buttonR": "50px",
						"--buttonFS": "16px",
						"--updwW": "40px",
						"--updwH": "40px",
						"--resL": "100px",
						"--resFS": "25px",
						"--spaceH": "80px",
						"--cardW": "200px",
					}
				case "SmartPhone":
					return {
						"--h2H": "",
						"--buttonW": "",
						"--buttonH": "",
						"--buttonR": "",
						"--buttonFS": "",
						"--updwW": "",
						"--updwH": "",
						"--resL": "",
						"--resFS": "",
						"--spaceH": "",
						"--cardW": "",
					}
			}
		},
		disabled: {
            get(){
                // 閲覧モードなら操作できないようにする
                return !this.show_flg;
			}
        }
	},
	data: function () {
		return {
            media: "PC",
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
    table{
		width: 100%;
	}
    td{
        font-size: 20px;
    }
    .select-own{
        height: 30px;
		width: 60px;
    }
    input[type=text]:read-write{
		height: 25px;
		width: 60px;
        font-size: 18px;
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