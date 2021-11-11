<template>
	<div>
		<table border="0" v-show="showflg && !tempFlg">
        <tr>
			<td>メールアドレス</td>
            <td>
                <input type="text" v-model="emailaddress" @input="inputAddr">
            </td>
        </tr>
        </table>
		<span id="err">{{this.errMsg}}</span>
        <input type="button" id="submit" value="仮登録" v-show="showflg && !tempFlg" @click="tempRegister">
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
			errFlg: true,
			data: {}
		}
	},
	methods: {
		tempRegister(){
			if(this.errFlg){
				axios.post("../php/Hobby_1_3_DBPreRegister.php",{
					email: this.emailaddress,
				})
				.then(response => {
					console.log(response.data);
					this.data = response.data.data;
					this.showflg = response.data.data.flg;
					this.tempFlg = response.data.data.flg;
					this.msg = response.data.message;
				})
				.catch(function (error) {
					console.log(error);
				});
			}else{
				this.msg = this.errMsg;
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
	#err{
		position: absolute;
		top: 50%;
		left: 50%;
		color: #ea5532;
		font-size: 11.5px;
	}
	td{
		width: 50%;
	}
</style>