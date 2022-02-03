<template>
	<div class="view-total" :style="variable">
        <table>
			<tr>
				<th colspan="2">合計HP</th>
			</tr>
            <tr>
                <td>回復なし</td>
				<td><input type="text" :value="this.totalHP" readonly></td>
            </tr>
            <tr>
				<td>回復込み</td>
                <td><input type="text" :value="this.totalHPre" readonly></td>
			</tr>
		</table>
		<table>
            <tr>
				<th colspan="2">各試験の予想トータルダメージ</th>
			</tr>
            <tr>
                <td class="natural">無属性の試験</td>
				<td><input class="natural" type="text" :value="this.natural" readonly></td>
            </tr>
            <tr>
                <td class="tree">木属性の試験</td>
                <td><input class="tree" type="text" :value="this.tree" readonly></td>
            </tr>
            <tr>
                <td class="water">水属性の試験</td>
                <td><input class="water" type="text" :value="this.water" readonly></td>
            </tr>
            <tr>
                <td class="fire">火属性の試験</td>
                <td><input class="fire" type="text" :value="this.fire" readonly></td>
            </tr>
		</table>
		<table>
            <tr>
                <th colspan="2">各試験の予想ダメージ(選択)</th>
            </tr>
            <tr>
                <td class="natural">無属性の試験</td>
                <td><input class="natural" type="text" :value="this.naturalChoice" readonly></td>
            </tr>
            <tr>
                <td class="tree">木属性の試験</td>
                <td><input class="tree" type="text" :value="this.treeChoice" readonly></td>
            </tr>
            <tr>
                <td class="water">水属性の試験</td>
                <td><input class="water" type="text" :value="this.waterChoice" readonly></td>
            </tr>
            <tr>
                <td class="fire">火属性の試験</td>
                <td><input class="fire" type="text" :value="this.fireChoice" readonly></td>
            </tr>
        </table>
    </div>
</template>

<script>
module.exports = {
	props: {
		media: {default: "PCH"},
	},
	computed: {
		variable() {
			switch(this.media.slice(0, -1)){
				case "PC":
					return {
						"--FS": "13px",
						"--W": "195px",
						"--H": "706px",
						"--Dis": "initial",
						"--FD": "column",
						"--tableBS": "initial",
						"--textW": "60px",
						"--textH": "18px",
					}
				case "TabletPC":
					return {
						"--FS": "18px",
						"--W": "100%",
						"--H": "170px",
						"--Dis": "inline-flex",
						"--FD": "row",
						"--tableBS": "initial",
						"--textW": "80px",
						"--textH": "25px",
					}
				case "SmartPhone":
					return {
						"--FS": "18px",
						"--W": "100%",
						"--H": "160px",
						"--Dis": "inline-flex",
						"--FD": "row",
						"--tableBS": "0",
						"--textW": "80px",
						"--textH": "22px",
					}
			}
		},
	},
	data: function () {
		return {
            damages: {
				card1: {m1: "", 1: 0, re1: 0, use1: false, m2: "", 2: 0, re1: 0, use2: false, hpbuf: 0},
				card2: {m1: "", 1: 0, re1: 0, use1: false, m2: "", 2: 0, re1: 0, use2: false, hpbuf: 0},
				card3: {m1: "", 1: 0, re1: 0, use1: false, m2: "", 2: 0, re1: 0, use2: false, hpbuf: 0},
				card4: {m1: "", 1: 0, re1: 0, use1: false, m2: "", 2: 0, re1: 0, use2: false, hpbuf: 0},
				card5: {m1: "", 1: 0, re1: 0, use1: false, m2: "", 2: 0, re1: 0, use2: false, hpbuf: 0},
			},
            totalHP: 0,
			totalHPre: 0,
			natural: 0,
			fire: 0,
			tree: 0,
			water: 0,
			naturalChoice: 0,
			fireChoice: 0,
			treeChoice: 0,
			waterChoice: 0,
		}
	},
	methods: {
        // 受け取ったデータを保存。表示できるやつは表示
		applyTotalDamage(card, m, masic, basicDamage, recovery, use, hpbuf){
			this.damages[card][m] = basicDamage;
			this.damages[card]["m"+m] = masic;
			this.damages[card]["use"+m] = use;
			this.damages[card]["re"+m] = recovery;
			this.damages[card]["hpbuf"] = hpbuf;
			// console.log("applyTotal:");
			// console.log(this.damages);
			this.calcTotalDamage();
			this.calcTotalHP();
		},
        calcTotalDamage(){
			this.natural = 0;
			this.fire = 0;
			this.tree = 0;
			this.water = 0;
			this.naturalChoice = 0;
			this.fireChoice = 0;
			this.treeChoice = 0;
			this.waterChoice = 0;
			var mag = {
				t: [1, 1.5, 1, 0.5],
				w: [1, 0.5, 1.5, 1],
				f: [1, 1, 0.5, 1.5],
			}
			for(var i = 1; i <= 5; i++){
				for(var j = 1; j <= 2; j++){
					var masic = this.damages["card"+i]["m"+j][0];
					if(isFinite(masic)){
						this.natural += parseInt(this.damages["card"+i][j]);
						this.tree += parseInt(parseInt(this.damages["card"+i][j]) * mag.t[masic]);
						this.water += parseInt(parseInt(this.damages["card"+i][j]) * mag.w[masic]);
						this.fire += parseInt(parseInt(this.damages["card"+i][j]) * mag.f[masic]);
						if(this.damages["card"+i]["use"+j]){
							this.naturalChoice += parseInt(this.damages["card"+i][j]);
							this.treeChoice += parseInt(parseInt(this.damages["card"+i][j]) * mag.t[masic]);
							this.waterChoice += parseInt(parseInt(this.damages["card"+i][j]) * mag.w[masic]);
							this.fireChoice += parseInt(parseInt(this.damages["card"+i][j]) * mag.f[masic]);
						}
					}
				}
			}
			
		},
		calcTotalHP(){
			this.totalHP = 0;
			this.totalHPre = 0;
			for(var i = 1; i <= 5; i++){
				// HPを加算
				this.totalHP += parseInt(this.damages["card"+i]["hpbuf"]);
				this.totalHPre += parseInt(this.damages["card"+i]["hpbuf"]);
				for(var j = 1; j <= 2; j++){
					if(this.damages["card"+i]["use"+j]){
						this.totalHPre += this.damages["card"+i]["re"+j];
					}
				}
			}
		}
	},
	
}
// export default { Node.jsじゃないから、これだとダメだった。 }
</script>

<style scoped>
	*{
        background: #2e2930;
		text-align: center;
		font-size: var(--FS);
		--natural: #a58f86;
		--fire: #ea5506;
		--tree: #c3d825;
		--water: #0094c8;
	}
	.view-total{
		box-sizing: border-box;
		width: var(--W);
		height: var(--H);
		display: var(--Dis);
		flex-direction: var(--FD);
	}
	table{
		border-spacing: var(--tableBS);
	}
	th{
		height: 40px;
		font-weight: 500;
	}
	td.natural{color: var(--natural);}
	td.fire{color: var(--fire);}
	td.tree{color: var(--tree);}
	td.water{color: var(--water);}
	input[type=text]{
		height: var(--textH);
		width: var(--textW);
		text-align: left;
		border: 1px solid #aaaaaa;
		border-radius: 2px;
	}
	input.natural{border-color: var(--natural);}
	input.fire{border-color: var(--fire);}
	input.tree{border-color: var(--tree);}
	input.water{border-color: var(--water);}
</style>