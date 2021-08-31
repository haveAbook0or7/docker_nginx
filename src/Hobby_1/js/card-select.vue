<template>
	<div>
		<div class="card" v-for="data in cardData" :key="data.id_name">
			<img :id="data.id_name" :src="'../img/'+data.cardImg" width="70.5" height="74.7" @click="clickOpenModal(data.id_name)">
			<view-hpatk :id_name="data.id_name" ref="hpatk"></view-hpatk>
			<view-buddy :id_name="data.id_name" ref="buddy"></view-buddy>
			<view-damage :id_name="data.id_name" ref="damage1"></view-damage>
			<view-damage :id_name="data.id_name" ref="damage2"></view-damage>
		</div>
		<choice-modal-card ref="modal" @choice-card="getCard"></choice-modal-card>
	</div>
</template>

<script>
module.exports = {
	components: {
		// 'view-damage': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/view-damage.vue'),
		// 'view-buddy': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/view-buddy.vue'),
		// 'view-hpatk': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/view-hpatk.vue'),
		// 'choice-modal-card': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/choice-modal-card.vue'),
		'view-damage': httpVueLoader('http://localhost:8080/Hobby_1/js/view-damage.vue'),
		'view-buddy': httpVueLoader('http://localhost:8080/Hobby_1/js/view-buddy.vue'),
		'view-hpatk': httpVueLoader('http://localhost:8080/Hobby_1/js/view-hpatk.vue'),
		'choice-modal-card': httpVueLoader('http://localhost:8080/Hobby_1/js/choice-modal-card.vue'),
    },
	props: {
		// id_name: {default:"mycard"},
	},
	data: function () {
		return {
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			cardData: {
				card1: {id_name: "card1", cardImg: "none.jpg", values: {}},
				card2: {id_name: "card2", cardImg: "none.jpg", values: {}},
				card3: {id_name: "card3", cardImg: "none.jpg", values: {}},
				card4: {id_name: "card4", cardImg: "none.jpg", values: {}},
				card5: {id_name: "card5", cardImg: "none.jpg", values: {}}
			}
		}
	},
	methods: {
		clickOpenModal(value){
            this.$refs.modal.openModal(value);
		},
		getCard(value, card){
			this.cardData[card].values = value;
			this.applyData(card);
		},
		applyData(card){
			this.cardData[card].cardImg = this.Dormitory[Math.floor(this.cardData[card].values.chno/10)]+'/'+this.cardData[card].values.img;
			this.$refs.hpatk[card[4]-1].applyHPATK(this.cardData[card].values.hp, this.cardData[card].values.atk);
			this.$refs.buddy[card[4]-1].applyBuddy([
				{B: this.cardData[card].values.b1, Btype: this.cardData[card].values.b1type, lv: this.cardData[card].values.b1lv},
				{B: this.cardData[card].values.b2, Btype: this.cardData[card].values.b2type, lv: this.cardData[card].values.b2lv},
				{B: this.cardData[card].values.b3, Btype: this.cardData[card].values.b3type, lv: this.cardData[card].values.b3lv},]);
			this.$refs.damage1[card[4]-1].applyMbuf(this.cardData[card].values.m1buf_5, this.cardData[card].values.m2buf_5);
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
	.card{
		width: 140px;
		display: inline-block;
		text-align: center;
	}
	table{
		width: 100%;
		background: palevioletred;
	}
	.text{
		height: 1.5em;
		width: 40px;
		background: #b3ada0;
	}
    .textOn{
		height: 1.5em;
        width: 40px;
        background: white;
        border: 2px solid #e6b422; 
	}
    .button{
        display: inline-block;
        text-align: left;
        background-color: #e6b422;
        font-size: 10px;
        color: rgb(255, 255, 255);
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed rgb(255, 255, 255);
        margin: 0 2px;
        box-shadow: #e6b422 0px 0px 0px 3px;
    }
    .button:hover {
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
        /* border-style: solid; */
    }
</style>