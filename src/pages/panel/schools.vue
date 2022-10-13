<template>
    <div class="grid">
      <div id="right" class="md:col-2 sm:col-12 xs:col-12">
        <div class="card p-fluid">
          <div class="grid formgrid">
            <div class="col-12 md:col-12" style="height:335px">
              <div
                class="flex-1 justify-content-center text-center md:text-center" 
              >
                <div class="font-bold text-2xl py-3">المراحل المدرسية:</div>
              </div>
  
              <Listbox
                v-model="level.id"
                :options="levels"
                optionLabel="name"
               
              >
                <template #option="slotProps">
                  <div
                    class="flex-1 justify-content-right text-right md:text-right px-20"
                  >
                    <div class="font-bold text-lg">
                      <i class="pi pi-circle-fill px-4"></i
                      ><span>{{ slotProps.option.name }}</span>
                    </div>
                  </div>
                </template>
              </Listbox>
            </div>
  
            <div class="col-12 md:col-12">
              <div
                class="flex-1 justify-content-center text-center md:text-center"
              >
                <div class="font-bold text-2xl pt-4 pb-4">الاضافات السريعة:</div>
  
                <Button label="اضافة غياب" class="p-button-outlined mb-4" />
                <Button label="اضافة تاخير" class="p-button-outlined mb-4" />
                <Button
                  label="اضافة مخالفة سلوكية"
                  class="p-button-outlined mb-4"
                />
                <Button label="اضافة استئذان" class="p-button-outlined mb-4" />
                <Button label="اضافة تسليم كتب" class="p-button-outlined mb-4" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="left" class="md:col-10 sm:col-12 xs:col-12">
        <div class="card p-fluid">
          <dev>
            <div class="grid formgrid">
              <div
                v-for="index in 16"
                class="md:col-2 mb-15 sm:col-4 xs:col-6 lg:mb-8"
              >
                <Card>
                  <template #header>
                    <div class="flex align-items-center justify-content-between">
                      <div class="flex align-items-center">
                        <span class="font-semibold mr-2">{{ index }}</span>
                      </div>
                    </div>
                  </template>
                  <template #content>
                    <div
                      class="flex-1 justify-content-center text-center md:text-center"
                    >
                      <img src="images/1.png" width="150" class="shadow-2 mb-3" />
  
                      <div class="font-bold text-lg">
                        <span>الصف الاول الثانوي</span>
                      </div>
                    </div>
                  </template>
                  <template #footer> </template>
                </Card>
              </div>
            </div>
          </dev>
  
          <Dialog
            v-model:visible="classDialog"
            :style="{ width: '500px' }"
            header="اضافة صف جديد"
            :modal="true"
            class="p-fluid font-bold text-lg"
          >
            <div class="field">
              <label for="levels" class="mb-3">المرحلة الدراسية</label>
              <Dropdown
                id="levels"
                v-model="product.level"
                :options="levels"
                optionLabel="label"
                placeholder="اختر المرحلة الدراسية"
              >
                <template #value="slotProps">
                  <div v-if="slotProps.value && slotProps.value.value">
                    <span
                      :class="'product-badge status-' + slotProps.value.value"
                      >{{ slotProps.value.label }}</span
                    >
                  </div>
                  <div v-else-if="slotProps.value && !slotProps.value.value">
                    <span
                      :class="
                        'product-badge status-' + slotProps.value.toLowerCase()
                      "
                      >{{ slotProps.value }}</span
                    >
                  </div>
                  <span v-else>
                    {{ slotProps.placeholder }}
                  </span>
                </template>
              </Dropdown>
            </div>
            <div class="field">
              <label for="name">شعبة الصف</label>
              <InputText
                id="name"
                v-model.trim="product.name"
                required="true"
                autofocus
                :class="{ 'p-invalid': submitted && !product.name }"
              />
              <small class="p-invalid" v-if="submitted && !product.name"
                >Name is required.</small
              >
            </div>
            <div class="field">
              <label for="description">الملف المرفق</label>
              <div class="inputfile-box">
                <input
                  type="file"
                  id="file"
                  class="inputfile"
                  @change="uploadFile"
                />
                <label for="file">
                  <span class="p-input-icon-left">
                    <i class="pi pi-upload" aria-hidden="true"></i>
                    <span id="file-name" class="file-box">{{this.filename}}</span>
                  </span>
                </label>
              </div>
  
              <!-- <FileUpload
                              
                              :multiple="false"
                              :custom-upload="true"
                              name="demo[]" 
                              url="./upload.php" 
                              accept=".pdf" 
                              :maxFileSize="1000000" 
                              @upload="onUpload" 
                              :show-cancel-button="false"
                              :show-upload-button="false"
                              :choose-icon="pi-upload"
                             
                              /> -->
            </div>
  
            <div class="field">
              <Button label="حفظ" class="mt-5" @click="saveProduct" />
            </div>
          </Dialog>
  
          <Dialog
            id="successMsg"
            v-model:visible="successMsg"
            :style="{ width: '450px' }"
            header=""
            :modal="true"
            class="font-bold text-3xl"
          >
            <div>
              <div class="justify-content-center text-center md:text-center">
                <i class="pi pi-check-circle" style="font-size: 5rem"></i>
              </div>
  
              <div class="justify-content-center text-center md:text-center">
                <span>تمت إضافة الصف بنجاح </span>
              </div>
            </div>
          </Dialog>
        </div>
  
        <div class="layout-add">
          <Button
            label="اضافة"
            icon="pi pi-plus"
            class="layout-add-button text-center"
            @click="openNew"
          />
        </div>
      </div>
    </div>
  </template>
  <script>
  import GradesService from "@/services/schoolsService";
  import GradesService from "@/services/gradesService";
      
  export default {
    data() {
          return {
              service: null,
              query:null,
        classes: null,
        classDialog: false,
        successMsg: false,
        deleteProductsDialog: false,
      //   product: {},
      //   selectedProducts: null,
      //   filters: {},
      //   submitted: false,
              levels: [],
              level: {},
              filename: null,
      };
    },
      created() {
          this.service = new GradesService();
      },
      mounted() { 
          this.loadData();
      },
      methods: {
          loadData(query = null) { 
             
        if (query) {
          this.query = Object.assign(this.query, query);
        }
        this.service.index(this.query).then(({data}) => {
            this.levels = data;  
          console.log(this.levels);   
        })
          },
      formatCurrency(value) {
        if (value)
          return value.toLocaleString("en-US", {
            style: "currency",
            currency: "USD",
          });
        return;
      },
      openNew() {
        this.product = {};
        this.submitted = false;
        this.classDialog = true;
      },
      hideDialog() {
        this.classDialog = false;
        this.submitted = false;
      },
      saveProduct() {
        this.classDialog = false;
        this.submitted = false;
        this.successMsg = true;
  
        // this.submitted = true;
        // if (this.product.name.trim()) {
        // if (this.product.id) {
        // 	this.product.levels = this.product.levels.value ? this.product.levels.value: this.product.levels;
        // 	this.products[this.findIndexById(this.product.id)] = this.product;
        // 	this.$toast.add({severity:'success', summary: 'Successful', detail: 'Product Updated', life: 3000});
        // 	}
        // 	else {
        // 		this.product.id = this.createId();
        // 		this.product.code = this.createId();
        // 		this.product.image = 'product-placeholder.svg';
        // 		this.product.levels = this.product.levels ? this.product.levels.value : 'INSTOCK';
        // 		this.products.push(this.product);
        // 		this.$toast.add({severity:'success', summary: 'Successful', detail: 'Product Created', life: 3000});
        // 	}
        // 	this.productDialog = false;
        // 	this.product = {};
        // }
        },
  
        uploadFile(e) {
          console.log(e.target.files);
      //   this.filename=e.files[0].name;
        this.filename=e.target.files[0].name;
   
        },
  
  
      editProduct(product) {
        this.product = { ...product };
        this.productDialog = true;
      },
      confirmDeleteProduct(product) {
        this.product = product;
        this.deleteProductDialog = true;
      },
      deleteProduct() {
        this.products = this.products.filter((val) => val.id !== this.product.id);
        this.deleteProductDialog = false;
        this.product = {};
        this.$toast.add({
          severity: "success",
          summary: "Successful",
          detail: "Product Deleted",
          life: 3000,
        });
      },
      findIndexById(id) {
        let index = -1;
        for (let i = 0; i < this.products.length; i++) {
          if (this.products[i].id === id) {
            index = i;
            break;
          }
        }
        return index;
      },
      exportCSV() {
        this.$refs.dt.exportCSV();
      },
      confirmDeleteSelected() {
        this.deleteProductsDialog = true;
      },
      deleteSelectedProducts() {
        this.products = this.products.filter(
          (val) => !this.selectedProducts.includes(val)
        );
        this.deleteProductsDialog = false;
        this.selectedProducts = null;
        this.$toast.add({
          severity: "success",
          summary: "Successful",
          detail: "Products Deleted",
          life: 3000,
        });
      },
      initFilters() {
        this.filters = {
          global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        };
      },
    },
  };
  </script>
  
  <style lang="scss" scoped>
  .inputfile-box {
    position: relative;
  }
  
  .inputfile {
    display: none;
  }
  
  .container {
    display: inline-block;
    width: 100%;
  }
  
  .file-box {
    display: inline-block;
    width: 100%;
    border: 1px solid;
    padding: 5px 0px 5px 5px;
    box-sizing: border-box;
    height: calc(3.9rem - 2px);
    font-family: Cairo, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
      Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
      "Segoe UI Symbol";
    font-size: 1rem;
    color: #495057;
    background: #ffffff;
    padding: 0.75rem 0.75rem;
    border: 1px solid #ced4da;
    transition: background-color 0.2s, color 0.2s, border-color 0.2s,
      box-shadow 0.2s;
    appearance: none;
    border-radius: 6px;
  }
  
  .file-button {
    background: red;
    padding: 5px;
    position: absolute;
    border: 1px solid;
    top: 0px;
    left: 0px;
  }
  ::v-deep(.custom-scrolltop) {
    width: 2rem;
    height: 2rem;
    border-radius: 4px;
    background-color: var(--primary-color);
  
    &:hover {
      background-color: var(--primary-color);
    }
  
    .p-scrolltop-icon {
      font-size: 1rem;
      color: var(--primary-color-text);
    }
  }
  
  ul.p-listbox-list {
    list-style-type: disc !important;
  }
  #right .p-fluid .p-button {
    width: 70%;
    //   display: flex;
  }
  
  #right {
    right: 0;
    position: fixed;
    padding-right: 0%;
    padding-left: 0%;
    //    z-index: 1;
  }
  #left {
    left: 0;
    position: absolute;
  }
  
  #left .card {
    padding: 50px;
  }
  
  #left .p-card {
    box-shadow: none;
    border: 1px solid #b9afaf;
    margin-left: 15px;
    margin-right: 15px;
  }
  #left .card .col-12 {
    padding: 20px;
  }
  // .layout-add {
  //     position: fixed;
  //     top: 0;
  //     padding: 0;
  //     right: 0;
  //     width: 20rem;
  //     z-index: 999;
  //     height: 100vh;
  //     transform: translateX(100%);
  //     transition: transform 0.2s;
  //     backface-visibility: hidden;
  //     box-shadow: 0px 3px 5px rgb(0 0 0 / 2%), 0px 0px 2px rgb(0 0 0 / 5%), 0px 1px 4px rgb(0 0 0 / 8%) !important;
  //     color: var(--text-color);
  //     background-color: var(--surface-overlay);
  //     border-top-left-radius: 12px;
  //     border-bottom-left-radius: 12px;
  // }
  
  .layout-add {
    position: fixed;
    top: 0;
    padding: 0;
    left: 0;
    width: 9rem;
    transform: translateX(100%);
  }
  .layout-add .layout-add-button {
    display: block;
    position: absolute;
    // width: 52px;
    // height: 52px;
    line-height: 52px;
    background-color: var(--primary-color);
    color: var(--primary-color-text);
    text-align: center;
    top: 830px;
    left: -52px;
    z-index: -1;
    overflow: hidden;
    cursor: pointer;
    border-radius: 100px;
    // border-top-left-radius: 12px;
    // border-bottom-left-radius: 12px;
    // transition: background-color 0.2s;
  }
  
  .p-dialog #successMsg .p-dialog-content {
    padding: 0 1.5rem 5rem 1.5rem;
  }
  </style>
  