<template>
	<div class="cards">
		<sort-modal ref="modalSort" @sort="changeSort" @search="changeSearch"></sort-modal>
		<input class="sort" type="button" value="ソート" @click="clickOpenSortModal()">
        <img class="updown" :src="'../img/'+this.updownImg" width="20" height="20" @click="clickUpDown()">
		<br><br>
		<div class="card" v-for="card in this.sortDatas" :key="card.cdno">
			<img :src="'../img/'+Dormitory[Math.floor(card.chno/10)]+'/'+card.img" width="70.5" height="74.7">
			<custom-basic 
				:id_name="card.cdno" 
				:init_lv="card.lv" 
				:init_hp="card.hp" 
				:init_atk="card.atk" 
				@change="changeData"></custom-basic>
			<custom-masic 
				:id_name="card.cdno" 
				:init_masic1="card.m1_1" 
				:init_masic2="card.m2_1" 
				:init_lv1="card.m1lv" 
				:init_lv2="card.m2lv" 
				@change="changeData"></custom-masic>
			<custom-buddy 
				:id_name="card.cdno" 
				:init_buddy1="card.b1" 
				:init_buddy2="card.b2" 
				:init_buddy3="card.b3" 
				:init_lv1="card.b1lv" 
				:init_lv2="card.b2lv" 
				:init_lv3="card.b3lv" 
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
			this.datas = response.data.data;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
	computed: {
		cardDatas: {
			get(){
				// 元データから切り離す
				var copyData = JSON.parse(JSON.stringify(this.datas));
				// cdnoをキーにMap化する
				var adjustData = {};
				for(var i = 0; i < copyData.length; i++){
					adjustData[copyData[i].cdno] = copyData[i];
				}
				console.log(adjustData);
                return adjustData;
			}
		},
		sortDatas: {
			get(){
				const keys = {default: "cdno", Lv: "lv", HP: "hp", ATK: "atk", chNo: "chno"};
				// なんかよくわからんけど一回ローカル関数に移してからじゃないとソート関数内で認識できない
				var key = keys[this.radioValue];
				var ud = this.updown;
				// 元データから切り離す
				var copyData = JSON.parse(JSON.stringify(this.datas));
				// ソート処理
				var sortData = copyData.sort(function(a, b){
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
				console.log(result);
				return result;
			}
		}
	},
	data: function () {
		return {
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			datas: [],
			message: "",

			changeFlg: [],

			updownImg: "desc.jpg",
			updown: -1,
			radioValue: "default",
			search: {
				Heartslabyul: true,
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
		changeData(cdno){
			var flg = true;
			this.changeFlg.forEach(function(value){
				flg = value == cdno ? false : true;
			});
			if(flg){
				this.changeFlg.push(cdno);
			}
			console.log(this.changeFlg);
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
		/* background: #2e2930; */
		color: #ffffff;
		font-size: 13px;
	}
	.card{
		width: 120px;
		margin: 2.5px;
		display: inline-block;
		text-align: center;
		border: 2px solid #e6b422;
	}
	.cards{
		/* display: inline-block; */
		background: #fbfaf5;
	}
	table{
		width: 100%;
	}
	.sort{
		position: absolute;
		top: 10px;
		right: 35px;
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
        margin: 0 2px;
		color: #fff;
        box-shadow: #e6b422 0px 0px 0px 3px;
	}
	.sort:hover {
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
    }
	.updown{
		position: absolute;
		top: 4px;
		right: 5px;
	}
</style>