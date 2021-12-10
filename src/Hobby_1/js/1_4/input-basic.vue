<template>
	<table border="0">
        <tr>
            <td></td><td>Lv1</td><td>無凸MAX</td><td>MAX</td>
        </tr>
        <tr>
            <td>Lv</td>
            <td><select-option op="opAddCard" v-model="this.lv_1" @change="$emit('update:lv_1', this.lv_1)"></select-option></td>
            <td><select-option op="opAddCard" v-model="this.lv_mid" @change="$emit('update:lv_mid', this.lv_mid)"></select-option></td>
            <td><select-option op="opAddCard" v-model="this.lv_max" @change="$emit('update:lv_max', this.lv_max)"></select-option></td>
        </tr>
        <tr>
            <td>HP</td>
            <td><input type="text" maxlength="5" v-model="this.hp_1" @change="$emit('update:hp_1', $event.target.value)"></td>
            <td><input type="text" maxlength="5" v-model="this.hp_mid" @change="$emit('update:hp_mid', $event.target.value)"></td>
            <td><input type="text" maxlength="5" v-model="this.hp_max" @change="$emit('update:hp_max', $event.target.value)"></td>
        </tr>
        <tr>
            <td>ATK</td>
            <td><input type="text" maxlength="5" v-model="this.atk_1" @change="$emit('update:atk_1', $event.target.value)"></td>
            <td><input type="text" maxlength="5" v-model="this.atk_mid" @change="$emit('update:atk_mid', $event.target.value)"></td>
            <td><input type="text" maxlength="5" v-model="this.atk_max" @change="$emit('update:atk_max', $event.target.value)"></td>
        </tr>
    </table>
</template>

<script>
module.exports = {
	components: {
        'select-option': httpVueLoader('../select-option.vue'),
    },
	props: {
        lv_1: {default: 0},
        lv_mid: {default: 0},
        lv_max: {default: 0},
        hp_1: {default: 0},
        hp_mid: {default: 0},
        hp_max: {default: 0},
        atk_1: {default: 0},
        atk_mid: {default: 0},
        atk_max: {default: 0},
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
    *{
		background: #2e2930;
		color: white;
	}
    input[type=text]:read-write{
		height: 18px;
		width: 50px;
		text-align: right;
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
		border-radius: 2px;
        caret-color: #2e2930;
		outline: none;
	}
</style>