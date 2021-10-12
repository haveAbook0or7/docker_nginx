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
                <select-own :id="this.id_name+'_b1lv'" :op="'opLv'" 
                    :initial="this.buddyLv[1]" :disabled="this.disabled[1]" ref="b1lv" @up-value="changeData"></select-own>
            </td>
            <td>
                <select-own :id="this.id_name+'_b2lv'" :op="'opLv'" 
                    :initial="this.buddyLv[2]" :disabled="this.disabled[2]" ref="b2lv" @up-value="changeData"></select-own>
            </td>
            <td>
                <select-own :id="this.id_name+'_b3lv'" :op="'opLv'" 
                    :initial="this.buddyLv[3]" :disabled="this.disabled[3]" ref="b3lv" @up-value="changeData"></select-own>
            </td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
        'select-own': httpVueLoader('../select-own.vue'),
    },
	props: {
		id_name: {default:"own"},
        init_buddy1: {default: -1},
        init_buddy2: {default: -1},
        init_buddy3: {default: -1},
        init_lv1: {default: 0},
        init_lv2: {default: 0},
        init_lv3: {default: 0},
	},
    computed: {
		img: {
			get(){
				var applyimg = {1: "none.jpg", 2: "none.jpg", 3: "none.jpg"};
                for(var i = 1; i <= 3; i++){
                    // 画像のファイル名に変換
                    applyimg[i] = this["init_buddy"+i] == -1 ? "none.jpg" : this["init_buddy"+i]+".jpg";
                    // SRやRなら画像を暗く
                    this.imgflg[i] = this["init_buddy"+i] == -1 ? "off.png" : "app.png";
                }
                return applyimg;
			}
		},
        disabled: {
            get(){
				var applydisabled = {1: true, 2: true, 3: true};
                for(var i = 1; i <= 3; i++){
                    // SRやRならバディLv操作できないようにする
                    applydisabled[i] = this["init_buddy"+i] == -1 ? true : false;
                }
                return applydisabled;
			}
        }
	},
	data: function () {
		return {
            imgflg: {1: "off.png", 2: "off.png", 3: "off.png"},
            buddyLv: {1: this.init_lv1, 2: this.init_lv2, 3: this.init_lv3},
		}
	},
	methods: {
        changeData(id, value){
            switch(id){
                case this.id_name+'_b1lv':
                    this.buddyLv[1] = value;
                    break;
                case this.id_name+'_b2lv':
                    this.buddyLv[2] = value;
                    break;
                case this.id_name+'_b3lv':
                    this.buddyLv[3] = value;
                    break;
            }
            this.$emit('change', this.id_name, "buddy", {1: parseInt(this.buddyLv[1]), 2: parseInt(this.buddyLv[2]), 3: parseInt(this.buddyLv[3])});
        },
        getData(){
            return this.buddyLv;
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