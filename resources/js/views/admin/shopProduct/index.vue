<template>
  <index-page>
    <template v-slot:search-field>
      <form method="get" :action="$root.baseurl + '/product-barcode'" target="_blank">
        <div class="row col-5 pl-1">
          <div class="col-lg-5">
            <div class="form-element">
              <select
              name="productId"
                class="form-select shadow-none"
              >
                <option
                  v-for="(item, index) in products"
                  :key="index"
                  v-bind:value="item.id"
                >
                  {{ item.title }}
                </option>
              </select>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-element">
              <input
                type="text"
                name="barcode_qty"
                class="form-control form-control-sm shadow-none"
                placeholder="Type your text"
              />
            </div>
          </div>
          <div class="col-lg-1">
            <button type="submit" class="search-btn">
              <div class="btn-front">
                Barcode
              </div>
              <div class="btn-back">
                Barcode
              </div>
            </button>
          </div>
        </div>
      </form>
      <!-- search  -->
      <div class="col-md-2">
        <div class="form-element">
          <select
            name="productId"
            class="form-select shadow-none"
            v-model="search_data.brand"
          >
            <option
              v-for="(brand, index) in brands"
              :key="index"
              v-bind:value="brand.id"
            >
              {{ brand.title }}
            </option>
          </select>
        </div>
      </div>

      <!-- <div class="col-md-2">
        <div class="form-element">
          <select
          name="productId"
            class="form-select shadow-none"
            v-model="search_data.varient"
          >
            <option
              v-for="(item, index) in varients"
              :key="index"
              v-bind:value="item.id"
            >
              {{ item.title }}
            </option>
          </select>
        </div>
      </div> -->

    </template>  
  </index-page>
</template>

<script>
// define model name
const model = "shopProduct";

// define table coloumn show in datatable / datalist
const tableColumns = [{ field: "product_title", title: "Name"},
{ field: "description", title: "Description"},
{ field: "rak", title: "Rak"},
{ field: "shop_price", title: "Price"},
{ field: "live_quantity", title: "Stock"},
{ field: "brand", subfield:"brand.title", title: "Brand"},];

//json fields for export excel
const json_fields = {
  "Name": "name","Description": "description","Brand": "brand",
};

export default {

  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: { 0: "Select One", title: "Title" },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
        varient: null,
        brand: null
      },
      table: {
        columns: tableColumns,
        routes: {},
        datas: [],
        meta: [],
        links: []
      },
      products: [],
      varients:[],
      brands: []

    };
  },

  // provide inject for child component
  provide() {
    return {
      model: this.model,
      fields_name: this.fields_name,
      search_data: this.search_data,
      table: this.table,
      json_fields: this.json_fields,
      search: this.search,
    };
  },

  methods: {
    search() {
      this.get_paginate(this.model, this.search_data);
    },

    getProduct(){
      axios.get('all-products',{}).then(res => {
        this.products = res.data
      })
    },

    getVarient(){
      axios.get('all-varients',{}).then(res => {
        this.varients = res.data
      })
    },

    getBrand(){
      axios.get('all-brand',{}).then(res => {
        
        this.brands = res.data
        console.log('brand', this.brands);
      })
    }

  },

  created() {
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index");
    this.search();
    this.getProduct();
    this.getVarient();
    this.getBrand();
  },
};
</script>