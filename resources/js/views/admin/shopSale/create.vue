<template>
  <create-form>
    <div class='row align-items-center'>
        <!-- <Input v-model='data.orderNo' field='data.orderNo' title='OrderNo' :req='true' />
				<date-picker id='date1' field='data.date' name='date'  v-model='data.date' title='Date' placeholder='Date' :req='true' col='2' ></date-picker> -->
        <Input v-model='data.customer_name' field='data.customer_name' title='Customer Name' />
        <Input v-model='data.customer_mobile' field='data.customer_mobile' title='Customer mobile' />
        <Input v-model='data.customer_address' field='data.customer_address' title='Customer Address'/>

        <div class="input-group">
          <div class="form-outline">
            <input type="search" id="form1" v-model="data.productId" placeholder="scan or type product id" class="form-control" />
          </div>
          <!-- @keyup.enter="onPressEnter" -->
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
              <th>#</th>
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
                <i class="far fa-trash-alt text-dander" @click="deleteItem(index, item)"></i>
              </td>
            </tr>
            <tr v-if="data.products.length > 0" style="background-color:blanchedalmond">
              <td colspan="5" align="right">Total: </td>
              <td>{{  data.grandTotal ?? grandTotal }}</td>
              <td></td>
            </tr>
            
            <tr v-if="data.products.length > 0" style="background-color:blanchedalmond">
              <td colspan="5" align="right">Paid Amount: </td>
              <td><input type="text" v-on:keyup="changePaidvalue" v-model="data.paid_amount"></td>
              <td></td>
            </tr>

            <tr v-if="data.products.length > 0" style="background-color:blanchedalmond">
              <td colspan="5" align="right">Due: </td>
              <td>{{ (data.grandTotal ?? grandTotal) - data.paid_amount}}</td>
              <td></td>
            </tr>
          </tbody>
        </table>

        <!-- Receipt print -->
        <div class="ticket" id="printReceipt" style="display:none">
            <center><img :src="$root.baseurl+'/public/images/rb.png'" alt="Logo" width="230" height="45"></center>
            <p class="centered" style="font-size:70%">Address: Shop No 337/338 3rd Floor <br>
              Shezan Point Shopping Complex, 2 Indira Road, <br>
              Farmgate,, Dhaka 1215</p>
            <p class="centered">
              Tel: 01326886418
                <br><b>{{ orderNo }}</b>

            ****************************************<br>
            RECEIPT<br>
            ****************************************
            </p>
            
            <center>
            <table class="" style="width:300px">
                <thead>
                    <tr>
                        <th class="description" align="left">Description</th>
                        <th></th>
                        <th align="right" class="price">৳৳</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in data.products" :key="index">
                        <td class="description">{{ item.title }}</td>
                        <td></td>
                        <td class="price">৳{{ item.shop_price }}</td>
                    </tr>
                    <tr>
                        <td class="quantity">Total</td>
                        <td></td>
                        <td class="price">{{ data.grandTotal ?? grandTotal }}</td>
                    </tr>
                    <tr>
                        <td class="quantity">Paid</td>
                        <td></td>
                        <td class="price">{{ data.paid_amount }}</td>
                    </tr>

                    <tr>
                        <td class="quantity">Due</td>
                        <td></td>
                        <td class="price">{{ (data.grandTotal ?? grandTotal) - data.paid_amount }}</td>
                    </tr>
                </tbody>
            </table>
          </center>
          <center><img :src="$root.baseurl+'/public/images/barcode.gif'" alt="Logo" width="230" height="45"></center>

          <br>
            <p class="centered">Thanks You
                <br>Rongobuy</p>
        </div>
          

    </div>
    <!-- <Button title='Submit' @click="submit" process='' /> -->
    <button title='Submit & Print' class="btn btn-primary" 
    @click="submit" process=''>Submit & Print</button>

    <button @click="print">Print</button>
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
        productId: null,
        products: [],
        paid_amount: 0,
      },
      total: 0,
      grandTotal : 0 ,
      orderNo: '',
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
          this.data.grandTotal = this.grandTotal;
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id,);
          } else {
            axios.post(this.model, this.data).then(res => {
              console.log(res.data.data, res.data.data.order_no);
              this.orderNo = res.data.data.order_no
              setTimeout(this.print(), 1100);
            });
          }
        }
      });
    },

    onPressEnter() {
      var productId = this.data.productId;
      axios.post('get-product-by-id', {productId}).then(res => {
        this.data.products.unshift(res.data);

        this.data.productId = ''
        console.log(res);
      })
    },

    calgrandTotal(){
      this.grandTotal = this.data.products.reduce(function (previousValue = 0, currentValue = res.data) {
                  return previousValue + currentValue.quantity * currentValue.shop_price;
                }, 0);
    },

    changePaidvalue(){
      this.calTotal();
      this.getDue();
    },

    calTotal(){
      var total = this.data.products.length > 0 ? this.data.products.reduce((a, b) => a + (b.shop_price * b.quantity, 0)) : 0;
    },
    getDue(){
      return this.total - this.paid_amount
    },
    deleteItem(index, item) {
      var idx = this.data.products.indexOf(item);
      console.log(idx, index);
      if (idx > -1) {
        this.data.products.splice(idx, 1);
      }
      this.calgrandTotal()
    },
    print() {
            // $("#printReceipt").css("display", "block");

            const prtHtml = document.getElementById('printReceipt').innerHTML;
            let customStyle = '<style>table{border-collapse: collapse;}</style>'
            let stylesHtml = '';
            for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
                stylesHtml += node.outerHTML;
            }
            const WinPrint = window.open('', '', 'left=0,top=0,width=288,height=500,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write(`<!DOCTYPE html>
                <html>
                <head>
                <title>Receipt</title>
                ${stylesHtml}
                ${customStyle}
                </head>
                <body>
                    ${prtHtml}
                </body>
                </html>`);
            WinPrint.document.close();
            WinPrint.focus();
            setTimeout(() => WinPrint.print(), 300);
            // WinPrint.close();
        }
  },
  created() {
    if (this.$route.params.id) {

      this.setBreadcrumbs(this.model, 'edit');
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, 'create');
    }
    this.calTotal();
    this.calgrandTotal()
  },

 // validation rule for form
  validators: {
    // 'data.orderNo': function (value = null) { return Validator.value(value).required('OrderNo is required');},
		// 'data.date': function (value = null) { return Validator.value(value).required('Date is required');},

  },
}

</script>


<style scoped>
.ticket {
    font-size: 12px;
    font-family: 'Times New Roman';
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 75px;
    max-width: 75px;
}

td.quantity,
th.quantity {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.price,
th.price {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
</style>