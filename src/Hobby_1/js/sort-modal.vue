<template>
	<div id="overlaySort" :class="media" :style="variable" v-show="this.showFlg" @click="closeModal()">
		<div class="sort-modal" id="modalSort" v-show="this.showFlg" @click="$event.stopPropagation()">
            <input id="default" type="radio" v-model="radioValue" value="default" @change="changeSort"><label for="default">デフォルト</label>
            <input id="Lv"      type="radio" v-model="radioValue" value="Lv"      @change="changeSort"><label for="Lv">Lv</label>
            <input id="HP"      type="radio" v-model="radioValue" value="HP"      @change="changeSort"><label for="HP">HP</label>
            <input id="ATK"     type="radio" v-model="radioValue" value="ATK"     @change="changeSort"><label for="ATK">ATK</label>
			<input id="chNo"    type="radio" v-model="radioValue" value="chNo"    @change="changeSort"><label for="chNo">キャラクター</label>
            <br>
			<input type="button" value="すべて" @click="clickAll()">
			<br>
			<input id="Heartslabyul" type="checkbox" v-model="search.Heartslabyul" @change="changeSearch"><label for="Heartslabyul">ハーツラビュル寮<span></span></label>
            <input id="Savanaclaw"   type="checkbox" v-model="search.Savanaclaw"   @change="changeSearch"><label for="Savanaclaw">サバナクロー寮<span></span></label>
            <input id="Octavinelle"  type="checkbox" v-model="search.Octavinelle"  @change="changeSearch"><label for="Octavinelle">オクタヴィネル寮<span></span></label>
            <input id="Scarabia"     type="checkbox" v-model="search.Scarabia"     @change="changeSearch"><label for="Scarabia">スカラビア寮<span></span></label>
            <input id="Pomefiore"    type="checkbox" v-model="search.Pomefiore"    @change="changeSearch"><label for="Pomefiore">ポムフィオーレ寮<span></span></label>
            <input id="Ignihyde"     type="checkbox" v-model="search.Ignihyde"     @change="changeSearch"><label for="Ignihyde">イグニハイド寮<span></span></label>
            <input id="Diasomnia"    type="checkbox" v-model="search.Diasomnia"    @change="changeSearch"><label for="Diasomnia">ディアソムニア寮<span></span></label>
			<input id="Ramshackle"   type="checkbox" v-model="search.Ramshackle"   @change="changeSearch"><label for="Ramshackle">オンボロ寮<span></span></label>
            
            <input id="natural" type="checkbox" v-model="search.natural" @change="changeSearch"><label class="gap" for="natural">無属性<span></span></label>
            <input id="fire"    type="checkbox" v-model="search.fire"    @change="changeSearch"><label for="fire">火属性<span></span></label>
            <input id="tree"    type="checkbox" v-model="search.tree"    @change="changeSearch"><label for="tree">木属性<span></span></label>
            <input id="water"   type="checkbox" v-model="search.water"   @change="changeSearch"><label for="water">水属性<span></span></label>
            
            <input id="obtained" type="checkbox" v-model="search.obtained" @change="changeSearch"><label class="gap" for="obtained">持ってるやつ<span></span></label>
        </div>
    </div>
</template>

