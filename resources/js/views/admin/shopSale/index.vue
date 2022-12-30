<template>
  <index-page> </index-page>
</template>

<script>
// define model name
const model = "shopSale";

// define table coloumn show in datatable / datalist
const tableColumns = [{ field: "orderNo", title: "OrderNo"},
{ field: "customer_mobile", title: "Customer Mobile"},
{ field: "date", title: "Date"},];

//json fields for export excel
const json_fields = {
  "OrderNo": "orderNo","Date": "date",
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