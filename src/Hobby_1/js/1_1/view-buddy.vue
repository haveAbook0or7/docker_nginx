<template>
	<table border="0" class="view-buddy" :style="variable">
        <tr>
            <td>
                <img class="imgflg" :src="'../img/'+v_buddy[1]">
                <img class="img" :src="'../img/Another/'+v_img[1]">
            </td>
            <td>
                <img class="imgflg" :src="'../img/'+v_buddy[2]">
                <img class="img" :src="'../img/Another/'+v_img[2]">
            </td>
            <td>
                <img class="imgflg" :src="'../img/'+v_buddy[3]">
                <img class="img" :src="'../img/Another/'+v_img[3]">
            </td>
        </tr>
        <tr>
            <td>{{v_Btype_1[1]}}<br>{{v_Btype_2[1]}}</td>
            <td>{{v_Btype_1[2]}}<br>{{v_Btype_2[2]}}</td>
            <td>{{v_Btype_1[3]}}<br>{{v_Btype_2[3]}}</td>
        </tr>
        <tr>
            <td>
                <select-option op="opLv" v-model="values.b1lv" :disabled="values.b1 == -1 || values.b1 == undefined"></select-option>
            </td>
            <td>
                <select-option op="opLv" v-model="values.b2lv" :disabled="values.b2 == -1 || values.b2 == undefined"></select-option>
            </td>
            <td>
                <select-option op="opLv" v-model="values.b3lv" :disabled="values.b3 == -1 || values.b3 == undefined"></select-option>
            </td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
        'select-option': httpVueLoader('../select-option.vue'),
        'select-own': httpVueLoader('../select-own.vue'),
    },
	props: {
		id_name: {default:"myselectimg"},
        media: {default: "PCH"},
        chnos: {default: ()=>[0,0,0,0,0],},
        values: {default: {}},
	},
    computed: {
		variable() {
			switch(this.media.slice(0, -1)){
				case "PC":
					return {
						"--FS": "12px",
                        "--selectW": "initial",
						"--selectH": "initial",
					}
				case "TabletPC":
					return {
						"--FS": "16px",
                        "--selectW": "50px",
						"--selectH": "26px",
					}
				case "SmartPhone":
					return {
						"--FS": "18px",
                        "--selectW": "50px",
						"--selectH": "26px",
					}
			}
		},
        v_img:{
            get(){
                let img = {1: "none.jpg", 2: "none.jpg", 3: "none.jpg"};
                if(this.values.b1 != undefined){
                    for(var i = 1; i <= 3; i++){
                        img[i] = this.values["b"+i] == -1 ? "none.jpg" : this.values["b"+i]+".jpg";
                    }
                }
                return img;
            }
        },
        v_buddy:{
            get(){
                let buddy = {1: "off.png", 2: "off.png", 3: "off.png"};
                if(this.values.b1 != undefined){
                    buddy = this.isBuddy();
                }
                return buddy;
            }
        },
        v_Btype_1:{
            get(){
                let types = {1: "***", 2: "***", 3: "***"};
                if(this.values.b1type != undefined){
                    for(var i = 1; i <= 3; i++){
                        let type = this.values["b"+i+"type"];
                        types[i] = this.buddytype[type.substr(0, 2)];
                    }
                }
                return types;
            }
        },
        v_Btype_2:{
            get(){
                let types = {1: "***", 2: "***", 3: "***"};
                if(this.values.b1type != undefined){
                    for(var i = 1; i <= 3; i++){
                        let type = this.values["b"+i+"type"];
                        if(type.length == 4){
                            types[i] = this.buddytype[type.substr(2)];
                        }
                    }
                }
                return types;
            }
        },
	},
	data: function () {
		return {
			buddytype: {
                Hm: "H(中)", Hs: "H(小)",
                Am: "A(中)", As: "A(小)"
			},
		}
	},
	methods: {
        isBuddy(){
            // 計算用変数
            let flg = {1: "off.png", 2: "off.png", 3: "off.png"};
            // バディが成立していたらアイコンを点灯する
            for(var i = 0; i < 5; i++){
                for(var j = 1; j <= 3; j++){
                    if(this.values["b"+j] == this.chnos[i]){
                        flg[j] = "app.png";
                    }
                }
            }
            return flg;
        }
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
        background: #2e2930;
        font-size: var(--FS);
	}
    img{
        background: transparent;
        width: 35px;
        height: 35px;
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
    .select-own{
        width: var(--selectW);
        height: var(--selectH);
    }
</style>