<template>
	<div class="card-custom" :style="variable">
		<sort-modal ref="modalSort" @sort="changeSort" @search="changeSearch"></sort-modal>
		<h2>
			<input class="update" type="button" value="更新" @click="clickDataSave()" v-if="showFlg">
			<span class="res">{{this.responseMsg}}</span>
			<input class="sort" type="button" value="ソート" @click="$refs.modalSort.openModal()">
			<img class="updown" :src="'../img/'+this.updownImg" width="20" height="20" @click="clickUpDown()">
		</h2>
		<div class="space"></div>
		<div class="cards">
			<div class="card" v-for="card in this.sortDatas" :key="card.cdno">
				<img :src="'../img/'+Dormitory[Math.floor(card.chno/10)]+'/'+card.img" width="70.5" height="74.7">
				<custom-basic 
					:media="media" 
					:id_name="card.cdno" 
					:show_flg="showFlg" 
					:init_lv="card.lv" 
					:init_hp="card.hp" 
					:init_atk="card.atk" 
					:ref="'basic'+card.cdno" 
					@change="changeData"></custom-basic>
				<custom-masic 
					:media="media" 
					:id_name="card.cdno" 
					:show_flg="showFlg" 
					:init_masic1="card.m1_1" 
					:init_masic2="card.m2_1" 
					:init_lv1="card.m1lv" 
					:init_lv2="card.m2lv" 
					:ref="'masic'+card.cdno" 
					@change="changeData"></custom-masic>
				<custom-buddy 
					:media="media" 
					:id_name="card.cdno" 
					:show_flg="showFlg" 
					:init_buddy1="card.b1" 
					:init_buddy2="card.b2" 
					:init_buddy3="card.b3" 
					:init_lv1="card.b1lv" 
					:init_lv2="card.b2lv" 
					:init_lv3="card.b3lv" 
					:ref="'buddy'+card.cdno" 
					@change="changeData"></custom-buddy>
			</div>
		</div>
	</div>
</template>

