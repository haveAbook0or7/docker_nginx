<template>
	<label>
		<img :src="preview" width="70.5" height="74.7">
		<input type="file" accept='image/*' @change="readImage">
		<span>{{ fileName }}</span>
    </label>
</template>

<script>
module.exports = {
	props: {
		init_img: {default:"../img/none.jpg"},
		init_name: {default:"未選択"}
	},
	data: function () {
		return {
			preview: this.init_img,
			fileName: this.init_name
		}
	},
	methods: {
		readImage(e) {
			console.log(e.target.files);
			if (e.target.files.length === 0) {
				return;
			}
			let file = e.target.files[0];
			new Promise((resolve, reject) => {
				const fileReader = new FileReader()
				fileReader.readAsDataURL(file)
				fileReader.onload = () => resolve(fileReader.result)
				fileReader.onerror = error => reject(error)
			})
			.then(res => {
				// プレビュー表示
				this.preview = res;
				//ファイル名表示
				this.fileName = e.target.files[0].name;
				this.$emit('change', this.preview, this.fileName);
			})
			.catch(error => {
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
		background: #2e2930;
		color: white;
	}
    label > input {
		display:none; 
    }
	img{
		margin: 5px;
	}
</style>