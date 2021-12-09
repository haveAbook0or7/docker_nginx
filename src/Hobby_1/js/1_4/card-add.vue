<template>
	<div>
		<h2>
			<input class="update" type="button" value="追加" @click="clickDataSave" v-if="showFlg">
			<span class="res">{{this.responseMsg}}</span>
		</h2>
		<br><br><br>
		<div class="cards">
			<div class="card" v-for="card in this.cardDatas" :key="card.cdno">
				<input-noimg @change="getNoImgData"></input-noimg>
				<input-basic 
					:lv_1.sync="card.lvone" :lv_mid.sync="card.lvmiddle" :lv_max.sync="card.lvmax" 
					:hp_1.sync="card.hpone" :hp_mid.sync="card.hpmiddle" :hp_max.sync="card.hpmax" 
					:atk_1.sync="card.atkone" :atk_mid.sync="card.atkmiddle" :atk_max.sync="card.atkmax" 
				></input-basic>
				<input-masic 
					:m_lv1.sync="card.m1_1" :m_lv5.sync="card.m1_5" :m_lv10.sync="card.m1_10" 
					:mbuf_lv1.sync="card.m1buf_1" :mbuf_lv5.sync="card.m1buf_5" :mbuf_lv10.sync="card.m1buf_10"
				></input-masic>
			</div>
		</div>
	</div>
</template>

<script>
module.exports = {
	components: {
		'input-masic': httpVueLoader('./input-masic.vue'),
		'input-buddy': httpVueLoader('./input-buddy.vue'),
		'input-basic': httpVueLoader('./input-basic.vue'),
		'input-noimg': httpVueLoader('./input-noimg.vue'),
    },
	props: {
		mydbname: {default:"H1_2_DefaultDataMax"},
		init_msg: {default:"initMsg"},
	},
    mounted(){
        var datas = [];
        for(var i = 4; i >= 1; i--){
            datas.push({
                cdno: null,
                chno: null,
                img: null,
				imgname: null,

                lvone: 1,
                lvmiddle: 40 + 20 * (i / 2 | 0),
                lvmax: (40 + 20 * (i / 2 | 0)) + 20,
                hpone: null,
                hpmiddle: null,
                hpmax: null,
                atkone: null,
                atkmiddle: null,
                atkmax: null,

                m1_1: null,
                m1_5: null,
                m1_10: null,
                m1buf_1: null,
                m1buf_5: null,
                m1buf_10: null,
                m2_1: null,
                m2_5: null,
                m2_10: null,
                m2buf_1: null,
                m2buf_5: null,
                m2buf_10: null,

                b1: null,
                b1type: null,
                b2: null,
                b2type: null,
                b3: null,
                b3type: null,
            });
        }
        this.cardDatas = datas;
    },
	computed: {
		showFlg: {
			get(){
				return this.mydbname == "H1_2_DefaultDataMax" ? false : true;
			}
		},
	},
	data: function () {
		return {
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			flexibleDatas: [],
			cardDatas: [],
			message: "",

			changeFlg: [],

			responseMsg: this.init_msg,
		}
	},
	methods: {
		clickDataSave(){
			console.log(this.cardDatas[0]);
		},
		getNoImgData(img, imgname, cdno, chno){
			console.log(img);
			console.log(imgname+" "+cdno+" "+chno);
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
	h2{
		box-sizing: border-box;
		position: fixed;
		width: 905px;
		height: 48px;
		margin: 10px 0;
		border-right: 15px solid #fbfaf5;
		font: normal 30px "游ゴシック",serif;
		background-color: #e6b422;
		color: #fbfaf5;
		z-index: 5;
	}
	.cards{
		background: #fbfaf5;
		width: 905px;
	}
	.card{
		width: 443px;
		margin: 2.5px;
		display: inline-block;
		text-align: center;
		border: 2px solid #e6b422;
		background: #2e2930;
	}
	table{
		width: 100%;
	}
	.update{
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
	.update:active{
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
    }
	.update{
		width: 50px;
        height: 24px;
		font-size: 13px;
		font-weight:normal;
		left: 5px;
	}
	.res{
		position: absolute;
		left: 70px;
		bottom: 6px;
		font-size: 16px;
		font-style: italic;
	}
</style>