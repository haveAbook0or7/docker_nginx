<template>
	<div class="cards">
		<div class="card" v-for="card in this.cardDatas" :key="card.cdno">
			<img :src="'../img/'+Dormitory[Math.floor(card.chno/10)]+'/'+card.img" width="70.5" height="74.7">
			<custom-basic 
				:id_name="card.cdno" 
				:init_lv="card.lv" 
				:init_hp="card.hp" 
				:init_atk="card.atk"></custom-basic>
			<custom-masic 
				:id_name="card.cdno" 
				:init_masic1="card.m1_1" 
				:init_masic2="card.m2_1" 
				:init_lv1="card.m1lv" 
				:init_lv2="card.m2lv"></custom-masic>
			<custom-buddy 
				:id_name="card.cdno" 
				:init_buddy1="card.b1" 
				:init_buddy2="card.b2" 
				:init_buddy3="card.b3" 
				:init_lv1="card.b1lv" 
				:init_lv2="card.b2lv" 
				:init_lv3="card.b3lv"></custom-buddy>
		</div>
	</div>
</template>

<script>
module.exports = {
	components: {
		'custom-masic': httpVueLoader('./custom-masic.vue'),
		'custom-buddy': httpVueLoader('./custom-buddy.vue'),
		'custom-basic': httpVueLoader('./custom-basic.vue'),
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
				var copyData = JSON.parse(JSON.stringify(this.datas));
				console.log(copyData);
				var adjustData = {};
				for(var i = 0; i < copyData.length; i++){
					adjustData[copyData[i].cdno] = copyData[i];
				}
				console.log(adjustData);
                return adjustData;
			}
		},
	},
	data: function () {
		return {
			Dormitory: ["","Heartslabyul","Savanaclaw","Octavinelle","Scarabia","Pomefiore","Ignihyde","Diasomnia","Ramshackle"],
			datas: [],
			message: "",
		}
	},
	methods: {
		
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
</style>