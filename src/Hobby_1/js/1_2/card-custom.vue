<template>
	<!-- <div class="cards"> -->
		<!-- <div class="card" v-for="data in cardData" :key="data.id_name"> -->
		<div class="card">
			<!-- <img :id="data.id_name" :src="'../img/'+data.cardImg" width="70.5" height="74.7" @click="clickOpenModal(data.id_name)"> -->
			<img src="../img/Heartslabyul/Riddle_D.jpg" width="70.5" height="74.7">
			<custom-basic></custom-basic>
			<custom-masic></custom-masic>
			<custom-buddy></custom-buddy>
		</div>
	<!-- </div> -->
</template>

<script>
module.exports = {
	components: {
		'custom-masic': httpVueLoader('http://localhost:8080/Hobby_1/js/1_2/custom-masic.vue'),
		'custom-buddy': httpVueLoader('http://localhost:8080/Hobby_1/js/1_2/custom-buddy.vue'),
		'custom-basic': httpVueLoader('http://localhost:8080/Hobby_1/js/1_2/custom-basic.vue'),
    },
	props: {
		// mydbname: {default:"H1_2_DefaultDataMax"},
		mydbname: {default:"H1_3_UserData1"},
	},
	mounted() {
		// axios.get("http://haveabook.php.xdomain.jp/editing/Hobby_1/Hobby_1_1_DB.php")
		axios.post("http://localhost:8080/Hobby_1/php/Hobby_1_1_DB.php",{
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
	data: function () {
		return {
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			datas: [],
			message: "",
		}
	},
	methods: {
		// それぞれの部品にデータを送る
		applyData(card){
			// 画像を表示
			this.cardData[card].cardImg = this.Dormitory[Math.floor(this.cardData[card].values.chno/10)]+'/'+this.cardData[card].values.img;
			// 基礎ステータス
			this.$refs.hpatk[card[4]-1].applyHPATK(this.cardData[card].values);
			for(var i = 0; i < 5; i++){
				this.$refs.hpatk[i].changeBuddy(this.chnos);
			}
			// バディ
			this.$refs.buddy[card[4]-1].applyBuddy(this.cardData[card].values);
			for(var i = 0; i < 5; i++){
				this.$refs.buddy[i].changeBuddy(this.chnos);
			}
			// ダメージ計算
			this.$refs.damage1[card[4]-1].applyMbuf(this.cardData[card].values);
			this.$refs.damage2[card[4]-1].applyMbuf(this.cardData[card].values);
			// ここで属性ダメージを初期化する
			for(var i = 0; i < 5; i++){
				this.$refs.damage1[i].clearAttribute();
				this.$refs.damage2[i].clearAttribute();
			}
			// 属性ダメージUP持ちがいるか判定
			for(var i = 0; i < 5; i++){ // 順番ミスると認識されない
				this.$refs.damage1[i].changeAttribute();
				this.$refs.damage2[i].changeAttribute();
			}
			// ダメージ計算
			for(var i = 0; i < 5; i++){
				this.$refs.damage1[i].calcDamage(this.cardData["card"+(i+1)].values, this.chnos);
				this.$refs.damage2[i].calcDamage(this.cardData["card"+(i+1)].values, this.chnos);
			}
		},
		// バディ補正ステータスを追加する用
		extractHPATK(card, hpbuf, atkbuf){
			this.cardData[card].values.hpbuf = hpbuf;
			this.cardData[card].values.atkbuf = atkbuf;
		},
		// 基礎ステータスいじった時(MAX,無凸MAX含む)
		changeBasicValue(card, hp, atk){
			this.cardData[card].values["hp"] = hp;
			this.cardData[card].values["atk"] = atk;
			this.applyData(card);
		},
		// バディLvをいじった時
		changeBuddyLv(cid, bid, value){
			this.cardData["card"+cid].values["b"+bid+"lv"] = value;
			this.applyData("card"+cid);
		},
		// 魔法Lvをいじった時
		changeMasicLv(cid, mid, value){
			this.cardData["card"+cid].values["m"+mid+"lv"] = value;
			this.applyData("card"+cid);
		},
		// 属性ダメージUPのチェックボックス追加
		giveAttribute(card, m, attribute, lv){
			console.log("att::"+card+":"+m+":"+attribute+":"+lv);
			for(var i = 0; i < 5; i++){
				this.$refs.damage1[i].getAttribute(attribute, lv);
				this.$refs.damage2[i].getAttribute(attribute, lv);
			}
		},
		changeTotalDamage(card, m, masic, basicDamage, recovery, use){
			this.$refs.total.applyTotalDamage(card, m, masic, basicDamage, recovery, use, this.cardData[card].values.hpbuf);
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
		background: #2e2930;
		color: #ffffff;
		font-size: 13px;
	}
	.card{
		width: 115px;
		display: inline-block;
		text-align: center;
		border: 2px solid #e6b422;
	}
	.cards{
		display: inline-flex;
		background: #fbfaf5;
		/* border: 5px double #e6b422; */
	}
	table{
		width: 100%;
	}
</style>