<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        <Input v-model='data.title' field='data.title' title='Name' :req='true' />
				<Input v-model='data.description' field='data.description' title='Description' :req='true' />
        <Input v-model='data.shop_price' field='data.shop_price' title='Price' :req='true' />
        <Input v-model='data.rak' field='data.rak' title='Rak' />

    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>


// define model name
const model = 'shopProduct';

export default {
  
  data() {
    return {
      model: model,
      data: {},
      
    };
  },

  provide() {
    return {
      validate: this.validation,
      
    };
  },
  methods: {
    submit: function (e) {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        // If there is an error
        if (error > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            'You need to fill ' + error + ' more empty mandatory fields',
            'warning'
          );
          return false;
        }

        // If there is no error
        if (res) {
          
          
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id,);
          } else {
            this.store(this.model, this.data);
          }
        }
      });
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, 'edit');
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, 'create');
    }
  },

 // validation rule for form
  validators: {
    'data.title': function (value = null) { return Validator.value(value).required('Name is required');},
		'data.description': function (value = null) { return Validator.value(value).required('Description is required');},
		// 'data.brand': function (value = null) { return Validator.value(value).required('Brand is required');},

  },
}

</script>