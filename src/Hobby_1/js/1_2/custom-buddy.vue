<template>
	<table border="0">
        <tr>
            <td>
                <img :id="this.id_name+'_buddy1flg'" class="imgflg" :src="'../img/'+this.imgflg[1]" width="35" height="35">
                <img :id="this.id_name+'_buddy1'" class="img" :src="'../img/Another/'+this.img[1]" width="35" height="35">
            </td>
            <td>
                <img :id="this.id_name+'_buddy2flg'" class="imgflg" :src="'../img/'+this.imgflg[2]" width="35" height="35">
                <img :id="this.id_name+'_buddy2'" class="img" :src="'../img/Another/'+this.img[2]" width="35" height="35">
            </td>
            <td>
                <img :id="this.id_name+'_buddy3flg'" class="imgflg" :src="'../img/'+this.imgflg[3]" width="35" height="35">
                <img :id="this.id_name+'_buddy3'" class="img" :src="'../img/Another/'+this.img[3]" width="35" height="35">
            </td>
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
            values: {},
            chnos: [],
            imgflg: {1: "off.png", 2: "off.png", 3: "off.png"},
            img: {1: "none.jpg", 2: "none.jpg", 3: "none.jpg"},
		}
	},
	methods: {
        // 受け取ったデータを保存。表示できるやつは表示
		applyBuddy(values){
            this.values = values;
            for(var i = 1; i <= 3; i++){
                // アイコンを表示
                this.img[i] = values["b"+i] == -1 ? "none.jpg" : values["b"+i]+".jpg";
                // バフの種類を表示していく
                var Btype = values["b"+i+"type"];
                this.$set(this.Btype1, i, this.buddytype[Btype[0]+Btype[1]]); // dataのオブジェクトを含む更新をする場合はこうしないと反映されない
                this.Btype2[i] = "***";
                if(Btype.length == 4){
                    this.$set(this.Btype2, i, this.buddytype[Btype[2]+Btype[3]]);
                }
                // バディレベルをセット
                this.$refs["b"+i+"lv"].chengeValue(values["b"+i+"lv"]);
                // SRやRならバディLv操作できないようにする
                this.$refs["b"+i+"lv"].chengeDisabled(values["b"+i] == -1 ? true : false);
            }
		},
        // 有効バディが変化するときの処理
        changeBuddy(chnos){
            // 現在セットしてるキャラクターIDを取得＆保存
            this.chnos = chnos;
            // 初期化
            this.imgflg = {1: "off.png", 2: "off.png", 3: "off.png"};
            // 計算用変数
            var flg = {1: false, 2: false, 3: false};
            // バディが成立していたらアイコンを点灯する
            for(var i = 0; i < 5; i++){
            for(var j = 1; j <= 3; j++){
                if(this.values["b"+j] == chnos[i] && !flg[j]){
                    this.imgflg[j] = "app.png";
                }
            }
            }
        },
        // バディLvの操作
        changeBuddyLv(id, value){
            this.$emit('change', id[4], id[7], value);
        }
	},
	
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
        background: #2e2930;
        font-size: 12px;
		color: white;
	}
    img{
        background: transparent;
    }
    .img{
        position: relative;
    }
    .imgflg{
        position: absolute;
        z-index: 2;
    }
    td{
        text-align: center;
    }
</style>