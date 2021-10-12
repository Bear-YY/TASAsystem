new Vue({
    el: "#app0000",
    data(){
        return {
        	form: {
            subject: '1',
            nou: '1',
            items: '',


            options1: [{
	          value1: '1',
	          label: '理工学部'
	        }, {
	          value1: '2',
	          label: '芸術学部'
	        }, {
	          value1: '3',
	          label: '経済学部'
	        }, {
	          value1: '4',
	          label: '人間科学部'
	        }, {
	          value1: '5',
	          label: 'などなど学部'
	        }],
	        value1: '',


	        options2: [{
	          value2: '1',
	          label: '必修科目'
	        }, {
	          value2: '2',
	          label: '選択必修'
	        }, {
	          value2: '3',
	          label: '教養科目'
	        }, {
	          value2: '4',
	          label: '導入科目'
	        }, {
	          value2: '5',
	          label: 'などなど学部'
	        }],
	        value2: '',
	        radio: '1'
	    }
        }
    },
    methods: {
    		onReset() {
    			console.log(this.form);
      			var self = this;
      			axios
      				.get('myfile.json')
      					.then(function (res){
      					self.form.items = res.data; //デバック用のやつ
      			});
      		},
      		onSubmit() {
      			var self = this.form;
      			var params = new URLSearchParams();
      			params.append('subject',this.form.subject);
      			params.append('nou',this.form.nou);
      			params.append('dou',this.form.value1);
      			params.append('grade',this.form.radio);
      			params.append('subclass',this.form.value2);
      			

      			axios.post('?do=eps_subject',params)
      			.then(function (response) {
      			   	console.log(response.data)
      				//location.href='?do=eps_subject';
      			})
      			.catch(function (error){
      				console.log(error)
      			})
      		}

    }
})
