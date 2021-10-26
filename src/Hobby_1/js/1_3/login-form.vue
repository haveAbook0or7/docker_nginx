<template>
	<div>
		<meta v-if="reFlg" http-equiv="refresh" content=" 0; url=Hobby_1_1_home.php">
		<table border="0">
        <tr>
			<td>ID(英数字)</td>
            <td>
                <input type="text" v-model="username">
            </td>
        </tr>
        <tr>
            <td>パスワード(英数字6～8桁)</td>
            <td>
                <input type="password" v-model="password">
            </td>
        </tr>
        </table>
        <input type="button" id="submit" value="ログイン" @click="loginCheck">
	</div>
</template>

<script>
module.exports = {
	data: function () {
		return {
			username: "",
			password: "",
			reFlg: false,
			data: {}
		}
	},
	methods: {
		loginCheck(){
			axios.post("../php/Hobby_1_3_DBLogin.php",{
				user: this.username,
				pass: this.password
			})
			.then(response => {
				this.data = response.data.data;
				if(this.data.flg){
					this.reFlg = true;
				}
			})
			.catch(function (error) {
				console.log(error);
			});
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
	}
    div{
		display: inline-flex;
        position: relative;
		background: #2e2930;
		border: 5px double #e6b422;
        height: 200px;
        width: 500px;
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
</style>