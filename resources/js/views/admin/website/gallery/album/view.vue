<template>
  <view-page :defaultTable="false">
      <div class="gallery-list">
        <div class="row">
          <div v-for="(item, index) in data" :key="index" class="col-sm-6 col-lg-4 col-xl-3">
            <div class="image">
              <img :src="item.thumb" >
              <div class="overlay">
                <div class="info">

                  <!-- <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" class="delete view"><i
                              class="fa-solid fa-eye"></i></span>
                          <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" class="delete edit"><i
                              class="fas fa-pencil-alt"></i></span>
                          <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"
                            class="delete delete-btn"><i class="far fa-trash-alt"></i></span> -->
                  <div>
                    <!-- <button class="manage-gallery btn btn-primary shadow-none mt-4">Manage Gallery</button> -->
                  </div>
                  <h4></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  </view-page>
</template>

<script>
// define model name
const model = "album";

export default {
  data() {
    return {
      model: model,
      data: {},
    };
  },
  created() {
    this.setBreadcrumbs(this.model, "view");
    this.get_data(`${this.model}/${this.$route.params.id}?view=1`);
  },
};
</script>