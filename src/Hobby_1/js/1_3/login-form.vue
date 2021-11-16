<template>
	<div>
		<meta v-if="reFlg" http-equiv="refresh" content=" 0; url=Hobby_1_1_home.php">
		<table border="0">
        <tr>
			<td>ID(英数字)</td>
            <td><input type="text" v-model="id" @input="inputId"></td>
        </tr>
        <tr>
            <td>パスワード(英数字6～8桁)</td>
            <td><input type="password" v-model="pass" @input="inputPass"></td>
        </tr>
        </table>
		<span class="err" id="idErr">{{this.idErr}}</span>
		<span class="err" id="psErr">{{this.psErr}}</span>
        <input type="button" id="submit" value="ログイン" :disabled="!errFlg" @click="loginCheck">
	</div>
</template>

<script>
module.exports = {
	computed: {
		errFlg: {
            get(){
				console.log(this.id);
                return this.idFlg && this.psFlg ? true : false;
			}
        }
	},
	data: function () {
		return {
			id: "",
			pass: "",
			reFlg: false,
			idErr: "", psErr: "",
			idFlg: false, psFlg: false,
		}
	},
	methods: {
		loginCheck(){
			if(this.errFlg){
				axios.post("../php/Hobby_1_3_DBLogin.php",{
					user: this.id,
					pass: this.pass
				})
				.then(response => {
					this.reFlg = response.data.data.flg;
					this.psErr = response.data.message;
				})
				.catch(function (error) {
					console.log(error);
				});
			}
		},
		inputId(){
			const regex = /^[a-zA-Z0-9]{2,40}$/;
			if(regex.test(this.id)){
				this.idErr = "";
				this.idFlg = true;
            }else{
				this.idErr = "IDは英数字2～40文字です。";
				this.idFlg = false;
			}
		},
        inputPass(){
			const regex = /^[a-zA-Z0-9]{6,8}$/;
			if(regex.test(this.pass)){
				this.psErr = "";
				this.psFlg = true;
            }else{
				this.psErr = "パスワードは英数字6～8文字です";
				this.psFlg = false;
			}
		},
	},
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
		margin: 0;
		padding: 0;
		border: 0;
		color: #ffffff;
		font-size: 13px;
		text-align: center;
	}
    div{
		display: inline-flex;
        position: relative;
		background: #2e2930;
		border: 5px double #e6b422;
        height: 200px;
        width: 500px;
		margin: 0 197.5px;
	}
    table{
		width: 70%;
        height: 85%;
        margin: 0 15%;
	}
    input:read-write{
		height: 18px;
		width: 120px;
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
		border-radius: 2px;
        caret-color: #2e2930;
		text-align: left;
	}
    input[type=button]{
        width: 80px;
        height: 23px;
        display: inline-block;
        text-align: center;
        background-color: #e6b422;
        font-size: 12px;
        text-decoration: none;
        font-weight: bold;
        padding: 1px 2px;
        border: 0.5px dashed #ffffff;
        margin: 0 2px;
        box-shadow: #e6b422 0px 0px 0px 3px;
        z-index: 3;
        position: absolute;
        bottom: 8px;
        right: 8px;
    }
    input[type=button]:hover {
        border-color: #e62253;
    }
	input[type=button]:disabled{
		background-color: #e6dab8;
        box-shadow: #e6dab8 0px 0px 0px 3px;
		border-color: #ffffff;
	}
	.err{
		position: absolute;
		left: 50%;
		color: #ea5532;
		font-size: 11.5px;
	}
	#idErr{
		top: 30%;
	}
	#psErr{
		top: 72%;
	}
</style>