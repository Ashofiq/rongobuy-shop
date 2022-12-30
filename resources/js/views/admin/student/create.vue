<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        <Input v-model='data.name' field='data.name' title='Name' :req='true' />
				<File title='Image' field='data.image' mime='img' fileClassName='data.image' :req='true'/>
				<File title='File' field='data.file' mime='.pdf' fileClassName='data.file'  :req='true'/>

    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>


// define model name
const model = 'student';

export default {
  
  data() {
    return {
      model: model,
      data: {image:'',file:''},
      image:{}
    };
  },

  provide() {
    return {
      validate: this.validation,
      data: () => this.data, image: this.image
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
          var form = document.getElementById('form'); var formData = new FormData(form);
          
          if (this.data.id) {
            this.update(this.model, formData, this.data.id,true);
          } else {
            this.store(this.model, formData);
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
		'data.image': function (value = null) { return Validator.value(value).required('Image is required').custom(function () {
                if ( !value . type ) {
                    return false;
                }
                if (!Validator.isEmpty(value)) {
                var type = value.type;
                if (type == 'image/jpeg'||type == 'image/jpg'||type == 'image/png') {
                } else {
                    return 'Image must be of type .jpeg.jpg.png';
                }
                }
            }).custom(function () {

                if (!Validator.isEmpty(value)) {
                    var size = value.size;
                    if (size > 512000) {
                    return  "File must be smaller than 500kb";
                    }
                }
                });},
		'data.file': function (value = null) { return Validator.value(value).required('File is required').custom(function () {

                if (!Validator.isEmpty(value)) {
                    var size = value.size;
                    if (size > 512000) {
                    return  "File must be smaller than 500kb";
                    }
                }
                });},

  },
}

</script>