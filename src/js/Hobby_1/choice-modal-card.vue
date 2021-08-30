<template>
	<div id="overlay" :class="this.modalClass" @click="closeModal()">
        <div id="modal" :class="this.modalClass" @click="stop()">
            <!-- <span id="sortBtn" onclick="clickOpenSortModal()">ソート</span>
            <img id="ud" src="../img/Hobby_1/desc.jpg" alt="desc" width="20" height="20" onclick="UD(this)"> -->
            <img v-for="card in data" 
			:src="'../img/Hobby_1/'+Dormitory[Math.floor(card.chno/10)]+'/'+card.img" 
			:key="card.cdno" 
			@click="choiceCard(card)" 
			alt="" width="70.5" height="74.7">
        </div>
    </div>
</template>

<script>
module.exports = {
	mounted() {
		axios.get("http://haveabook.php.xdomain.jp/editing/Hobby_1/Hobby_1_1_DB.php")
		.then(response => {
			this.message = response.data.message;
			this.data = response.data.data;
			// console.log(response.data);
			console.log(this.message);
		})
	},
	props: {
		id_name: {default:"myselectimg"},
	},
	data: function () {
		return {
			modalClass: "hidden",
			target: "",
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			data: [],
			message: [],
			
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
			/** クリックしたアイコンを親コンポーネントに送る */
			this.$emit('choice-card', value, this.target);
			this.closeModal();
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
</style>