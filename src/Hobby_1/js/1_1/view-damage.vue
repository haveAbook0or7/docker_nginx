<template>
	<table border="0" :id="this.id_name+'_TMagic'" class="view-damage" :style="variable">
        <tr>
            <td colspan="2">
				<input :id="this.id_name+'_MtORf'+this.m" type="checkbox" v-model="isUse" @change="changeUse">
				<label :for="this.id_name+'_MtORf'+this.m">使用する<span></span></label>
            </td>
        </tr>
        <tr>
            <td class="tds">
				M{{this.m}}<input :id="this.id_name+'_d'+this.m" type="text" :value="this.basicDamage" readonly>
			</td>
            <td class="tds">
				Lv<select-own :id="this.id_name+'_mlv'+this.m" :op="'opLv'" ref="mlv" @up-value="changeMasicLv"></select-own>
            </td>
        </tr>
        <tr>
            <td class="tds">
				有利<input :id="this.id_name+'_ADd'+this.m" type="text" :value="this.advanDamage" readonly>
            </td>
			<td class="tds">
				不利<input :id="this.id_name+'_DISd'+this.m" type="text" :value="this.disadDamage" readonly>
            </td>
        </tr>
        <tr>
			<td colspan="2">
				<input :id="this.id_name+'_buf'+this.m+'_1'" type="checkbox" v-model="bufmain" @change="changeBuf">
				<label :for="this.id_name+'_buf'+this.m+'_1'" >
					{{bufMain_1}}<br>{{bufMain_2}}<span class="a"></span>
				</label>
			</td>
        </tr>
        <tr>
            <td colspan="2">
				<input :id="this.id_name+'_buf'+this.m+'_2'" type="checkbox" :disabled="isDisabledS" v-model="bufsub" @change="changeBuf">
				<label :for="this.id_name+'_buf'+this.m+'_2'">
					{{bufSub_1}}<br>{{bufSub_2}}<span></span>
				</label>
			</td>
        </tr>
        <tr style="height: 20px;">
			<td :id="this.id_name+'_bufA'+this.m" colspan="2">
				<input :id="this.id_name+'_bufA'+this.m+'_1'" type="checkbox" :disabled="isDisabledA1" v-model="bufA1" @change="changeBuf">
				<label :for="this.id_name+'_bufA'+this.m+'_1'">{{bufA_1}}<span></span></label>
				<input :id="this.id_name+'_bufA'+this.m+'_2'" type="checkbox" :disabled="isDisabledA2" v-model="bufA2" @change="changeBuf">
				<label :for="this.id_name+'_bufA'+this.m+'_2'">{{bufA_2}}<span></span></label>
				<input :id="this.id_name+'_bufA'+this.m+'_3'" type="checkbox" :disabled="isDisabledA3" v-model="bufA3" @change="changeBuf">
				<label :for="this.id_name+'_bufA'+this.m+'_3'">{{bufA_3}}<span></span></label>
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
		id_name: {default:"myselectimg"},
		m: {default:"1"},
		media: {default: "PCH"},
	},
	computed: {
		
		variable() {
			let styles = {
				"--dynamic-color": this.colors
			};
			switch(this.media.slice(0, -1)){
				case "PC":
					Object.assign(styles, {
						"--FS": "12px",
						"--textW": "40px",
						"--textH": "18px",
                        "--selectW": "initial",
						"--selectH": "initial",
					});
					break;
				case "TabletPC":
					Object.assign(styles, {
						"--FS": "16px",
						"--textW": "60px",
						"--textH": "25px",
                        "--selectW": "60px",
						"--selectH": "26px",
					});
					break;
				case "SmartPhone":
					Object.assign(styles, {
						"--FS": "18px",
						"--textW": "60px",
						"--textH": "20px",
                        "--selectW": "60px",
						"--selectH": "28px",
					});
					break;
			}
			return styles;
		},
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
			isUse: true,
			bufmain: true,
			bufsub: false,
			isDisabledS: false,
			bufA1: false,
			isDisabledA1: true,
			bufA2: false,
			isDisabledA2: true,
			bufA3: false,
			isDisabledA3: true,

			mMlv: 0,
			mSlv: 0,
			main: "",
			sub: "",
			A_1lv: 0,
			A_2lv: 0,
			A_3lv: 0,
			A_1: "",
			A_2: "",
			A_3: "",

			masic: "",

			basicDamage: 0,
			advanDamage: 0,
			disadDamage: 0,
			bufMain_1: "**********",
			bufMain_2: "**********",
			bufSub_1: "**********",
			bufSub_2: "**********",
			bufA_1: "**********",
			bufA_2: "**********",
			bufA_3: "**********",

			colors: "#705b67"
		}
	},
	methods: {
		// 受け取ったデータを保存。表示できるやつは表示
		applyMbuf(values){
			this.values = values;
			// 計算用変数
			var lv = [0,1,1,1,1,5,5,5,5,5,10];
			var colorList = ["#a58f86", "#ea5506", "#c3d825", "#0094c8"];
			var msub = this.m == 1 ? 2 : 1 ; // もう一つの魔法
			// レベル抽出
			this.mMlv = lv[values["m"+this.m+"lv"]];
			this.mSlv = lv[values["m"+msub+"lv"]];
			// 魔法レベルを表示
			this.$refs["mlv"].chengeValue(values["m"+this.m+"lv"]);
			// レベルに応じたバフと魔法抽出
			this.main = values["m"+this.m+"buf_"+this.mMlv];
			this.sub = values["m"+msub+"buf_"+this.mSlv];
			this.masic = values["m"+this.m+"_"+this.mMlv];
			// この魔法のバフを表示
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
			this.colors = colorList[this.masic[0]];
			this.$refs["mlv"].chengeUnderC(this.colors);
			// もうひとつの魔法のバフを表示
			// こちらはATKUPかダメージUPだけ表示
			// 影響するバフがない場合はチェックボックスを無効化する
			this.bufSub_1 = "**********";
			this.bufSub_2 = "**********";
			var flg = true;
			if(this.sub[0]+this.sub[1] == "au" || this.sub[0]+this.sub[1] == "du"){
				flg = false;
				this.bufSub_1 = this.effect1[this.sub[0]+this.sub[1]] + this.effect2[this.sub[2]] +this.effect3[this.sub[3]];
			}
			if(this.sub[4]+this.sub[5] == "au" || this.sub[4]+this.sub[5] == "du"){
				if(this.sub.length == 8){
					flg = false;
					this.bufSub_2 = this.effect1[this.sub[4]+this.sub[5]] + this.effect2[this.sub[6]] +this.effect3[this.sub[7]];
				}
			}
			if(flg){
				this.bufsub = false;
			}
			this.isDisabledS = flg;
			// this.changeAttribute();
		},
		// 属性バフを初期化する
		clearAttribute(){
			for(var i = 1; i <= 3; i++){
				this["A_"+i] = "";
				this["A_"+i+"Lv"] = 0;
				this["bufA_"+i] = "**********";
				this["bufA"+i] = false;
				this["isDisabledA"+i] = true;
			}
		},
		// この魔法が属性バフなら他に付与するフラグを送る
		changeAttribute(){
			// 属性ダメージUP
			if( this.main[0]+this.main[1] == "fu" || 
				this.main[0]+this.main[1] == "tu" || 
				this.main[0]+this.main[1] == "wu" || 
				this.main[0]+this.main[1] == "nu"){
					this.$emit('attribute', this.id_name, this.m, this.main, this.mMlv);
			}
		},
		// セットしてるカードに属性バフがある場合、この魔法が付与対象か判断して付与する
		getAttribute(attribute, lv){
			// 変換用変数
			var att = {f: 1, t: 2, w: 3, n: 0};
			var flg = false;
			if(this.masic[0] == att[attribute[0]]){
				// console.log("GETif "+this.id_name+" "+this.m+"::yes:");
				for(var i = 1; i <= 3; i++){
					if(flg){ // 残りのチェックボックスを無効化する
						this["isDisabledA"+i] = true;
						continue;
					}
					if(this["A_"+i] == "" && !flg){
						this["A_"+i] = attribute;
						this["A_"+i+"Lv"] = lv;
						this["bufA_"+i] = this.effect1[attribute[0]+attribute[1]] + this.effect2[attribute[2]] +this.effect3[attribute[3]];
						this["isDisabledA"+i] = false;
						flg = true;
					}
					
				}
			}
		},
		// ダメージ計算
		calcDamage(values, chnos){
			this.values = values;
			this.chnos = chnos;
			// 計算用変数
			var calc = {d: 0, atkMag: this.values.atkbuf, dMag: 0, cor: 0, att: 0, ram: 0};
			// この魔法のバフ
			if(this.bufmain){
				// ATKバフをatkMagに加算
				if(this.main[0]+this.main[1] == "au"){
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
				// ダメージバフをdMagに加算
				if(this.main[0]+this.main[1] == "du"){
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
				if(this.main.length == 8){
					// ATKバフをatkMagに加算
					if(this.main[4]+this.main[5] == "au"){
						switch(this.main[6]){
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
					// ダメージバフをdMagに加算
					if(this.main[4]+this.main[5] == "du"){
						switch(this.main[6]){
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
				}
			}
			// もう一つの魔法のバフ
			if(this.bufsub){
				// ATKバフをatkMagに加算
				if(this.sub[0]+this.sub[1] == "au"){
					switch(this.sub[2]){
						case "s" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((5 + 0.5 * this.mSlv) / 100);
							break;
						case "S" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((10 + 1 * this.mSlv) / 100);
							break;
						case "M" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((20 + 1.5 * this.mSlv) / 100);
							break;
						case "L" :
							calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((30 + 2 * this.mSlv) / 100);
							break;
					}          
				}
				// ダメージバフをdMagに加算
				if(this.sub[0]+this.sub[1] == "du"){
					switch(this.sub[2]){
						case "s" :
							calc.dMag = parseFloat(calc.dMag,10) + ((1.25 + 0.125 * this.mSlv) / 100);
							break;
						case "S" :
							calc.dMag = parseFloat(calc.dMag,10) + ((2.5 + 0.25 * this.mSlv) / 100);
							break;
						case "M" :
							calc.dMag = parseFloat(calc.dMag,10) + ((5 + 0.375 * this.mSlv) / 100);
							break;
						case "L" :
							calc.dMag = parseFloat(calc.dMag,10) + ((7.5 + 0.5 * this.mSlv) / 100);
							break;
					}            
				}
				if(this.sub.length == 8){
					// ATKバフをatkMagに加算
					if(this.sub[4]+this.sub[5] == "au"){
						switch(this.sub[6]){
							case "s" :
								calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((5 + 0.5 * this.mSlv) / 100);
								break;
							case "S" :
								calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((10 + 1 * this.mSlv) / 100);
								break;
							case "M" :
								calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((20 + 1.5 * this.mSlv) / 100);
								break;
							case "L" :
								calc.atkMag = parseFloat(calc.atkMag,10) + this.values.atk * ((30 + 2 * this.mSlv) / 100);
								break;
						}          
					}
					// ダメージバフをdMagに加算
					if(this.sub[4]+this.sub[5] == "du"){
						switch(this.sub[6]){
							case "s" :
								calc.dMag = parseFloat(calc.dMag,10) + ((1.25 + 0.125 * this.mSlv) / 100);
								break;
							case "S" :
								calc.dMag = parseFloat(calc.dMag,10) + ((2.5 + 0.25 * this.mSlv) / 100);
								break;
							case "M" :
								calc.dMag = parseFloat(calc.dMag,10) + ((5 + 0.375 * this.mSlv) / 100);
								break;
							case "L" :
								calc.dMag = parseFloat(calc.dMag,10) + ((7.5 + 0.5 * this.mSlv) / 100);
								break;
						}            
					}
				}
			}
			// 攻撃倍率をdMagに加算
			switch(this.masic[1]){
				case "S" :
					calc.dMag += (50 + 2.5 * this.mMlv) / 100;
					break;
				case "L" :
					// calc.dMag += (62.5 + 3.75 * this.mMlv) / 100;
					calc.dMag += (60 + 4 * this.mMlv) / 100; // 参考文献によって少し違う
					break;
			}
			// 攻撃倍率に無属性補正をかける
			if(this.masic[0] == 0){
				calc.dMag *= 1.1;
			}
			// 属性ダメージUPをdMagに加算
			for(var i = 1; i <= 3; i++){
                if(this["bufA"+i]){
					if(!this["A_"+i] == ""){
						switch(this["A_"+i][2]){
							case "s" :
								calc.dMag = parseFloat(calc.dMag) + ((1.5 + 0.15 * this["A_"+i+"Lv"]) / 100);
								break;
							case "S" :
								calc.dMag = parseFloat(calc.dMag) + ((3 + 0.3 * this["A_"+i+"Lv"]) / 100);
								break;
							case "M" :
								calc.dMag = parseFloat(calc.dMag) + ((6 + 0.45 * this["A_"+i+"Lv"]) / 100);
								break;
							case "L" :
								calc.dMag = parseFloat(calc.dMag) + ((9 + 0.6 * this["A_"+i+"Lv"]) / 100);
								break;
						}
					}
                }
            }
			// 想定ダメージをdに算出
			switch(this.masic[2]){
                case "1" :
                    calc.d += calc.atkMag * calc.dMag;
                    break;
                case "2" : //3連について修正する
                    if(isFinite(this.main)){//DUOならこちらで判定
                        var flg = false;
                        for(var i = 0; i < 5; i++){//相方がいるかつバフがtrueか
                            if(this.chnos[i] == this.main && this.bufmain){
                                flg = true;
                            }
                        }
                        if(flg){ // 居たら3連
                            calc.d += (calc.atkMag * calc.dMag * 0.8) * 3;
                        }else{ // 居ないまたはバフがfalseなら2連
                            calc.d += (calc.atkMag * calc.dMag * 0.9) * 2;
                        } 
                    }else{//DUOじゃないなら普通に2連
                        calc.d += (calc.atkMag * calc.dMag * 0.9) * 2;
                    }
                    break;
            }
			// if(calc.d != 0){
			// 	console.log("calc");
			// 	console.log(calc);
			// }
			// if(this.id_name == "card5" && this.m == 2){
			// 	console.log("***************************");
			// }
			this.basicDamage = calc.d;
			this.advanDamage = calc.d * 1.5;
			this.disadDamage = calc.d * 0.5;
			this.changeUse();
		},
		// バフをいじった時に再計算する
		changeBuf(){
			this.calcDamage(this.values, this.chnos);
		},
		// 魔法Lvの操作
		changeMasicLv(id, value){
			this.$emit('change-lv', id[4], id[9], value);
		},
		changeUse(){
			var recovery = 0;
			if(this.bufmain){
				// 回復
				if(this.main[0]+this.main[1] == "re"){
					switch(this.main[2]){
						case "s" :
							recovery += parseInt(this.values.atk) * (0.5 + 0.01 * this.mMlv);
							break;
						case "S" :
							recovery += parseInt(this.values.atk) * (0.9 + 0.02 * this.mMlv);
							break;
						case "M" :
							recovery += parseInt(this.values.atk) * (1.3 + 0.04 * this.mMlv);
							break;
					}          
				}
				// 継続回復
				if(this.main[0]+this.main[1] == "cr"){
					switch(this.main[2]){
						case "S" :
							recovery += parseInt(parseInt(this.values.atk) * (0.1919 + 0.0096 * this.mMlv)) * this.main[3];
							break;
						case "M" :
							recovery += parseInt(parseInt(this.values.atk) * (0.3837 + 0.0096 * this.mMlv)) * this.main[3];
							break;
					}          
				}
				if(this.main.length == 8){
					// 回復
					if(this.main[4]+this.main[5] == "re"){
						switch(this.main[6]){
							case "s" :
								recovery += parseInt(this.values.atk) * (0.5 + 0.01 * this.mMlv);
								break;
							case "S" :
								recovery += parseInt(this.values.atk) * (0.9 + 0.02 * this.mMlv);
								break;
							case "M" :
								recovery += parseInt(this.values.atk) * (1.3 + 0.04 * this.mMlv);
								break;
						}          
					}
					// 継続回復
					if(this.main[4]+this.main[5] == "cr"){
						switch(this.main[6]){
							case "S" :
								recovery += parseInt(parseInt(this.values.atk) * (0.1919 + 0.0096 * this.mMlv)) * this.main[7];
								break;
							case "M" :
								recovery += parseInt(parseInt(this.values.atk) * (0.3837 + 0.0096 * this.mMlv)) * this.main[7];
								break;
						}          
					}
				}
			}
			this.$emit('calc-damage', this.id_name, this.m, this.masic, this.basicDamage, recovery, this.isUse);
		},
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
		background: #2e2930;
		font-size: var(--FS);
	}
	.tds{
		font-size: calc(var(--FS) / 13 * 11);
		text-align: right;
		height: 20px;
	}
	/* テキスト */
	input[type=text]{
        height: var(--textH);
		width: var(--textW);
		border: 1px solid var(--dynamic-color);
        border-radius: 2px;
    }
	/* セレクトボックス */
	.select-own{
        width: var(--selectW);
        height: var(--selectH);
    }
	/* チェックボックス */
	input[type=checkbox]{
		display: none;
	}
	label{
		display: flex;
		box-sizing: border-box; /* border等込みでwidthのサイズにする */
		position: relative;
		justify-content: center; /* 文字の位置を中央にする */
		align-items: center;
		color: var(--dynamic-color);
		border: 1px solid var(--dynamic-color);
	}
	input[type=checkbox]:checked + label{
		color: #ffffff;
		background: var(--dynamic-color);
		border: 1px solid var(--dynamic-color);
	}
	input[type=checkbox]:disabled + label{
		background: #ffffffaa;
		border: 1px solid var(--dynamic-color);
	}
	label:before{
		content: "";
		position: absolute;
		right: 0;
		bottom: 0;
		border-style: solid;
		border-width: 5px 14px 15px 10px;
		border-color: transparent var(--dynamic-color) var(--dynamic-color) transparent;
	}
	input[type=checkbox] + label > span{
		position: absolute;
		right: 1px;
		bottom: 2px;
		width: 10px;
		height: 10px;
		background: transparent;
		border-style: solid;
		border-width: 1px;
		border-color: #e6b422;
	}
	input[type=checkbox]:checked + label > span{
		width: 5px;
		border-width: 0 2px 2px 0;
		border-color: transparent #e6b422 #e6b422 transparent;
		-webkit-transform: rotate(45deg);
		transform: rotate(45deg);
	}
</style>