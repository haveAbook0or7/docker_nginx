<template>
	<div class="cards">
		<sort-modal ref="modalSort" @sort="changeSort" @search="changeSearch"></sort-modal>
		<h2>
			<button class="update">更新</button>
			<input class="sort" type="button" value="ソート" @click="clickOpenSortModal()">
			<img class="updown" :src="'../img/'+this.updownImg" width="20" height="20" @click="clickUpDown()">
		</h2>
		<br><br><br><br>
		<div class="card" v-for="card in this.sortDatas" :key="card.cdno">
			<img :src="'../img/'+Dormitory[Math.floor(card.chno/10)]+'/'+card.img" width="70.5" height="74.7">
			<custom-basic 
				:id_name="card.cdno" 
				:init_lv="card.lv" 
				:init_hp="card.hp" 
				:init_atk="card.atk" 
				:ref="'basic'+card.cdno" 
				@change="changeData"></custom-basic>
			<custom-masic 
				:id_name="card.cdno" 
				:init_masic1="card.m1_1" 
				:init_masic2="card.m2_1" 
				:init_lv1="card.m1lv" 
				:init_lv2="card.m2lv" 
				:ref="'masic'+card.cdno" 
				@change="changeData"></custom-masic>
			<custom-buddy 
				:id_name="card.cdno" 
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
		// mydbname: {default:"H1_2_DefaultDataMax"},
		mydbname: {default:"H1_3_UserData1"},
	},
	mounted() {
		axios.post("../php/Hobby_1_1_DB.php",{
			myDB: this.mydbname
		})
		.then(response => {
			this.message = response.data.message;
			console.log(this.message);
			// 元データと一時保存用データ領域を作る
			this.originDatas = JSON.parse(JSON.stringify(response.data.data));
			this.datas = JSON.parse(JSON.stringify(response.data.data));
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	computed: {
		cardDatas: {
			get(){
				// 元データから切り離す
				var copyData = JSON.parse(JSON.stringify(this.originDatas));
				// cdnoをキーにMap化する
				var adjustData = {};
				for(var i = 0; i < copyData.length; i++){
					adjustData[copyData[i].cdno] = copyData[i];
				}
                return adjustData;
			}
		},
		changeDatas: {
			get(){
				// 元データから切り離してはいけない。
				var copyData = this.datas;
				// cdnoをキーにMap化する
				var adjustData = {};
				for(var i = 0; i < copyData.length; i++){
					adjustData[copyData[i].cdno] = copyData[i];
				}
                return adjustData;
			}
		},
		sortDatas: {
			get(){
				const keys = {default: "cdno", Lv: "lv", HP: "hp", ATK: "atk", chNo: "chno"};
				// なんかよくわからんけど一回ローカル関数に移してからじゃないとソート関数内で認識できない
				var key = keys[this.radioValue];
				var ud = this.updown;
				// ソート処理
				var sortData = this.datas.sort(function(a, b){
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
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			datas: [],
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
			}
		}
	},
	methods: {
		clickOpenSortModal(){
			this.$refs.modalSort.openModal();
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
					this.changeDatas[cdno].lv = value.cardLv;
					this.changeDatas[cdno].hp = value.hp;
					this.changeDatas[cdno].atk = value.atk;
					break;
				case "masic":
					this.changeDatas[cdno].m1lv = value[1];
					this.changeDatas[cdno].m2lv = value[2];
					break;
				case "buddy":
					this.changeDatas[cdno].b1lv = value[1];
					this.changeDatas[cdno].b2lv = value[2];
					this.changeDatas[cdno].b3lv = value[3];
					break;
			}
			// console.log(this.changeDatas);
			// console.log(this.cardDatas);
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
	.card{
		width: 120px;
		margin: 2.5px;
		display: inline-block;
		text-align: center;
		border: 2px solid #e6b422;
		background: #2e2930;
	}
	.cards{
		background: #fbfaf5;
		width: 905px;
	}
	table{
		width: 100%;
	}
	h2{
		box-sizing: border-box;
		position: fixed;
		width: 905px;
		height: 48px;
		margin: 10px 0;
		border-right: 15px solid #2e2930;;
		font: normal 30px "游ゴシック",serif;
		background-color: #e6b422;
		color: white;
		z-index: 5;
	}
	.sort, .update{
		position: absolute;
		bottom: 10px;
		right: 32px;
		width: 50px;
        height: 18px;
        display: inline-block;
        text-align: center;
        background-color: #2e2930;
        font-size: 10px;
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed #ffffff;
        margin: 0 2px;
		color: #fff;
        box-shadow: #2e2930 0px 0px 0px 3px;
	}
	.sort:hover, .update:active{
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
    }
	.updown{
		position: absolute;
		bottom: 9px;
		right: 5px;
		border: 1px solid gray;
	}
	.update{
		width: 50px;
        height: 24px;
		font-size: 13px;
		font-weight:normal;
		left: 5px;
	}
</style>