<script>
module.exports = {
	props: {
		id_name: {default:"myselectimg"},
	},
	mounted() {
		// 端末の種類取得
		this.media = getMedia();
	},
	computed: {
		variable() {
			switch(this.media){
				case "PC":
					return {
						"--W": "245px",
						"--R": "10px",
						"--FS": "13px",
						"--radioW": "16px",
						"--radioH": "16px",
						"--radioM": "5px 10px",
						"--buttonW": "50px",
						"--buttonH": "18px",
						"--buttonM": "8px 2px",
						"--checkW": "120px",
						"--checkH": "30px",
						"--checkMB": "5px",
						"--checkFS": "12px",
						"--checkD": "1",
					}
				case "TabletPC":
					return {
						"--W": "445px",
						"--R": "10px",
						"--FS": "20px",
						"--radioW": "30px",
						"--radioH": "30px",
						"--radioM": "15px 10px",
						"--buttonW": "80px",
						"--buttonH": "36px",
						"--buttonM": "16px 2px",
						"--checkW": "200px",
						"--checkH": "55px",
						"--checkMB": "10px",
						"--checkFS": "20px",
						"--checkD": "1",
					}
				case "SmartPhone":
					return {
						"--W": "80%",
						"--R": "5%",
						"--FS": "50px",
						"--radioW": "50px",
						"--radioH": "56px",
						"--radioM": "20px 15px",
						"--buttonW": "170px",
						"--buttonH": "60px",
						"--buttonM": "32px 2px",
						"--checkW": "380px",
						"--checkH": "100px",
						"--checkMB": "20px",
						"--checkFS": "45px",
						"--checkD": "2",
					}
			}
		},
	},
	data: function () {
		return {
			media: "PC",
			showFlg: false,
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			radioValue: "default",
			search: {
				Heartslabyul: false,
				Savanaclaw: false,
				Octavinelle: false,
				Scarabia: false,
				Pomefiore: false,
				Ignihyde: false,
				Diasomnia: false,
				Ramshackle: false,

				natural: false,
				fire: false,
				tree: false,
				water: false,

				obtained: false,
			}
		}
	},
	methods: {
		openModal(){
			this.showFlg = true;
		},
		closeModal(){
			this.showFlg = false;
		},
		changeSort(){
			this.$emit('sort', this.radioValue);
		},
		changeSearch(){
			this.$emit('search', this.search);
		},
		clickAll(){
			for(var key in this.search){
				this.search[key] = false;
			}
			this.changeSearch();
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
		color: black;
		font-size: var(--FS);
	}
	#overlaySort{
		/*　要素を重ねた時の順番　*/
		z-index:3;
		/*　画面全体を覆う設定　*/
		position:fixed;
		top:0;
		left:0;
		width:100%;
		height:100%;
		background-color:rgba(0,0,0,0.5);
	}
	#modalSort{
		z-index:4;
		width: var(--W);
		padding: 1em;
		background-color: #fff;
		position: absolute;
		top: 15%;
		right: var(--R);
	}
	/* ラジオボタン */
	input[type=radio]{
		position: absolute;
		z-index: -1;
		opacity: 0;
	}
	input[type=radio] + label{
		position: relative;
		display: inline-block;
		padding-left: calc(var(--radioH) + 6px);
		margin: var(--radioM);
	}
	input[type=radio] + label:before{
		content: "";
		position: absolute;
		z-index: -1;
		top: 0;
		left: 0;
		display: block;
		width: var(--radioW);
		height: var(--radioH);
		border: 2px solid #e6b422;
		border-radius: var(--radioH);
	}
	input[type=radio]:checked + label{
		padding-top: 4px;
		padding-left: 8px;
		color: #ffffff;
	}
	input[type=radio]:checked + label:before{
		top: 0;
		width: 108%;
		height: calc(var(--radioH) + 6px);
		background: #e6b422;
	}
	/* ボタン */
	input[type=button]{
		width: var(--buttonW);
        height: var(--buttonH);
        display: inline-block;
        text-align: center;
        background-color: #e6b422;
        font-size: calc(var(--FS) - 3px);
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed #ffffff;
        margin: var(--buttonM);
        box-shadow: #e6b422 0px 0px 0px 3px;
		color: #ffffff;
	}
	input[type=button]:hover {
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
    }
	/* チェックボックス */
	input[type=checkbox]{
		display: none;
	}
	input[type=checkbox] + label{
		display: inline-flex;
		width: var(--checkW);
		height: var(--checkH);
		box-sizing: border-box; /* border等込みでwidthのサイズにする */
		position: relative;
		justify-content: center; /* 文字の位置を中央にする */
		align-items: center;
		margin-bottom: var(--checkMB);
		font-size: var(--checkFS);
		border: 1px solid #e6b422;
	}
	input[type=checkbox]:checked + label{
		color: #ffffff;
		background: #e6b422;
		border: 1px solid #e6b422;
	}
	input[type=checkbox]:disabled + label{
		background: #ffffffaa;
		border: 1px solid #e6b422;
	}
	input[type=checkbox] + label:before{
		content: "";
		position: absolute;
		right: 0;
		bottom: 0;
		z-index: -1;
		border-style: solid;
		border-width: calc(5px*var(--checkD)) calc(14px*var(--checkD)) calc(15px*var(--checkD)) calc(10px*var(--checkD));
		border-color: transparent #e6b422 #e6b422 transparent;
	}
	input[type=checkbox] + label > span{
		position: absolute;
		right: 1px;
		bottom: 2px;
		width: calc(10px * var(--checkD));
		height: calc(10px * var(--checkD));
		background: transparent;
		border-style: solid;
		border-width: 1px;
		border-color: #333631;
	}
	input[type=checkbox]:checked + label > span{
		width: calc(5px * var(--checkD));
		border-width: 0 calc(2px*var(--checkD)) calc(2px*var(--checkD)) 0;
		border-color: transparent #333631 #333631 transparent;
		-webkit-transform: rotate(45deg);
		transform: rotate(45deg);
	}
	.gap{
		margin-top: 5px;
	}
</style>