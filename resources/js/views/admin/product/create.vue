<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        <Input v-model='data.name' field='data.name' title='Name' :req='true' />
				<date-picker id='date1' field='data.added_date' name='added_date'  v-model='data.added_date' title='Added_date' placeholder='Added_date' :req='true' col='2' ></date-picker>

    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>


// define model name
const model = 'product';

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
    'data.name': function (value = null) { return Validator.value(value).required('Name is required');},
		'data.added_date': function (value = null) { return Validator.value(value).required('Added date is required');},

  },
}

</script>