<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        <Input v-model='data.amr_name_minhaz' field='data.amr_name_minhaz' title='Amr_name_minhaz' :req='true' />
				<Input v-model='data.arif_viaya_not_done' field='data.arif_viaya_not_done' title='Arif_viaya_not_done' :req='true' />

    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>


// define model name
const model = 'employee';

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
    'data.amr_name_minhaz': function (value = null) { return Validator.value(value).required('Amr_name_minhaz is required');},
		'data.arif_viaya_not_done': function (value = null) { return Validator.value(value).required('Arif_viaya_not_done is required');},

  },
}

</script>