<template>
  <index-page> </index-page>
</template>

<script>
// define model name
const model = "employee";

// define table coloumn show in datatable / datalist
const tableColumns = [{ field: "amr_name_minhaz", title: "Amr_name_minhaz"},{ field: "arif_viaya_not_done", title: "Arif_viaya_not_done"},];

//json fields for export excel
const json_fields = {
  "Amr name minhaz": "amr_name_minhaz","Arif viaya not done": "arif_viaya_not_done",
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