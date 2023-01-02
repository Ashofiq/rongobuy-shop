<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
      <div class="input-group">
          <div class="form-outline">
            <input type="search" id="form1" v-model="data.orderNo" placeholder="Order No" class="form-control" />
          </div>
          <button type="button" class="btn btn-primary" @click="getOrder">
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

            <tr v-for="(item, index) in data.products" :key="index" style="background-color:aquamarine">
              <td scope="row">{{ index + 1 }}</td>
              <td>{{ item.id }}</td>
              <td>{{ item.title }}</td>
              <td>{{ item.shop_price }}</td>
              <td><input type="number" v-model="item.quantity" @keyup="calgrandTotal"></td>
              <td>{{ item.quantity * item.shop_price }}</td>
              <td>
                <i class="far fa-trash-alt" @click="deleteItem(index, item)"></i>
              </td>
            </tr>
            <tr v-if="data.products.length > 0" style="background-color:blanchedalmond">
              <td colspan="5" align="right">Total: </td>
              <td colspan="2">{{ grandTotal }}</td>
            </tr>
           
          </tbody>
        </table>

    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>


// define model name
const model = 'shopReturn';

export default {
  
  data() {
    return {
      model: model,
      data: {
        products: [],
        orderNo: null
      },
      grandTotal: 0
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

    getOrder() {
      var orderNo = this.data.orderNo;
      axios.post('get-order-by-orderno', {orderNo}).then(res => {
        this.data.products = res.data.products 
        
        var sum = 0;
        for (let index = 0; index < this.data.products.length; index++) {
          const element = this.data.products[index];
          console.log(element);
          sum += element.shop_price * element.quantity;
        }
        this.grandTotal = sum
      })

      this.calgrandTotal()
    },

    calgrandTotal(){
      
      // let sum = this.data.products.reduce(function (previousValue, currentValue) {
      //     return previousValue + (currentValue.quantity * currentValue.shop_price);
      // });
      var sum = 0;
      for (let index = 0; index < this.data.products.length; index++) {
        const element = this.data.products[index];
        console.log(element);
        sum += element.shop_price * element.quantity;
      }
      this.grandTotal = sum
    },

    deleteItem(index, item) {
      var idx = this.data.products.indexOf(item);
      console.log(idx, index);
      if (idx > -1) {
        this.data.products.splice(idx, 1);
      }
      this.calgrandTotal()
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
    // 'data.shop_sale_id': function (value = null) { return Validator.value(value).required('Shop sale id is required');},
		
  },
}

</script>