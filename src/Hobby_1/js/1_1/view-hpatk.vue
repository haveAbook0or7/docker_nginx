<template>
	<table border="0" class="THpAtk">
        <tr>
            <td colspan="3" style="text-align: center;">
                <input type="button" class="button" value="MAX" @click="clickMAX('max')">
                <input type="button" class="button" value="無凸MAX" @click="clickMAX('middle')">
            </td>
        </tr>
        <tr>
            <td class="lbl">HP</td>
            <td>
                <input :id="this.id_name+'_hpbuf'" class="text" type="text" :value="this.hpbuf" readonly>
            </td>
            <td>
                <input :id="this.id_name+'_hp'" class="textOn" type="text" :value="this.hp" @change="changeBasicValue">
            </td>
        </tr>
        <tr>
            <td class="lbl">ATK</td>
            <td>
                <input :id="this.id_name+'_atkbuf'" class="text" type="text" :value="this.atkbuf" readonly>
            </td>
            <td>
                <input :id="this.id_name+'_atk'" class="textOn" type="text" :value="this.atk" @change="changeBasicValue">
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
			BuddyLv: {
                As : [0.11, 0.12, 0.13, 0.14, 0.15, 0.16, 0.17, 0.18, 0.19, 0.2],
                Am : [0.215, 0.23, 0.245, 0.26, 0.275, 0.29, 0.305, 0.32, 0.335, 0.35],
                Hs : [0.11, 0.12, 0.13, 0.14, 0.15, 0.16, 0.17, 0.18, 0.19, 0.2],
                Hm : [0.21, 0.22, 0.23, 0.24, 0.25, 0.26, 0.27, 0.28, 0.29, 0.3]
            },
            values: {},
            chnos: [],
            hp: 0,
            atk: 0,
            hpbuf: 0,
            atkbuf: 0,
		}
	},
	methods: {
        // 受け取ったデータを保存
        applyHPATK(values){
            this.values = values;
            this.hp = values.hp;
            this.atk = values.atk;
        },
        // バディ補正ステータスを計算して表示して親に戻す
        changeBuddy(chnos){
            // 現在セットしてるキャラクターIDを取得
            this.chnos = chnos;
            // 計算用変数
            mag = {A: 0, H: 0};
            flg = {1: false, 2: false, 3: false};
            // バディが成立していたら補正倍率を追加
            for(var i = 0; i < 5; i++){
            for(var j = 1; j <= 3; j++){
                if(this.values["b"+j] == chnos[i] && !flg[j]){
                    var Btype = this.values["b"+j+"type"];
                    var Blv = this.values["b"+j+"lv"];
                    mag[Btype[0]] += this.BuddyLv[Btype[0]+Btype[1]][Blv - 1];
                    if(Btype.length == 4){
                        mag[Btype[2]] += this.BuddyLv[Btype[2]+Btype[3]][Blv - 1];
                    }
                    flg[j] = true;
                }
            }
            }
            // 補正して表示
            this.hpbuf = this.hp * (mag["H"] + 1);
            this.atkbuf = this.atk * (mag["A"] + 1);
            // 親にも値を送る
            this.$emit('extract', this.id_name, this.hpbuf, this.atkbuf);
        },
        // MAX,無凸MAXステータス取得時
        clickMAX(which){
            switch(which){
                case "max":
                    this.sendBasicValue(this.id_name, this.values.hpmax, this.values.atkmax);
                    break;
                case "middle":
                    this.sendBasicValue(this.id_name, this.values.hpmiddle, this.values.atkmiddle);
                    break;
            }
        },
        // 手動で値をいじる時
        changeBasicValue(event){
            var sendHp = this.hp;
            var sendAtk = this.atk;
            if(event.target.id[6] == "h"){
                sendHp = event.target.value;
            }else{
                sendAtk = event.target.value;
            }
            this.sendBasicValue(this.id_name, sendHp, sendAtk);
        },
        // 変更した値を親に送る用
        sendBasicValue(card, hp, atk){
            this.$emit('change-basic', card, hp, atk);
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
	table{
		background: palevioletred;
	}
	.text{
		height: 1.5em;
		width: 40px;
		background: #b3ada0;
	}
    .textOn{
		height: 1.5em;
        width: 40px;
        background: white;
        border: 2px solid #e6b422; 
	}
    .button{
        width: 50px;
        height: 18px;
        display: inline-block;
        text-align: center;
        background-color: #e6b422;
        font-size: 10px;
        color: rgb(255, 255, 255);
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed rgb(255, 255, 255);
        margin: 0 2px;
        box-shadow: #e6b422 0px 0px 0px 3px;
    }
    .button:hover {
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
        /* border-style: solid; */
    }
</style>