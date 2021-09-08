<template>
	<table border="0" class="TBuddy">
        <tr>
            <td>
                <img :id="this.id_name+'_buddy1flg'" class="imgflg" :src="this.imgflg[1]" width="35" height="35">
                <img :id="this.id_name+'_buddy1'" class="img" :src="'../img/Another/'+this.img[1]" width="35" height="35">
            </td>
            <td>
                <img :id="this.id_name+'_buddy2flg'" class="imgflg" :src="this.imgflg[2]" width="35" height="35">
                <img :id="this.id_name+'_buddy2'" class="img" :src="'../img/Another/'+this.img[2]" width="35" height="35">
            </td>
            <td>
                <img :id="this.id_name+'_buddy3flg'" class="imgflg" :src="this.imgflg[3]" width="35" height="35">
                <img :id="this.id_name+'_buddy3'" class="img" :src="'../img/Another/'+this.img[3]" width="35" height="35">
            </td>
        </tr>
        <tr>
            <td :id="this.id_name+'_b1ty'">{{Btype1[1]}}<br>{{Btype2[1]}}</td>
            <td :id="this.id_name+'_b2ty'">{{Btype1[2]}}<br>{{Btype2[2]}}</td>
            <td :id="this.id_name+'_b3ty'">{{Btype1[3]}}<br>{{Btype2[3]}}</td>
        </tr>
        <tr>
            <td>
                <select-own :id="this.id_name+'_b1lv'" :op="'opLv'" ref="b1lv" @up-value="changeBuddyLv"></select-own>
            </td>
            <td>
                <select-own :id="this.id_name+'_b2lv'" :op="'opLv'" ref="b2lv" @up-value="changeBuddyLv"></select-own>
            </td>
            <td>
                <select-own :id="this.id_name+'_b3lv'" :op="'opLv'" ref="b3lv" @up-value="changeBuddyLv"></select-own>
            </td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
		// 'select-own': httpVueLoader('http://haveabook.php.xdomain.jp/editing/js/Hobby_1/select-own.vue'),
        'select-own': httpVueLoader('http://localhost:8080/Hobby_1/js/select-own.vue'),
    },
	props: {
		id_name: {default:"myselectimg"},
	},
	data: function () {
		return {
			buddytype: {
                Hm: "H(中)", Hs: "H(小)",
                Am: "A(中)", As: "A(小)"
			},
            values: {},
            chnos: [],
            imgflg: {1: "../img/off.png", 2: "../img/off.png", 3: "../img/off.png"},
            img: {1: "none.jpg", 2: "none.jpg", 3: "none.jpg"},
            Btype1: {1: "***", 2: "***", 3: "***"},
            Btype2: {1: "***", 2: "***", 3: "***"},
		}
	},
	methods: {
		applyBuddy(values){
            for(var i = 1; i <= 3; i++){
                this.img[i] = values["b"+i]+".jpg";
                //dataのオブジェクトを含む更新をする場合はこうしないと反映されない
                var Btype = values["b"+i+"type"];
                console.log(Btype);
                this.$set(this.Btype1, i, this.buddytype[Btype[0]+Btype[1]]);
                this.Btype2[i] = "***";
                if(Btype.length == 4){
                    this.$set(this.Btype2, i, this.buddytype[Btype[2]+Btype[3]]);
                }
                this.$refs["b"+i+"lv"].chengeValue(values["b"+i+"lv"]);
            }
		},
        changeBuddyLv(value){
            console.log(value);
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
    .img{
        position: relative;
    }
    .imgflg{
        position: absolute;
        z-index: 2;
    }
	table{
        font-size: 12px;
		background: palevioletred;
	}
    td{
        text-align: center;
    }
</style>