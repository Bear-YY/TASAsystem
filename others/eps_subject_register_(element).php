<h2>科目登録画面</h2>
<div id="app0">
	<p>{{form.items}}</p>
	<el-container>
		<el-main>
			<el-form ref="form" :model="form" label-width="120px">
				<el-form-item label="科目名" >
					<el-input placeholder="例:プログラミング基礎Ⅰ" v-model="form.subject" clearable></el-input>
					</el-form-item>
					<el-form-item label="学部">
						<el-select v-model="form.value1" placeholder="学部選択">
					    <el-option
					      v-for="item in form.options1"
					      :key="item.value1"
					      :label="item.label"
					      :value="item.value1">
					    </el-option>
					 </el-select>
					</el-form-item>
				<el-form-item label="単位数">
					<el-input placeholder="例:２" v-model="form.nou" clearable width="10px"></el-input>
					</el-form-item>
					<el-form-item label="学年">
						<div class="radio-box">
							<el-radio v-model="form.radio" label="1">1年生</el-radio>
							<el-radio v-model="form.radio" label="2">2年生</el-radio>
							<el-radio v-model="form.radio" label="3">3年生</el-radio>
							<el-radio v-model="form.radio" label="4">4年生</el-radio>
						</div>
					</el-form-item>
					<el-form-item label="科目区分">
						<el-select v-model="form.value2" placeholder="科目区分選択">
					    <el-option
					      v-for="item in form.options2"
					      :key="item.value2"
					      :label="item.label"
					      :value="item.value2">
					    </el-option>
					</el-select>
					</el-form-item>
					<el-form-item>
				    <el-button href="Location:?do=eps_subject_get" type="primary" @click="onSubmit">Submit</el-button>
				    <el-button @click="onReset">Reset</el-button>
				</el-form-item>
			</el-form>
		</el-main>
	</el-container>
</div>

<script src="js/admin.js"></script>

<style> 
.el-main {
  background-color: #ffffff;
  color: #333;
  text-align: center;
  line-height: 160px;
  border-radius: 20px;
  padding: 80px;
  margin: 2px;
}

.el-select, .radio-box{
	position: absolute;
	left: 0px;
}

.el-container {
  border-radius: 20px;
  background-color: #4169e1;
}

</style>
<?php
