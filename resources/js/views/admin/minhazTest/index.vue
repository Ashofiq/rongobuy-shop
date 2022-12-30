<template>
  <index-page> </index-page>
</template>

<script>
// define model name
const model = "minhazTest";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "my_name", title: "My_name" },
  { field: "amr_sonar_bangla", title: "Amr_sonar_bangla" },
  { field: "amara_tour_a_jassi_minhaz", title: "Amara_tour_a_jassi_minhaz" },
];

//json fields for export excel
const json_fields = {
  My_name: "my_name",
  Amr_sonar_bangla: "amr_sonar_bangla",
  Amara_tour_a_jassi_minhaz: "amara_tour_a_jassi_minhaz",
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
      },
      table: {
        columns: tableColumns,
        routes: {},
        datas: [],
        meta: [],
        links: [],
      },
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