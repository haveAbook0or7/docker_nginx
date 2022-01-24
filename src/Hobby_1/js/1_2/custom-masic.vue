<template>
	<table border="0" :class="media" :style="variable">
        <tr>
			<td>
				<img :id="this.id_name+'_m1'" :src="'../img/Element/'+this.m1Img" width="25" height="25">
			</td>
            <td>
                Lv<select-own :id="this.id_name+'_m1lv'" :op="'opLv'" :initial="this.m1Lv" :disabled="this.disabled" ref="m1lv" @up-value="changeData"></select-own>
            </td>
        </tr>
		<tr>
			<td>
				<img :id="this.id_name+'_m2'" :src="'../img/Element/'+this.m2Img" width="25" height="25">
			</td>
            <td>
                Lv<select-own :id="this.id_name+'_m2lv'" :op="'opLv'" :initial="this.m2Lv" :disabled="this.disabled" ref="m2lv" @up-value="changeData"></select-own>
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
		media: {default:"PC"},
		id_name: {default:"own"},
		show_flg: {default: true},
		init_masic1: {default: "1S1"},
		init_masic2: {default: "1S1"},
		init_lv1: {default: 0},
		init_lv2: {default: 0},
	},
	computed: {
		variable() {
			switch(this.media){
				case "PC":
					return {
						"--FS": "13px",
						"--selectW": "initial",
						"--selectH": "initial",
						"--border": "2px",
						"--imgW": "1",
						"--imgH": "1",
					}
				case "TabletPC":
					return {
						"--FS": "20px",
						"--selectW": "60px",
						"--selectH": "30px",
						"--border": "3px",
						"--imgW": "1.5",
						"--imgH": "1.5",
					}
				case "SmartPhone":
					return {
						"--FS": "50px",
						"--selectW": "160px",
						"--selectH": "70px",
						"--border": "6px",
						"--imgW": "3",
						"--imgH": "3",
					}
			}
		},
		m1Img: {
			get(){
                return this.element[this.init_masic1[0]];
			}
		},
        m2Img: {
            get(){
                return this.element[this.init_masic2[0]];
			}
        },
		disabled: {
            get(){
				// 閲覧モードなら魔法Lv操作できないようにする
                return !this.show_flg;
			}
        }
	},
	data: function () {
		return {
			element: ["Nomal.jpg", "Fire.jpg", "Tree.jpg", "Water.jpg"],
			m1Lv: this.init_lv1,
			m2Lv: this.init_lv2,
		}
	},
	methods: {
		changeData(id, value){
			switch(id){
                case this.id_name+'_m1lv':
                    this.m1Lv = value;
                    break;
                case this.id_name+'_m2lv':
                    this.m2Lv = value;
                    break;
            }
            this.$emit('change', this.id_name, "masic", {1: parseInt(this.m1Lv), 2: parseInt(this.m2Lv)});
        },
		getData(){
            return {1: this.m1Lv, 2: this.m2Lv};
        }
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
    *{
		background: #2e2930;
		color: white;
	}
	table{
		width: 100%;
	}
	td{
        font-size: var(--FS);
    }
	.select-own{
        height: var(--selectH);
		width: var(--selectW);
		font-size: var(--FS);
		border-bottom-width: var(--border);
    }
	img{
		width: calc(25px * var(--imgW));
		height: calc(25px * var(--imgH));
	}
</style>