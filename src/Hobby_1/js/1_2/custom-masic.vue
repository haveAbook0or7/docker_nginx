<template>
	<table border="0">
        <tr>
			<td>
				<img :id="this.id_name+'_m1'" :src="'../img/Element/'+this.m1Img" width="25" height="25">
			</td>
            <td>
                Lv<select-own :id="this.id_name+'_m1lv'" :op="'opLv'" ref="m1lv" @up-value="changeLv"></select-own>
            </td>
        </tr>
		<tr>
			<td>
				<img :id="this.id_name+'_m2'" :src="'../img/Element/'+this.m2Img" width="25" height="25">
			</td>
            <td>
                Lv<select-own :id="this.id_name+'_m2lv'" :op="'opLv'" ref="m2lv" @up-value="changeLv"></select-own>
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
			m1Img: "Nomal.jpg",
			m2Img: "Nomal.jpg",
			m1Lv: 0,
			m2Lv: 0,
		}
	},
	methods: {
        // 受け取ったデータを保存
        applyHPATK(values){

        },
		changeLv(value){

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