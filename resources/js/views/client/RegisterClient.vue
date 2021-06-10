<template>
  <!-- Main content -->
  <section class="content">
    <div class="row d-flex justify-content-center">
      <div class="col-md-6 col-sm-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Add Clients</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                data-toggle="tooltip"
                title="Collapse"
              >
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body"></div>
          <form @submit.prevent="setinfoClient()" class="px-3 orm">
            <div class="form-row">
              <div class="form-group col-sm-12">
                <label for="name">Name</label>
                <input
                  type="text"
                  id="name"
                  class="form-control"
                  value="Sergio"
                  name="name"
                  v-model="formData.name"
                  v-validate="'required|min:4|max:20'"
                />
              </div>
              <div class="col-sm-12 form-group">
                <div
                  class="alert alert-danger w-100 d-flex shadow-sm"
                  role="alert"
                  v-if="submitted && errors.has('name')"
                >
                  {{ errors.first("name") }}
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-sm-12 mb-3">
                <label for="name">City</label>
                <select
                  class="custom-select form-control"
                  name="city"
                  v-model="formData.id_City"
                  v-validate="'required'"
                >
                  <option
                    v-for="index in 5"
                    :key="index"
                    :v-model="formData.id_City"
                    :value="index"
                  >
                    {{ index }}
                  </option>
                </select>
              </div>
              <div class="input-group col-sm-12">
                <div
                  class="alert d-block w-100 shadow alert-danger"
                  role="alert"
                  v-if="submitted && errors.has('city')"
                >
                  {{ errors.first("city") }}
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-sm-12">
                <label for="name">Picture</label>
                <div class="custom-file">
                  <input
                    @change="onFileChange"
                    type="file"
                    name="image"
                    class="custom-file-input"
                    id="customFile"
                    v-validate="'required'"
                  />
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>

              <div class="input-group col-sm-12">
                <div
                  class="alert d-block w-100 shadow alert-danger"
                  role="alert"
                  v-if="submitted && errors.has('image')"
                >
                  {{ errors.first("image") }}
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div
                  class="alert"
                  v-if="submitted"
                  :class="successful ? 'alert-success' : 'alert-danger'"
                >
                  {{ message }}
                </div>
              </div>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      formData: { name: "", id_City: "" },
      image: "",
      imageName: "",
      message: "",
      submitted: false,
      successful: false,
    };
  },
  methods: {
    setinfoClient() {
      this.message = "";
      this.submitted = true;
      this.$validator.validate().then((isValid) => {
        if (isValid) {
          var formData = new FormData();

          formData.append("url", this.image);
          formData.append("id_City", this.formData.id_City);
          formData.append("name", this.formData.name);
          axios
            .post("api/clients", formData)
            .then((response) => {
              this.successful = true;
              this.message = response.data.message;
              console.log(this.message);
            })
            .catch((error) => {
              this.error = error;
              this.submitted = false;
              console.log(error);
            });
        }
      });
    },
    onFileChange(e) {
      this.imageName = "Selected File: " + e.target.files[0].name;
      this.image = e.target.files[0];
      console.log(this.image);
    },
  },
};
</script>

<style></style>
