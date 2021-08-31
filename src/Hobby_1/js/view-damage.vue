<template>
	<table border="0" :id="this.id_name+'_TMagic'">
        <tr>
            <td colspan="2">
				<label><input :id="this.id_name+'_MtORf1'" type="checkbox" value="0" checked>使用する</label>
            </td>
        </tr>
        <tr>
            <td class="col1">
				{{this.M}}<input :id="this.id_name+'_d'" class="text" type="text" value="" readonly="readonly">
			</td>
            <td class="col1">
				Lv<select-own :id="this.id_name+'_lv'" :op="'opLv'"></select-own>
            </td>
        </tr>
        <tr>
            <td class="col1">
				有利<input :id="this.id_name+'_ADd1'" class="text" type="text" value="" readonly>
            </td>
			<td class="col1">
				不利<input :id="this.id_name+'_DISd1'" class="text" type="text" value="" readonly>
            </td>
        </tr>
        <tr>
			<td colspan="2" class="col2">
				<input :id="this.id_name+'_buf1_1'" type="checkbox" value="0" checked>
				<label :for="this.id_name+'_buf1_1'" >
					{{bufMain_1}}<br>{{bufMain_2}}
				</label>
			</td>
        </tr>
        <tr>
            <td colspan="2" class="col2">
				<input :id="this.id_name+'_buf1_2'" type="checkbox" value="0">
				<label :for="this.id_name+'_buf1_2'">
					{{bufSub_1}}<br>{{bufSub_2}}
				</label>
			</td>
        </tr>
        <tr style="height: 20px;">
			<td :id="this.id_name+'_bufA1'" colspan="2"></td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
		'select-own': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/select-own.vue'),
	},
	props: {
		id_name: {default:"myselectimg"},
		M: {default:"M1"}
	},
	data: function () {
		return {
			effect1: {
				au: "ATK UP", du: "ﾀﾞﾒｰｼﾞ UP", ad: "ATK DOWN", dd: "ﾀﾞﾒｰｼﾞ DOWN", re: "HP回復", cr: "HP継続回復", td: "被ﾀﾞﾒ DOWN",
				fu: "火ﾀﾞﾒ UP", tu: "木ﾀﾞﾒ UP", wu: "水ﾀﾞﾒ UP", nu: "無ﾀﾞﾒ UP", ev: "回避", cu: "呪い",
				DU: "デュオ魔法", nN: "なし", n: "",
			},
			effect2: {n: "", s: "極小", S: "小", M: "中", L: "大"},
			effect3: {n: "", 1: "1T", 2: "2T", 3: "3T"},

			bufMain_1: "**********",
			bufMain_2: "**********",
			bufSub_1: "**********",
			bufSub_2: "**********",
		}
	},
	methods: {
		trimBuf(value){
			console.log(value.length);
			v1_1 = value[0]+value[1]; v2_1 = "n"; v3_1 = "n";
			v1_2 = "n"; v2_2 = "n"; v3_2 = "n";
			if(value == "nN"){
			}else if(isFinite(value) && value != 0){
				v1_1 = "DU";
			}else{
				v2_1 = value[2]; v3_1 = value[3];
				if(value.length == 8){
					v1_2 = value[4]+value[5]; v2_2 = value[6]; v3_2 = value[7];
				}
			}
			console.log({ef1_1: v1_1, ef2_1: v2_1, ef3_1: v3_1,  ef1_2: v1_2, ef2_2: v2_2, ef3_2: v3_2,});
			return {ef1_1: v1_1, ef2_1: v2_1, ef3_1: v3_1,  ef1_2: v1_2, ef2_2: v2_2, ef3_2: v3_2,};
		},
		applyMbuf(main, sub){
			mV = this.trimBuf(main);
			sV = this.trimBuf(sub);

			this.bufMain_1 = this.effect1[mV.ef1_1] + this.effect2[mV.ef2_1] +this.effect3[mV.ef3_1];
			this.bufMain_2 = this.effect1[mV.ef1_2] + this.effect2[mV.ef2_2] +this.effect3[mV.ef3_2];
			this.bufSub_1 = this.effect1[sV.ef1_1] + this.effect2[sV.ef2_1] +this.effect3[sV.ef3_1];
			this.bufSub_2 = this.effect1[sV.ef1_2] + this.effect2[sV.ef2_2] +this.effect3[sV.ef3_2];
		},
		getIcon(value) {
			this.preview = '../img/Hobby_1/Another/'+value;
			this.buddy = value.substr(0, 2);
		},
		childShow(flg){
			this.class = flg ? "show" : "hide";
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