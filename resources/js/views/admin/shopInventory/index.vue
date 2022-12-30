<template>
  <index-page> </index-page>
</template>

<script>
// define model name
const model = "shopInventory";

// define table coloumn show in datatable / datalist
const tableColumns = [{ field: "product_id", subfield:"product.title", title: "Product_id"},
{ field: "quantity", title: "Quantity"},
{ field: "created_at", title: "Created at", align: "center", date: true },

];

//json fields for export excel
const json_fields = {
  "Product id": "product_id","Quantity": "quantity",
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
        value: ""
      },
      table: {
        columns: tableColumns,
        routes: {},
        datas: [],
        meta: [],
        links: []
      }
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
  },

  created() {
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index");
    this.search();
  },
};
</script>