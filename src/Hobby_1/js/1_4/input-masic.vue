<template>
	<table border="0">
        <tr>
            <th></th><th>Lv1</th><th>Lv5</th><th>Lv10</th>
        </tr>
        <tr>
            <th>属性</th>
            <td colspan="3"></td>
        </tr>
        <tr>
            <th>連撃</th>
            <td class="right"><select-option op="opAddM_timas" v-model="m_times_1" @change="$emit('update:m_lv1', m_1)"></select-option></td>
            <td class="right"><select-option op="opAddM_timas" v-model="m_times_5" @change="$emit('update:m_lv5', m_5)"></select-option></td>
            <td class="right"><select-option op="opAddM_timas" v-model="m_times_10" @change="$emit('update:m_lv10', m_10)"></select-option></td>
        </tr>
        <tr>
            <th>強弱</th>
            <td class="right"><select-option op="opAddM_power" v-model="m_power_1" @change="$emit('update:m_lv1', m_1)"></select-option></td>
            <td class="right"><select-option op="opAddM_power" v-model="m_power_5" @change="$emit('update:m_lv5', m_5)"></select-option></td>
            <td class="right"><select-option op="opAddM_power" v-model="m_power_10" @change="$emit('update:m_lv10', m_10)"></select-option></td>
        </tr>
        <tr>
            <th rowspan="2">追加効果</th>
            <td>
                <select-option v-for="(m_ef, index) in m_ef_1_1" :key="index" 
                    :op="oplabel[index]" v-model="m_ef_1_1[index]" @change="$emit('update:mbuf_lv1', m_buf_1)" 
                    :disabled="disabled.m_ef_1_1[index]"></select-option>
                <img-select :value.sync="duo1_1" @update:value="$emit('update:mbuf_lv1', m_buf_1)"
                    :disabled="disabled.m_ef_1_1[3]"></img-select>
            </td>
            <td>
                <select-option v-for="(m_ef, index) in m_ef_1_5" :key="index" 
                    :op="oplabel[index]" v-model="m_ef_1_5[index]" @change="$emit('update:mbuf_lv5', m_buf_5)" 
                    :disabled="disabled.m_ef_1_5[index]"></select-option>
                <img-select :value.sync="duo1_5" @update:value="$emit('update:mbuf_lv5', m_buf_5)"
                    :disabled="disabled.m_ef_1_5[3]"></img-select>
            </td>
            <td>
                <select-option v-for="(m_ef, index) in m_ef_1_10" :key="index" 
                    :op="oplabel[index]" v-model="m_ef_1_10[index]" @change="$emit('update:mbuf_lv10', m_buf_10)" 
                    :disabled="disabled.m_ef_1_10[index]"></select-option>
                <img-select :value.sync="duo1_10" @update:value="$emit('update:mbuf_lv10', m_buf_10)"
                    :disabled="disabled.m_ef_1_10[3]"></img-select>
            </td>
        </tr>
        <tr>
            <td>
                <select-option v-for="(m_ef, index) in m_ef_2_1" :key="index" 
                    :op="oplabel[index]" v-model="m_ef_2_1[index]" @change="$emit('update:mbuf_lv1', m_buf_1)"
                    :disabled="disabled.m_ef_2_1[index]"></select-option>
            </td>
            <td>
                <select-option v-for="(m_ef, index) in m_ef_2_5" :key="index" 
                    :op="oplabel[index]" v-model="m_ef_2_5[index]" @change="$emit('update:mbuf_lv5', m_buf_5)" 
                    :disabled="disabled.m_ef_2_5[index]"></select-option>
            </td>
            <td>
                <select-option v-for="(m_ef, index) in m_ef_2_10" :key="index" 
                    :op="oplabel[index]" v-model="m_ef_2_10[index]" @change="$emit('update:mbuf_lv10', m_buf_10)" 
                    :disabled="disabled.m_ef_2_10[index]"></select-option>
            </td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
        'select-option': httpVueLoader('../select-option.vue'),
        'img-select': httpVueLoader('./img-select.vue')
    },
	props: {
        m_lv1: {default: 0},
        m_lv5: {default: 0},
        m_lv10: {default: 0},
        mbuf_lv1: {default: 0},
        mbuf_lv5: {default: 0},
        mbuf_lv10: {default: 0},
	},
    computed: {
		m_1: {
            get(){
                return this.m_att+this.m_times_1+this.m_power_1;
			}
        },
        m_5: {
            get(){
                return this.m_att+this.m_times_5+this.m_power_5;
			}
        },
        m_10: {
            get(){
                return this.m_att+this.m_times_10+this.m_power_10;
			}
        },
        m_buf_1: {
            get(){
                return this.m_ef_1_1.join("") + this.m_ef_2_1.join("") + this.duo1_1;
			}
        },
        m_buf_5: {
            get(){
                return this.m_ef_1_5.join("") + this.m_ef_2_5.join("") + this.duo1_5;
			}
        },
        m_buf_10: {
            get(){
                return this.m_ef_1_10.join("") + this.m_ef_2_10.join("") + this.duo1_10;
			}
        },
        disabled: {
            get(){
                let ef_1_1 = this.switchDisabled(this.m_ef_1_1[0]);
                let ef_1_5 = this.switchDisabled(this.m_ef_1_5[0]);
                let ef_1_10 = this.switchDisabled(this.m_ef_1_10[0]);
                let ef_2_1 = this.switchDisabled(this.m_ef_2_1[0]);
                let ef_2_5 = this.switchDisabled(this.m_ef_2_5[0]);
                let ef_2_10 = this.switchDisabled(this.m_ef_2_10[0]);
                return {
                    m_ef_1_1: [false, ef_1_1.ef, ef_1_1.ef, ef_1_1.duo],
                    m_ef_1_5: [false, ef_1_5.ef, ef_1_5.ef, ef_1_5.duo],
                    m_ef_1_10: [false, ef_1_10.ef, ef_1_10.ef, ef_1_10.duo],
                    m_ef_2_1: [false, ef_2_1.ef, ef_2_1.ef],
                    m_ef_2_5: [false, ef_2_5.ef, ef_2_5.ef],
                    m_ef_2_10: [false, ef_2_10.ef, ef_2_10.ef],
                };
            }
        }
	},
    data: function () {
		return {
            m_att: "",
            m_times_1: "",
            m_times_5: "",
            m_times_10: "",
            m_power_1: "",
            m_power_5: "",
            m_power_10: "",
            oplabel: ["opAddM_effect","opAddM_size","opAddM_turn"],
            m_ef_1_1: ["","",""], m_ef_2_1: ["","",""],
            m_ef_1_5: ["","",""], m_ef_2_5: ["","",""],
            m_ef_1_10: ["","",""], m_ef_2_10: ["","",""],
            duo1_1: "",
            duo1_5: "",
            duo1_10: "",
        }
    },
    methods: {
        switchDisabled(value){
            let flg1 = false;
            let flg2 = false;
            switch(value){
                case "":
                case "nNnn": 
                    flg1 = true;
                    flg2 = true;
                    break;
                case null:
                    flg1 = true;
                    break;
                default:
                    flg2 = true;
            }
            return {ef: flg1, duo: flg2};
        }
    }
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
        border-spacing: 0px;
    }
    th{
        min-width: 55px;
        height: 25px;
    }
    td{
        min-width: 55px;
        text-align: left;
        vertical-align: top;
    }
    .right{
        text-align: right;
    }
    .select-option{
        vertical-align: top;
    }
    .img-select{
        display: inline-block;
        margin: 3px 0;
    }
</style>