<template>
	<div class="pre-register-form">
		<!-- 初期画面 -->
		<table border="0" v-show="showflg && !tempFlg">
        <tr>
			<td>メールアドレス</td>
            <td><input type="text" v-model="emailaddress" @input="inputAddr" @keydown.enter="tempRegister"></td>
        </tr>
        </table>
		<span id="err">{{this.errMsg}}</span>
        <input type="button" value="仮登録" v-show="showflg && !tempFlg" :disabled="!errFlg" @click="tempRegister" @keydown.enter="tempRegister">
		<!-- エラー -->
        <table border="0" v-show="!showflg">
        <tr>
			<td>{{this.msg}}</td>
        </tr>
        </table>
		<!-- 登録完了 -->
        <table border="0" v-show="tempFlg">
        <tr>
			<td>
				{{this.msg}}<br>
				受信したメールのURLから本登録を行ってください。
			</td>
        </tr>
        </table>
	</div>
</template>

<script>
module.exports = {
	data: function () {
		return {
			emailaddress: "",
			showflg: true,
			tempFlg: false,
            msg: "",
			errMsg: "",
			errFlg: false,
		}
	},
	methods: {
		tempRegister(){
			if(this.errFlg){
				axios.post("../php/Hobby_1_3_DBPreRegister.php",{
					email: this.emailaddress,
				})
				.then(response => {
					this.showflg = response.data.data.flg;
					this.tempFlg = response.data.data.flg;
					this.msg = response.data.message;
				})
				.catch(function (error) {
					console.log(error);
				});
			}
		},
		inputAddr(){
			const regex = /^[a-zA-Z0-9_+-]+(\.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
			if(regex.test(this.emailaddress)){
				this.errMsg = "";
				this.errFlg = true;
            }else{
				this.errMsg = "これはメールアドレスの形式ではありません。";
				this.errFlg = false;
			}
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
		color: #ffffff;
		font-size: 13px;
		text-align: center;
	}
    .pre-register-form{
		display: flex;
        position: relative;
		background: #2e2930;
		border: 5px double #e6b422;
        height: 200px;
        width: 500px;
        margin: auto;
	}
    table{
		width: 100%;
        height: 85%;
        margin: 0 8%;
	}
	td{
		width: 50%;
	}
    input:read-write{
		height: 18px;
		width: 200px;
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
	#err{
		position: absolute;
		top: 50%;
		left: 50%;
		color: #ea5532;
		font-size: 11.5px;
	}
</style>