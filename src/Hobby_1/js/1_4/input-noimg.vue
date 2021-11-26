<template>
	<div>
        <file-select class="imgfile" @change="getFile"></file-select>
        <span class="no">
            <label class="text">カードNo<input type="text" maxlength="4" v-model="cdno" @change="sendData"></label>
            <img-select @select="getChno"></img-select>
        </span>
    </div>
</template>

<script>
module.exports = {
	components: {
        'file-select': httpVueLoader('./file-select.vue'),
        'img-select': httpVueLoader('./img-select.vue')
    },
	props: {
	},
    computed: {
		
	},
	data: function () {
		return {
			img: null,
            imgname: null,
            cdno: null,
            chno: null,
		}
	},
	methods: {
        getFile(filejpeg, filename){
            this.img = filejpeg;
            this.imgname = filename;
            // console.log(this.img)
            // console.log(this.imgname+" "+this.cdno+" "+this.chno);
			this.sendData();
        },
		getChno(value){
			this.chno = value;
			// console.log(this.img)
            // console.log(this.imgname+" "+this.cdno+" "+this.chno);
			this.sendData();
		},
		sendData(){
			this.$emit('change', this.img, this.imgname, this.cdno, this.chno);
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
	div{
		text-align: left;
		display: flex;
		justify-content: space-between;
	}
	.no{
		display: flex;
		justify-content: flex-end;
		align-items: flex-end;
	}
	.text{
		margin-bottom: 15px;
	}
    input[type=text]:read-write{
		height: 18px;
		width: 30px;
		text-align: right;
		color: #2e2930;
		background: #fbfaf5;
		border: 1.5px solid #e6b422;
		border-radius: 2px;
        caret-color: #2e2930;
	}
</style>