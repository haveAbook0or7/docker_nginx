<template>
	<div class="card-select">
		<h2>ユーザーID: {{loguser}}
			<span v-if="is_gest">
				<a href="Hobby_1_2_custom.php" class="italic" target="_blank">カードステータス閲覧</a> 
                <a href="Hobby_1_3_login.php">ログイン</a>
			</span>
			<span v-else>
				<a href="Hobby_1_2_custom.php" class="italic">カードステータス編集</a> 
                <a v-if="is_master" href="Hobby_1_4_add.php" class="italic">カード追加</a> 
				<a :href="'Hobby_1_1_home.php?logout='+loguser">ログアウト</a>
			</span>
		</h2>
		<div class="space"></div>
		<div class="cards">
			<div class="card" v-for="data in cardData" :key="data.id_name">
				<img :id="data.id_name" :src="'../img/'+data.cardImg" width="70.5" height="74.7" @click="clickOpenModal(data.id_name)">
				<view-hpatk :id_name="data.id_name" ref="hpatk" @extract="extractHPATK" @change-basic="changeBasicValue"></view-hpatk>
				<view-buddy :id_name="data.id_name" ref="buddy" @change="changeBuddyLv"></view-buddy>
				<view-damage :id_name="data.id_name" :m="'1'" ref="damage1" @attribute="giveAttribute" @change-lv="changeMasicLv" @calc-damage="changeTotalDamage"></view-damage>
				<view-damage :id_name="data.id_name" :m="'2'" ref="damage2" @attribute="giveAttribute" @change-lv="changeMasicLv" @calc-damage="changeTotalDamage"></view-damage>
			</div>
			<view-total class="total" ref="total"></view-total>
			<choice-modal-card :mydbname="this.mydbname" ref="modal" @choice-card="getCard"></choice-modal-card>
		</div>
		</div>
</template>

<script>
module.exports = {
	components: {
		'view-total': httpVueLoader('./view-total.vue'),
		'view-damage': httpVueLoader('./view-damage.vue'),
		'view-buddy': httpVueLoader('./view-buddy.vue'),
		'view-hpatk': httpVueLoader('./view-hpatk.vue'),
		'choice-modal-card': httpVueLoader('./choice-modal-card.vue'),
    },
	props: {
		loguser: {default: "ゲスト"},
		mydbname: {default:"H1_2_DefaultDataMax"},
	},
	computed: {
		is_master(){
			if(this.loguser == "wakana"){
				return true;
			}
			return false;
		},
		is_gest(){
			if(this.loguser == "ゲスト"){
				return true;
			}
			return false;
		}
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
		// モーダルからカードデータを受け取る
		getCard(value, card){
			// 当てはまるカードにデータ全部保存
			this.cardData[card].values = value;
			// いま選んでるキャラクターIDを保存
			this.chnos[card.slice(-1)-1] = value.chno;
			// データをそれぞれ処理して表示する
			this.applyData(card);
			console.log("values:");
			// console.log(this.chnos);
			console.log(this.cardData[card].values);
		},
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
		color: #ffffff;
		font-size: 13px;
	}
	.card-select{
		width: 905px;
		margin: auto;
	}
	h2{
		box-sizing: border-box;
		position: fixed;
		/* height: var(--h2H);
		width: var(--W); */
		height: 48px;
		width: 905px;
		margin: 10px 0;
		border-right: 15px solid #fbfaf5;
		font: normal 30px "游ゴシック",serif;
		background-color: #e6b422;
		color: #fbfaf5;
		z-index: 3;
	}
	span{
		position: absolute;
		right: 0;
		bottom: 0;
	}
	a{
		font: normal 25px "游ゴシック",serif;
		color: #2e2930;
	}
	.italic{
		font-style: italic;
		font-size: 20px;
	}
	a:visited{
		color: #e4007f;
	}
	.space{
		height: 60px;
	}
	.card{
		width: 140px;
		display: inline-block;
		text-align: center;
	}
	.cards{
		display: inline-flex;
		background: #fbfaf5;
		border: 5px double #e6b422;
	}
	.total{
		border-left: 2px solid #e6b422;
	}
	table{
		width: 100%;
	}
</style>