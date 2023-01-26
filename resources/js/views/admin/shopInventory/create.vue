<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        
          <v-select-container title="Product">
            <v-select
              v-model="data.product_id"
              label="title"
              :reduce="(obj) => obj.id"
              :options="data.products"
              placeholder="--Select One--"
              :closeOnSelect="true"
            ></v-select>
          </v-select-container>

          <v-select-container title="Varient">
            <v-select
              v-model="data.varient_id"
              label="title"
              :reduce="(obj) => obj.id"
              :options="data.varients"
              placeholder="--Select One--"
              :closeOnSelect="true"
              :req="true"
            ></v-select>
          </v-select-container>

				<Input v-model='data.quantity' field='data.quantity' title='Quantity' :req='true' />

    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>


// define model name
const model = 'shopInventory';

export default {
  
  data() {
    return {
      model: model,
      data: {products: [], varients: []},
      
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

    getProduct(){
      axios.get('all-products',{}).then(res => {
        this.data.products = res.data
      })
    },
    getVarient(){
      axios.get('all-varients',{}).then(res => {
        this.data.varients = res.data
      })
    }
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, 'edit');
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, 'create');
    }

    this.getProduct();
    this.getVarient();
  },

 // validation rule for form
  validators: {
    'data.product_id': function (value = null) { return Validator.value(value).required('Product id is required');},
		'data.quantity': function (value = null) { return Validator.value(value).required('Quantity is required');},
    'data.varient_id': function (value = null) { return Validator.value(value).required('Varient is required');},

  },
}

</script>