<template>
	<div>
		<div class="card" v-for="data in cardData" :key="data.id_name">
			<img :id="data.id_name" :src="'../img/'+data.cardImg" width="70.5" height="74.7" @click="clickOpenModal(data.id_name)">
			<view-hpatk :id_name="data.id_name" ref="hpatk" @change="extractHPATK"></view-hpatk>
			<view-buddy :id_name="data.id_name" ref="buddy" @change="changeBuddyLv"></view-buddy>
			<view-damage :id_name="data.id_name" :m="'1'" ref="damage1"></view-damage>
			<view-damage :id_name="data.id_name" :m="'2'" ref="damage2"></view-damage>
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
		'view-damage': httpVueLoader('http://localhost:8080/Hobby_1/js/1_1/view-damage.vue'),
		'view-buddy': httpVueLoader('http://localhost:8080/Hobby_1/js/1_1/view-buddy.vue'),
		'view-hpatk': httpVueLoader('http://localhost:8080/Hobby_1/js/1_1/view-hpatk.vue'),
		'choice-modal-card': httpVueLoader('http://localhost:8080/Hobby_1/js/1_1/choice-modal-card.vue'),
    },
	props: {
		// id_name: {default:"mycard"},
	},
	data: function () {
		return {
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			chnos: [0, 0, 0, 0, 0],
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
			this.chnos[card.slice(-1)-1] = value.chno;
			this.applyData(card);
			console.log("values:");
			console.log(this.chnos);
			console.log(this.cardData[card].values);
		},
		applyData(card){
			this.cardData[card].cardImg = this.Dormitory[Math.floor(this.cardData[card].values.chno/10)]+'/'+this.cardData[card].values.img;
			this.$refs.hpatk[card[4]-1].applyHPATK(this.cardData[card].values);
			for(var i = 0; i < 5; i++){
				this.$refs.hpatk[i].changeBuddy(this.chnos);
			}
			// console.log("refs:");
			// console.log(this.$refs);
			this.$refs.buddy[card[4]-1].applyBuddy(this.cardData[card].values);
			for(var i = 0; i < 5; i++){
				this.$refs.buddy[i].changeBuddy(this.chnos);
			}

			this.$refs.damage1[card[4]-1].applyMbuf(this.cardData[card].values);
			this.$refs.damage2[card[4]-1].applyMbuf(this.cardData[card].values);
		},
		changeBuddyLv(cid, bid, value){
			this.cardData["card"+cid].values["b"+bid+"lv"] = value;
			this.applyData("card"+cid);
		},
		extractHPATK(cid, hpbuf, atkbuf){
			// console.log(hp);
			// console.log(atk);
			// this.cardData["card"+cid].values["b"+bid+"lv"] = value;
			// this.applyData("card"+cid);
			this.$refs.damage1[cid[4]-1].changeBuf(hpbuf, atkbuf);
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