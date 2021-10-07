<template>
	<div id="overlaySort" :class="this.modalClass" @click="closeModal()">
		<div id="modalSort" :class="this.modalClass" @click="stop()">
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
	data: function () {
		return {
			modalClass: "hidden",
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
			this.modalClass = "";
		},
		closeModal(){
			this.modalClass = "hidden";
		},
		stop(){
			event.stopPropagation();
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
	}
	.hidden{
		display: none !important;
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
		width: 245px;
		padding: 1em;
		background-color: #fff;
		position: absolute;
		top: 18%;
		right: 10px;
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
		padding-left: 24px;
		margin: 5px 10px;
	}
	input[type=radio] + label:before{
		content: "";
		position: absolute;
		z-index: -1;
		top: 0;
		left: 0;
		display: block;
		width: 16px;
		height: 16px;
		border: 2px solid #e6b422;
		border-radius: 16px;
	}
	input[type=radio]:checked + label{
		padding-top: 4px;
		padding-left: 8px;
		color: #ffffff;
	}
	input[type=radio]:checked + label:before{
		top: 0;
		width: 110%;
		height: 24px;
		background: #e6b422;
	}
	/* ボタン */
	input[type=button]{
		width: 50px;
        height: 18px;
        display: inline-block;
        text-align: center;
        background-color: #e6b422;
        font-size: 10px;
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed #ffffff;
        margin: 8px 2px;
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
		width: 120px;
		height: 30px;
		box-sizing: border-box; /* border等込みでwidthのサイズにする */
		position: relative;
		justify-content: center; /* 文字の位置を中央にする */
		align-items: center;
		margin-bottom: 5px;
		font-size: 13px;
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
		border-style: solid;
		border-width: 0 0 19px 20px;
		border-color: transparent transparent #e6b422 transparent;
	}
	input[type=checkbox]:checked + label > span{
		position: absolute;
		right: 1px;
		bottom: 2px;
		width: 5px;
		height: 10px;
		background: transparent;
		border-style: solid;
		border-width: 0 2px 2px 0;
		border-color: transparent #333631 #333631 transparent;
		-webkit-transform: rotate(45deg);
		transform: rotate(45deg);
	}
	.gap{
		margin-top: 5px;
	}
</style>