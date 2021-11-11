<template>
    <span>
    <h2>{{this.msg}}</h2>
    <br><br><br>
	<div>
		<!-- トークン照合クリア -->
		<table border="0" v-show="tokenflg && !signupflg">
        <tr>
			<td>ID(英数字)</td>
            <td>
                <input type="text" v-model="id" @input="inputId">
            </td>
        </tr>
        <tr>
			<td>パスワード(英数字6～8桁)</td>
            <td>
                <input type="text" v-model="pass" @input="inputPass">
            </td>
        </tr>
        <tr>
			<td>メールアドレス</td>
            <td>
                <input type="text" v-model="emailaddress" @input="inputAddr">
            </td>
        </tr>
        </table>
		<input type="button" id="submit" value="登録" v-show="tokenflg" @click="register">
		<span class="err" id="idErr">{{this.idErr}}</span>
		<span class="err" id="psErr">{{this.psErr}}</span>
		<span class="err" id="emErr">{{this.emErr}}</span>
		<!-- エラー -->
        <table border="0" v-show="!tokenflg">
        <tr>
			<td>{{this.eMsg}}</td>
        </tr>
        </table>
		<!-- 登録完了 -->
        <table border="0" v-show="signupflg">
        <tr>
			<td>
				登録が完了しました。下記リンクからログインを行ってください。<br>
				<a href="Hobby_1_3_login.php">ログイン</a>
			</td>
        </tr>
        </table>
	</div>
    </span>
</template>

<script>
module.exports = {
    props: {
        token: {default:null},
    },
	mounted() {
		axios.post("../php/Hobby_1_3_DBRegister.php",{
			flg: "mounted",
			token: this.token
		})
		.then(response => {
			console.log(response.data.data);
			this.tokenflg = response.data.data.flg;
			this.emailaddress = response.data.data.email;
		})
		.catch(function (error) {
			console.log(error);
		});
	},
    computed: {
		errFlg: {
            get(){
                return this.idFlg && this.psFlg && this.emFlg ? true : false;
			}
        }
	},
	data: function () {
		return {
            id: "",
            pass: "",
			emailaddress: "",
			tokenflg: false,
            signupflg: false,
			eMsg: "URLが正しくありません。もう一度仮登録からやり直してください。",
			idErr: "", psErr: "", emErr: "",
			idFlg: false, psFlg: false, emFlg: true,
			data: {}
		}
	},
	methods: {
		register(){
			if(this.errFlg){
				this.idErr = "";
				this.psErr = "";
				this.emErr = "";
				axios.post("../php/Hobby_1_3_DBRegister.php",{
					flg: "signup",
					id: this.id,
					pass: this.pass,
					email: this.emailaddress,
				})
				.then(response => {
					console.log(response.data);
					
					if(response.data.data.flg){
						this.signupflg = true;
					}else{
						switch(response.data.data.err){
							case "err":
								this.eMsg = response.data.message;
								this.tokenflg = false;
								break;
							case "idErr":
								this.idErr = response.data.message;
								break;
							case "psErr":
								this.psErr = response.data.message;
								break;
							case "emErr":
								this.emErr = response.data.message;
								break;
						}
					}
					this.data = response.data.data;
					this.msg = response.data.message;
				})
				.catch(function (error) {
					console.log(error);
				});
			}else{
				this.msg = this.errMsg;
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
			console.log(this.idFlg);
			console.log(this.errFlg);
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
			console.log(this.psFlg);
			console.log(this.errFlg);
		},
		inputAddr(){
			const regex = /^[a-zA-Z0-9_+-]+(\.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
			if(regex.test(this.emailaddress)){
				this.emErr = "";
				this.emFlg = true;
            }else{
				this.emErr = "これはメールアドレスの形式ではありません。";
				this.emFlg = false;
			}
			console.log(this.emFlg);
			console.log(this.errFlg);
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
	}
    h2{
		box-sizing: border-box;
		position: fixed;
		width: 905px;
		height: 48px;
		margin: 10px 0;
		border-right: 15px solid #fbfaf5;
		font: normal 30px "游ゴシック",serif;
		background-color: #e6b422;
		color: #fbfaf5;
		z-index: 5;
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
		width: 100%;
        height: 85%;
        margin: 0 8%;
	}
    input:read-write{
		height: 18px;
		width: 200px;
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
		border-radius: 2px;
        caret-color: #2e2930;
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
        background-color: slategray;
        box-shadow: slategray 0px 0px 0px 3px;
    }
	.err{
		position: absolute;
		left: 50%;
		color: #ea5532;
		font-size: 11.5px;
	}
	#idErr{
		top: 23%;
	}
	#psErr{
		top: 50%;
	}
	#emErr{
		top: 78%;
	}
	td{
		width: 50%;
	}
</style>