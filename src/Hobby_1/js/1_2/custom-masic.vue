<template>
	<table border="0">
        <tr>
			<td>
				<img :id="this.id_name+'_m1'" :src="'../img/Element/'+this.m1Img" width="25" height="25">
			</td>
            <td>
                Lv<select-own :id="this.id_name+'_m1lv'" :op="'opLv'" :initial="this.m1Lv" ref="m1lv" @up-value="changeData"></select-own>
            </td>
        </tr>
		<tr>
			<td>
				<img :id="this.id_name+'_m2'" :src="'../img/Element/'+this.m2Img" width="25" height="25">
			</td>
            <td>
                Lv<select-own :id="this.id_name+'_m2lv'" :op="'opLv'" :initial="this.m2Lv" ref="m2lv" @up-value="changeData"></select-own>
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
		init_masic1: {default: "1S1"},
		init_masic2: {default: "1S1"},
		init_lv1: {default: 0},
		init_lv2: {default: 0},
	},
	computed: {
		m1Img: {
			get(){
                return this.element[this.init_masic1[0]];
			}
		},
        m2Img: {
            get(){
                return this.element[this.init_masic2[0]];
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
		changeData(){
            this.$emit('change', this.id_name);
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
</style>