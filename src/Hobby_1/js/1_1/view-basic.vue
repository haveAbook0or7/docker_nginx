<template>
	<table border="0" class="view-basic" :style="variable">
        <tr>
            <td>HP</td>
            <td>
                <input type="text" v-model="v_hpbuf" readonly>
            </td>
            <td>
                <input type="text" v-model.number="v_hp">
            </td>
        </tr>
        <tr>
            <td>ATK</td>
            <td>
                <input type="text" :value="v_atkbuf" readonly>
            </td>
            <td>
                <input type="text" v-model.number="v_atk">
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
        media: {default: "PCH"},
        chnos: {default: ()=>[0,0,0,0,0],},
        values: {default: {}},
	},
    computed: {
		variable() {
			switch(this.media.slice(0, -1)){
				case "PC":
					return {
						"--FS": "13px",
						"--textW": "40px",
						"--textH": "18px",
					}
				case "TabletPC":
					return {
						"--FS": "18px",
						"--textW": "60px",
						"--textH": "25px",
					}
				case "SmartPhone":
					return {
						"--FS": "18px",
						"--textW": "60px",
						"--textH": "20px",
					}
			}
		},
        v_hp:{
            get(){ return this.values.hp;},
            set(value){
                const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
                    this.values.hp = value;
                    this.$emit('update:values', this.values);
				}
            }
        },
        v_atk:{
            get(){ return this.values.atk},
            set(value){
                const regex = /^[0-9]{3,5}$/
				if(regex.test(value)){
                    this.values.atk = value;
					this.$emit('update:values', this.values)
				}
            }
        },
        v_hpbuf:{
            get(){
                if(this.values.hp == undefined){
                    return;
                }
                let mag = this.isBuddy();
                this.$emit(
                    'update:values', 
                    Object.assign(this.values, {
						hpbuf: this.values.hp * (mag.H + 1)
					})
                );
                return this.values.hpbuf;
            }
        },
        v_atkbuf:{
            get(){
                if(this.values.atk == undefined){
                    return;
                }
                let mag = this.isBuddy();
                this.$emit(
                    'update:values', 
                    Object.assign(this.values, {
						atkbuf: this.values.atk * (mag.A + 1)
					})
                );
                return this.values.atkbuf;
            }
        },
	},
	data: function () {
		return {
			BuddyLv: {
                As : [0.11, 0.12, 0.13, 0.14, 0.15, 0.16, 0.17, 0.18, 0.19, 0.2],
                Am : [0.215, 0.23, 0.245, 0.26, 0.275, 0.29, 0.305, 0.32, 0.335, 0.35],
                Hs : [0.11, 0.12, 0.13, 0.14, 0.15, 0.16, 0.17, 0.18, 0.19, 0.2],
                Hm : [0.21, 0.22, 0.23, 0.24, 0.25, 0.26, 0.27, 0.28, 0.29, 0.3]
            },
		}
	},
	methods: {
        isBuddy(){
            // 計算用変数
            var mag = {A: 0, H: 0};
            var flg = {1: false, 2: false, 3: false};
            // バディが成立していたら補正倍率を追加
            for(var i = 0; i < 5; i++){
                for(var j = 1; j <= 3; j++){
                    if(this.values["b"+j] == this.chnos[i] && !flg[j]){
                        var Btype = this.values["b"+j+"type"];
                        var Blv = this.values["b"+j+"lv"];
                        mag[Btype[0]] += this.BuddyLv[Btype[0]+Btype[1]][Blv - 1];
                        if(Btype.length == 4){
                            mag[Btype[2]] += this.BuddyLv[Btype[2]+Btype[3]][Blv - 1];
                        }
                        flg[j] = true;
                    }
                }
            }
            return mag;
        },
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
    *{
		background: #2e2930;
        font-size: var(--FS);
	}
    input[type=text]{
        height: var(--textH);
		width: var(--textW);
        border-radius: 2px;
    }
    input[type=text]:read-only{
		border: 1px solid #aaaaaa;
	}
    input[type=text]:read-write{
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
        caret-color: #2e2930;
	}
</style>