<script>
module.exports = {
	components: {
		'custom-masic': httpVueLoader('./custom-masic.vue'),
		'custom-buddy': httpVueLoader('./custom-buddy.vue'),
		'custom-basic': httpVueLoader('./custom-basic.vue'),
		'sort-modal': httpVueLoader('../sort-modal.vue'),
    },
	props: {
		mydbname: {default:"H1_2_DefaultDataMax"},
		init_msg: {default:"initMsg"},
	},
	mounted() {
		// 端末の種類取得
		this.media = getMedia();
		// データをロード
		this.loading();
	},
	computed: {
		variable() {
			switch(this.media){
				case "PC":
					return {
						"--W": "905px",
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
						"--imgW": "1",
						"--imgH": "1",
					}
				case "TabletPC":
					return {
						"--W": "905px",
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
						"--imgW": "1",
						"--imgH": "1",
					}
				case "SmartPhone":
					return {
						"--W": "100%",
						"--h2H": "100px",
						"--buttonW": "170px",
						"--buttonH": "60px",
						"--buttonR": "80px",
						"--buttonFS": "30px",
						"--updwW": "70px",
						"--updwH": "70px",
						"--resL": "190px",
						"--resFS": "25px",
						"--spaceH": "130px",
						"--cardW": "450px",
						"--imgW": "3",
						"--imgH": "3",
					}
			}
		},
		showFlg: {
			get(){
				return this.mydbname == "H1_2_DefaultDataMax" ? false : true;
			}
		},
		// 比較用元データ
		cardDatas: {
			get(){
				var copyData = this.originDatas;
				// cdnoをキーにMap化する
				var adjustData = {};
				for(var i = 0; i < copyData.length; i++){
					adjustData[copyData[i].cdno] = copyData[i];
				}
                return adjustData;
			}
		},
		// 一時保存処理用データ
		tempDatas: {
			get(){
				// 元データから切り離してはいけない。
				var copyData = this.flexibleDatas;
				// cdnoをキーにMap化する
				var adjustData = {};
				for(var i = 0; i < copyData.length; i++){
					adjustData[copyData[i].cdno] = copyData[i];
				}
                return adjustData;
			}
		},
		// 表示用整形データ
		sortDatas: {
			get(){
				const keys = {default: "cdno", Lv: "lv", HP: "hp", ATK: "atk", chNo: "chno"};
				// なんかよくわからんけど一回ローカル関数に移してからじゃないとソート関数内で認識できない
				var key = keys[this.radioValue];
				var ud = this.updown;
				// ソート処理
				var sortData = this.flexibleDatas.sort(function(a, b){
					if(a[key] < b[key]) return -1 * ud;
					if(a[key] > b[key]) return 1 * ud;
					return 0;
				});
				// フィルター処理
				var fill1 = {Heartslabyul: 1, Savanaclaw: 2, Octavinelle: 3, Scarabia: 4, Pomefiore: 5, Ignihyde: 6, Diasomnia: 7, Ramshackle: 8};
				var fill2 = {natural: 0, fire: 1, tree: 2, water: 3};
				var search = this.search;
				var result = sortData.filter(function(value) {
					var flg = true;
					for(var k in fill1){
						if(search[k]){
							if(!(Math.floor(value["chno"] / 10) == fill1[k])){
								flg = false;
							}
						}
					}
					for(var k in fill2){
						if(search[k]){
							if(!(value["m1_1"][0] == fill2[k] || value["m2_1"][0] == fill2[k])){
								flg = false;
							}
						}
					}
					if(search.obtained){
						if(value["lv"] == 0){
							flg = false;
						}
					}
					if(flg){
						return value
					}
				});
				return result;
			}
		}
	},
	data: function () {
		return {
			media: "PC",
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			flexibleDatas: [],
			originDatas:[],
			message: "",

			changeFlg: [],

			updownImg: "desc.jpg",
			updown: -1,
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
			},
			responseMsg: this.init_msg,
		}
	},
	methods: {
		loading(){
			axios.post("../php/Hobby_1_1_DB.php",{
				myDB: this.mydbname
			})
			.then(response => {
				this.message = response.data.message;
				this.originDatas = JSON.parse(JSON.stringify(response.data.data));
				this.flexibleDatas = JSON.parse(JSON.stringify(response.data.data));
			})
			.catch(function (error) {
				console.log(error);
			});
		},
		changeSort(value){
			this.radioValue = value;
		},
		changeSearch(value){
			this.search = value;
		},
		clickUpDown(){
			this.updownImg = this.updown == 1 ? "desc.jpg" : "asc.jpg";
			this.updown = this.updown == 1 ? -1 : 1;
		},
		changeData(cdno, lbl, value){
			var flg = true;
			this.changeFlg.forEach(function(value){
				flg = value == cdno ? false : true;
			});
			if(flg){
				this.changeFlg.push(cdno);
			}
			console.log(this.changeFlg);
			// 一時保存領域にデータを保存
			switch(lbl){
				case "basic":
					this.tempDatas[cdno].lv = value.cardLv;
					this.tempDatas[cdno].hp = value.hp;
					this.tempDatas[cdno].atk = value.atk;
					break;
				case "masic":
					this.tempDatas[cdno].m1lv = value[1];
					this.tempDatas[cdno].m2lv = value[2];
					break;
				case "buddy":
					this.tempDatas[cdno].b1lv = value[1];
					this.tempDatas[cdno].b2lv = value[2];
					this.tempDatas[cdno].b3lv = value[3];
					break;
			}
			console.log(this.cardDatas);
			console.log(this.tempDatas);
		},
		clickDataSave(){
			console.log(this.changeFlg);
			var sendDatas = [];
			for(var k in this.changeFlg){
				var index = this.changeFlg[k];
				var origin = JSON.stringify(this.cardDatas[index]);
				var compare = JSON.stringify(this.tempDatas[index]);
				console.log(index);
				console.log(origin != compare);
				if(origin != compare){
					sendDatas.push(this.tempDatas[index]);
				}
			}
			console.log(JSON.parse(JSON.stringify(sendDatas)));
			axios.post("../php/Hobby_1_2_DBUpdate.php",{
				data: sendDatas
			})
			.then(response => {
				console.log(response.data)
				this.responseMsg = response.data.msg;
				// 各変数を再ロード
				this.changeFlg = [];
				this.loading();
			})
			.catch(function (error) {
				console.log(error);
			});
		},
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
		margin: 0;
		padding: 0;
		border: 0;
		color: #ffffff;
		font-size: 13px;
	}
	.card-custom{
		width: var(--W);
		margin: auto;
	}
	h2{
		box-sizing: border-box;
		position: fixed;
		height: var(--h2H);
		width: var(--W);
		margin: 10px 0;
		border-right: 15px solid #fbfaf5;
		font: normal 30px "游ゴシック",serif;
		background-color: #e6b422;
		color: #fbfaf5;
		z-index: 2;
	}
	.sort, .update{
		position: absolute;
		bottom: 10px;
		right: var(--buttonR);
		width: var(--buttonW);
        height: var(--buttonH);
        display: inline-block;
        text-align: center;
        background-color: #2e2930;
        font-size: var(--buttonFS);
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed #ffffff;
        margin: 0 2px;
		color: #fff;
        box-shadow: #2e2930 0px 0px 0px 3px;
	}
	.update{
		font-weight:normal;
		left: 5px;
	}
	.sort:hover, .update:active{
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
    }
	.updown{
		position: absolute;
		bottom: 9px;
		right: 5px;
		width: var(--updwW);
		height: var(--updwH);
		border: 1px solid gray;
	}
	.res{
		position: absolute;
		left: var(--resL);
		bottom: 6px;
		font-size: var(--resFS);
		font-style: italic;
	}
	.space{
		height: var(--spaceH);
	}
	.cards{
		background: #fbfaf5;
		width: var(--W);
		text-align: center;
	}
	.card{
		width: var(--cardW);
		margin: 2.5px;
		display: inline-block;
		text-align: center;
		border: 2px solid #e6b422;
		background: #2e2930;
	}
	.card > img{
		width: calc(70.5px * var(--imgW));
		height: calc(74.7px * var(--imgH));
	}
</style>