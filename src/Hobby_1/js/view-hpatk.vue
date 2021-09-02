<template>
	<table border="0" class="THpAtk">
        <tr>
            <td colspan="3" style="text-align: center;">
                <span class="button" :value="this.id_name" @click="clickMAX(this.id_name,'max')">MAX</span>
                <span class="button" :value="this.id_name" @click="clickMAX(this.id_name, 'middle')">無凸MAX</span>
            </td>
        </tr>
        <tr>
            <td class="lbl">HP</td>
            <td>
                <input :id="this.id_name+'_hpbuf'" class="text" type="text" :value="this.hpbuf" readonly>
            </td>
            <td>
                <input :id="this.id_name+'_hp'" class="textOn" type="text" :value="this.hp">
            </td>
        </tr>
        <tr>
            <td class="lbl">ATK</td>
            <td>
                <input :id="this.id_name+'_atkbuf'" class="text" type="text" :value="this.atkbuf" readonly>
            </td>
            <td>
                <input :id="this.id_name+'_atk'" class="textOn" type="text" :value="this.atk">
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
        initialHP: {default: 0},
        initialATK: {default: 0},
	},
	data: function () {
		return {
			BuddyLv: {
                As : [0.11, 0.12, 0.13, 0.14, 0.15, 0.16, 0.17, 0.18, 0.19, 0.2] ,
                Am : [0.215, 0.23, 0.245, 0.26, 0.275, 0.29, 0.305, 0.32, 0.335, 0.35] ,
                Hs : [0.11, 0.12, 0.13, 0.14, 0.15, 0.16, 0.17, 0.18, 0.19, 0.2] ,
                Hm : [0.21, 0.22, 0.23, 0.24, 0.25, 0.26, 0.27, 0.28, 0.29, 0.3]
            },

            hp: this.initialHP,
            atk: this.initialATK,
            hpbuf: this.initialHP,
            atkbuf: this.initialATK,
		}
	},
	methods: {
        changeBufStatues(){

        },
        applyHPATK(hp, atk){
            this.hp = hp;
            this.atk = atk;
        },
        clickMAX(card, which){

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
	table{
		background: palevioletred;
	}
	.text{
		height: 1.5em;
		width: 40px;
		background: #b3ada0;
	}
    .textOn{
		height: 1.5em;
        width: 40px;
        background: white;
        border: 2px solid #e6b422; 
	}
    .button{
        display: inline-block;
        text-align: left;
        background-color: #e6b422;
        font-size: 10px;
        color: rgb(255, 255, 255);
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed rgb(255, 255, 255);
        margin: 0 2px;
        box-shadow: #e6b422 0px 0px 0px 3px;
    }
    .button:hover {
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
        /* border-style: solid; */
    }
</style>