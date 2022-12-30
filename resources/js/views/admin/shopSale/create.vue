<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        <!-- <Input v-model='data.orderNo' field='data.orderNo' title='OrderNo' :req='true' />
				<date-picker id='date1' field='data.date' name='date'  v-model='data.date' title='Date' placeholder='Date' :req='true' col='2' ></date-picker> -->
        <Input v-model='data.customer_mobile' field='data.customer_mobile' title='Customer mobile' :req='true' />

        <div class="input-group">
          <div class="form-outline">
            <input type="search" id="form1" @keyup.enter="onPressEnter" v-model="data.productId" placeholder="scan or type product id" class="form-control" />
          </div>
          <button type="button" class="btn btn-primary" @click="onPressEnter">
            <i class="fas fa-search"></i>
          </button>
        </div>

        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">ProductId</th>
              <th scope="col">Name</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>

            <tr v-for="(item, index) in products" :key="index" style="background-color:aquamarine">
              <td scope="row">{{ index + 1 }}</td>
              <td>{{ item.id }}</td>
              <td>{{ item.title }}</td>
              <td>{{ item.shop_price }}</td>
              <td><input type="number" v-model="item.quantity" @keyup="calgrandTotal"></td>
              <td>{{ item.quantity * item.shop_price }}</td>
            </tr>
            <tr v-if="products.length > 0" style="background-color:blanchedalmond">
              <td colspan="5" align="right">Total: </td>
              <td>{{ grandTotal }}</td>
            </tr>
           
          </tbody>
        </table>


    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>


// define model name
const model = 'shopSale';

export default {
  
  data() {
    return {
      model: model,
      data: {
        productId: null
      },
      products: [],
      grandTotal : 0
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
          this.data.products = this.products
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id,);
          } else {
            this.store(this.model, this.data);
          }
        }
      });
    },


    onPressEnter() {
      var productId = this.data.productId;
      axios.post('get-product-by-id', {productId}).then(res => {
        this.products.unshift(res.data);

        this.data.productId = ''
        console.log(res);
      })
    },

    calgrandTotal(){
      this.grandTotal = this.products.reduce(function (previousValue = 0, currentValue = res.data) {
                  return previousValue + currentValue.quantity * currentValue.shop_price;
                }, 0);
    }
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
    // 'data.orderNo': function (value = null) { return Validator.value(value).required('OrderNo is required');},
		// 'data.date': function (value = null) { return Validator.value(value).required('Date is required');},

  },
}

</script>