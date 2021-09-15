<template>
	<table border="0" :id="this.id_name+'_TMagic'">
        <tr>
            <td colspan="2">
				<label><input :id="this.id_name+'_MtORf'+this.m" type="checkbox" value="0" checked>使用する</label>
            </td>
        </tr>
        <tr>
            <td class="col1">
				M{{this.m}}<input :id="this.id_name+'_d'+this.m" class="text" type="text" :value="this.basicDamage" readonly="readonly">
			</td>
            <td class="col1">
				Lv<select-own :id="this.id_name+'_mlv'+this.m" :op="'opLv'" ref="mlv"></select-own>
            </td>
        </tr>
        <tr>
            <td class="col1">
				有利<input :id="this.id_name+'_ADd'+this.m" class="text" type="text" :value="this.advanDamage" readonly>
            </td>
			<td class="col1">
				不利<input :id="this.id_name+'_DISd'+this.m" class="text" type="text" :value="this.disadDamage" readonly>
            </td>
        </tr>
        <tr>
			<td colspan="2" class="col2">
				<input :id="this.id_name+'_buf'+this.m+'_1'" type="checkbox" value="0" v-model="this.bufmain">
				<label :for="this.id_name+'_buf'+this.m+'_1'" >
					{{bufMain_1}}<br>{{bufMain_2}}
				</label>
			</td>
        </tr>
        <tr>
            <td colspan="2" class="col2">
				<input :id="this.id_name+'_buf'+this.m+'_2'" type="checkbox" value="0" v-model="this.bufsub">
				<label :for="this.id_name+'_buf'+this.m+'_2'">
					{{bufSub_1}}<br>{{bufSub_2}}
				</label>
			</td>
        </tr>
        <tr style="height: 20px;">
			<td :id="this.id_name+'_bufA'+this.m" colspan="2"></td>
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
		m: {default:"1"}
	},
	data: function () {
		return {
			effect1: {
				au: "ATK UP", du: "ﾀﾞﾒｰｼﾞ UP", ad: "ATK DOWN", dd: "ﾀﾞﾒｰｼﾞ DOWN", 
				re: "HP回復", cr: "HP継続回復", td: "被ﾀﾞﾒ DOWN",
				fu: "火ﾀﾞﾒ UP", tu: "木ﾀﾞﾒ UP", wu: "水ﾀﾞﾒ UP", nu: "無ﾀﾞﾒ UP", 
				ev: "回避", cu: "呪い",
				duo: "デュオ魔法", nN: "なし", n: "",
			},
			effect2: {n: "", s: "極小", S: "小", M: "中", L: "大"},
			effect3: {n: "", 1: "1T", 2: "2T", 3: "3T"},
			values: {},
            chnos: [],
			bufmain: true,
			bufsub: false,
			mMlv: 0,
			mSlv: 0,
			main: "",
			sub: "",
			masic: "",
			basicDamage: 0,
			advanDamage: 0,
			disadDamage: 0,
			bufMain_1: "**********",
			bufMain_2: "**********",
			bufSub_1: "**********",
			bufSub_2: "**********",
		}
	},
	methods: {
		applyMbuf(values){
			this.values = values;
			var lv = [0,1,1,1,1,5,5,5,5,5,10];
			var msub = this.m == 1 ? 2 : 1 ;
			// レベル抽出
			this.mMlv = lv[values["m"+this.m+"lv"]];
			this.mSlv = lv[values["m"+msub+"lv"]];
			this.$refs["mlv"].chengeValue(this.mMlv);
			// レベルに応じたバフ抽出
			this.main = values["m"+this.m+"buf_"+this.mMlv];
			this.sub = values["m"+msub+"buf_"+this.mSlv];
			this.masic = values["m"+this.m+"_"+this.mMlv];
			// この魔法のバフ
			if(isFinite(this.main)){
				// デュオ魔法
				this.bufMain_1 = this.effect1.duo;
			}else{
				this.bufMain_1 = this.effect1[this.main[0]+this.main[1]] + this.effect2[this.main[2]] +this.effect3[this.main[3]];
			}
			this.bufMain_2 = "**********";
			if(this.main.length == 8){
				this.bufMain_2 = this.effect1[this.main[4]+this.main[5]] + this.effect2[this.main[6]] +this.effect3[this.main[7]];
			}
			// もうひとつの魔法のバフ
			this.bufSub_1 = "**********";
			this.bufSub_2 = "**********";
			if(this.sub[0]+this.sub[1] == "au" || this.sub[0]+this.sub[1] == "du"){
				if(isFinite(this.sub)){
					// デュオ魔法
					this.bufSub_1 = this.effect1.duo;
				}else{
					this.bufSub_1 = this.effect1[this.sub[0]+this.sub[1]] + this.effect2[this.sub[2]] +this.effect3[this.sub[3]];
				}
			}
			if(this.sub[4]+this.sub[5] == "au" || this.sub[4]+this.sub[5] == "du"){
				if(this.sub.length == 8){
					this.bufSub_2 = this.effect1[this.sub[4]+this.sub[5]] + this.effect2[this.sub[6]] +this.effect3[this.sub[7]];
				}
			}
		},
		changeBuf(hpbuf, atkbuf){
			console.log(hpbuf);
			console.log(atkbuf);
			var calc = {d: 0, atkMag: atkbuf, dMag: 0, cor: 0, att: 0, ram: 0};
			if(this.bufmain){
				// ATKバフをatkMagに加算
				console.log(this.bufmain);
				console.log(this.main[0]+this.main[1]);
				if(this.main[0]+this.main[1] == "au"){
					console.log(this.main[0]+this.main[1]);
					switch(this.main[2]){
						case "s" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((5 + 0.5 * this.mMlv) / 100);
							break;
						case "S" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((10 + 1 * this.mMlv) / 100);
							break;
						case "M" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((20 + 1.5 * this.mMlv) / 100);
							break;
						case "L" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((30 + 2 * this.mMlv) / 100);
							break;
					}          
				}
				// 攻撃倍率をdMagに加算
				switch(this.masic[1]){
					case "S" :
						calc.dMag += (50 + 2.5 * this.mMlv) / 100;
						break;
					case "L" :
						// calc.dMag += (62.5 + 3.75 * lv) / 100;
						calc.dMag += (60 + 4 * this.mMlv) / 100; // 参考文献によって少し違う
						break;
				}
				// 攻撃倍率に無属性補正をかける
				if(this.masic[0] == 0){ // 無属性なら攻撃倍率を補正する
					calc.dMag *= 1.1;
				}
				// ダメージバフをdMagに加算
				if(this.main[0]+this.main[1] == "du"){ // ダメージUPか判断
					switch(this.main[2]){
						case "s" :
							calc.dMag = parseFloat(calc.dMag,10) + ((1.25 + 0.125 * this.mMlv) / 100);
							break;
						case "S" :
							calc.dMag = parseFloat(calc.dMag,10) + ((2.5 + 0.25 * this.mMlv) / 100);
							break;
						case "M" :
							calc.dMag = parseFloat(calc.dMag,10) + ((5 + 0.375 * this.mMlv) / 100);
							break;
						case "L" :
							calc.dMag = parseFloat(calc.dMag,10) + ((7.5 + 0.5 * this.mMlv) / 100);
							break;
					}            
				}
				// 属性ダメージUPをdMagに加算
				console.log(calc);
				// 想定ダメージをDに算出
			}
			

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
		font-size: 13px;
		background: palevioletred;
	}
	tr{
		background: rgba(255,255,255,0.3);
	}
	.col1{
		font-size: 10px;
		text-align: center;
	}
	.col2{
		height: 40px;
	}
	.text{
		height: 1.5em;
		width: 40px;
		background: #b3ada0;
	}
</style>