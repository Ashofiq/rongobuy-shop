<template>
  <!-- content part start -->
  <div class="view-page">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-xl-3">
            <div v-for="(file, inx) in fileColumns" :key="inx">
              <span v-for="(value, key) in data" :key="key">
                <div class="left-info mt-2" v-if="checkTrue(file.field, key)">
                  <div class="file" v-if="file.field == key">
                    <img
                      :src="
                        value.includes('pdf')
                          ? $root.baseurl + '/images/pdf.png'
                          : value
                      "
                      alt="prf"
                      class="img-fluid w-100"
                      :style="
                        !value.includes('pdf')
                          ? ''
                          : 'height: 50px;width: 50px !important;overflow: hidden;display: block;margin-left: 80px;'
                      "
                    />
                    <a :href="value" download v-if="value.includes('pdf')"
                      ><i class="fa-solid fa-download"></i> Download
                    </a>
                  </div>
                </div>
              </span>
            </div>
          </div>
          <div
            :class="
              Array.isArray(fileColumns) && fileColumns.length > 0
                ? 'col-xl-9'
                : 'col-xl-12'
            "
          >
            <table class="table table-bordered">
              <tbody>
                <tr v-for="(item, name) in data" :key="'A' + name">
                  <slot v-if="!name.includes('image')">
                    <slot v-if="!name.includes('file')">
                      <th
                        class="text-capitalize"
                        v-if="typeof item == 'string'"
                      >
                        {{ name.replace(new RegExp("_", "g"), " ") }}
                      </th>
                      <th v-if="typeof item == 'string'">:</th>
                      <td v-if="typeof item == 'string'">
                        <span v-if="name == 'created_at'">
                          {{ $filter.enFormat(item) }}
                        </span>
                        <span v-else-if="name == 'updated_at'">
                          {{ $filter.enFormat(item) }}
                        </span>
                        <span v-else-if="name.includes('image')">
                          <!-- <img :src="item" width="100" /> -->
                          <!-- <a target="_blank" :href="item">Image Link</a> -->
                        </span>
                        <span v-else-if="name.includes('file')">
                          <!-- <iframe :src="item" width="700"></iframe> -->
                          <!-- <a target="_blank" :href="item">File Link</a> -->
                        </span>
                        <span v-else-if="name == 'date'">{{
                          $filter.enFormat(item)
                        }}</span>
                        <span v-else>{{ item }}</span>
                      </td>
                    </slot>
                  </slot>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- content part end -->
</template>

<script>
export default {
  props: ["data", "fileColumns"],
  methods: {
    checkTrue(field, index) {
      return field == index ? true : false;
    },
  },
};
</script>

<style>
</style>