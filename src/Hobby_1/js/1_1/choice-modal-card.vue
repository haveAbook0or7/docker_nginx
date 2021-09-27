<template>
	<div id="overlay" :class="this.modalClass" @click="closeModal()">
        <div id="modal" :class="this.modalClass" @click="stop()">
			<sort-modal ref="modalSort" @sort="changeSort" @search="changeSearch"></sort-modal>
			<input class="sort" type="button" value="ソート" @click="clickOpenSortModal()">
            <img class="updown" :src="'../img/'+this.updownImg" width="20" height="20" @click="clickUpDown()">
			<br>
            <img v-for="card in this.datas" 
			:src="'../img/'+Dormitory[Math.floor(card.chno/10)]+'/'+card.img" 
			:key="card.cdno" 
			:class="card.class" 
			@click="choiceCard(card)" 
			alt="" width="70.5" height="74.7">
        </div>
    </div>
</template>

<script>
module.exports = {
	components: {
		'sort-modal': httpVueLoader('http://localhost:8080/Hobby_1/js/sort-modal.vue'),
    },
	mounted() {
		// axios.get("http://haveabook.php.xdomain.jp/editing/Hobby_1/Hobby_1_1_DB.php")
		axios.get("http://localhost:8080/Hobby_1/php/Hobby_1_1_DB.php")
		.then(response => {
			this.message = response.data.message;
			this.data = response.data.data;
		})
	},
	computed: {
		datas: {
			get(){
				const keys = {default: "cdno", Lv: "lv", HP: "hp", ATK: "atk", chNo: "chno"};
				// なんかよくわからんけど一回ローカル関数に移してからじゃないとソート関数内で認識できない
				var key = keys[this.radioValue];
				var ud = this.updown;
				var sortData = this.data.sort(function(a, b){
					if(a[key] < b[key]) return -1 * ud;
					if(a[key] > b[key]) return 1 * ud;
					return 0;
				});
				var fill1 = {Heartslabyul: 1, Savanaclaw: 2, Octavinelle: 3, Scarabia: 4, Pomefiore: 5, Ignihyde: 6, Diasomnia: 7, Ramshackle: 8};
				var fill2 = {natural: 0, fire: 1, tree: 2, water: 3};
				for(var i = 0; i < sortData.length; i++){
					sortData[i].class = "hide";
					var flg = true;
					for(var k in fill1){
						if(this.search[k]){
							if(!(Math.floor(sortData[i]["chno"] / 10) == fill1[k])){
								flg = false;
							}
						}
					}
					for(var k in fill2){
						if(this.search[k]){
							if(!(sortData[i]["m1_1"][0] == fill2[k] || sortData[i]["m2_1"][0] == fill2[k])){
								flg = false;
							}
						}
					}
					if(this.search.obtained){
						if(sortData[i]["lv"] == 0){
							flg = false;
						}
					}
					if(flg){
						sortData[i].class = "";
					}
				}
				return sortData;
			}
		},
	},
	data: function () {
		return {
			modalClass: "hidden",
			target: "",
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			data: [],
			message: [],
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
		openModal(value){
			this.target = value;
			this.modalClass = "";
		},
		closeModal(){
			this.modalClass = "hidden";
		},
		stop(){
			event.stopPropagation();
		},
		choiceCard(value){
			//データの中身を複製して渡すため、一度JSONにして戻すことで別のオブジェクトにしている
			var copyData = JSON.parse(JSON.stringify(value));
			/** クリックしたアイコンを親コンポーネントに送る */
			this.$emit('choice-card', copyData, this.target);
			this.closeModal();
		},
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
	.hidden{
		display: none !important;
	}
	#overlay{
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
	#overlay{
		/*　画面の中央に要素を表示させる設定　*/
		display: flex;
		align-items: center;
		justify-content: center;
	}
	#modal{
		z-index:4;
		width:70%;
		height: 70%;
		overflow: scroll;
		padding: 1em;
		background-color: #fff;
		position: absolute;
	}
	img{
		margin: 4px;
		border: 1px solid gray;
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
	.hide{
		display: none;
	}
</style>