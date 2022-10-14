<template>
  <div class="grid">
    <template v-if="!this.error">
        <div id="right" class="md:col-2 sm:col-12 xs:col-12">
      <div class="card p-fluid">
        <div class="grid formgrid">

          <div class="col-12 md:col-12" style="height:350px">
            <div class="flex-1 justify-content-center text-center md:text-center" >
              <div class="font-bold text-2xl py-3" style="cursor: pointer" @click="Classes">المراحل المدرسية:</div>
            </div>
            <Listbox v-model="selectedLevel" :options="levels" optionLabel="name"  @change="filterClasses">
              <template #option="slotProps">
                <div class="flex-1 justify-content-right text-right md:text-right px-20">
                  <div class="font-bold text-lg">
                    <i class="pi pi-circle-fill px-4"></i>
                    <span>{{ slotProps.option.name }}</span>
                  </div>
                </div>
              </template>
            </Listbox>
          </div>

          <div class="col-12 md:col-12">
            <div class="flex-1 justify-content-center text-center md:text-center">
              <div class="font-bold text-2xl pt-4 pb-4">الاضافات السريعة:</div>
              <Button label="اضافة غياب" class="p-button-outlined mb-4" />
              <Button label="اضافة تاخير" class="p-button-outlined mb-4" />
              <Button label="اضافة مخالفة سلوكية" class="p-button-outlined mb-4" />
              <Button label="اضافة استئذان" class="p-button-outlined mb-4" />
              <Button label="اضافة تسليم كتب" class="p-button-outlined mb-8" />
            </div>
          </div>

        </div>
      </div>
    </div>

    <div id="left" class="md:col-10 sm:col-12 xs:col-12">
      <div class="card p-fluid">
          <div class="grid formgrid">
            <div
              v-for="(_class, index) in classes"
              class="md:col-3 mb-15 sm:col-4 xs:col-6 lg:mb-8">
              
                <Card style="cursor: pointer" @click="this.$router.push({ name: 'class-all', params: { id: _class.id } })">
                <template #header>
                  <div class="flex align-items-center justify-content-between">
                    <div class="flex align-items-center">
                      <span class="font-semibold mr-2">{{ (index+1) }}</span>
                    </div>
                  </div>
                </template>
                <template #content>
                  <div
                    class="flex-1 justify-content-center text-center md:text-center"
                  >
                    <img src="images/1.png" class="shadow-2 mb-3 res_image" />

                    <div class="font-bold text-lg">
                      <span>{{_class.name}}</span>
                    </div>
                  </div>
                </template>
                <template #footer> </template>
              </Card>
                           
             
            </div>
        </div>


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
             :filter=true
              id="levels"
              v-model="form.level_id"
              :options="levels"
              optionLabel="name"
              placeholder="اختر المرحلة الدراسية"
              option-value="id"
            >
            </Dropdown>
          </div>
          <div class="field">
            <label for="name">شعبة الصف</label>
            <InputText
              id="name"
              v-model.trim="form.name"
              required="true"
              autofocus
              :class="{ 'p-invalid': submitted && !form.name }"
            />
            <small class="p-invalid" v-if="submitted && !form.name"
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
                  <span id="file-name" class="file-box">{{form.attached_file}}</span>
                </span>
              </label>
            </div>
                 
          </div>

          <div class="field">
            <Button label="حفظ" class="mt-5" @click="saveClass" />
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
    </template>
    

        <template v-if="this.error">
            <div class="filed col">
            <div class="card p-fluid">

                <Message severity="error" 
                class="font-bold" > هناك خطأ في جلب البيانات
            </Message>
            </div>  </div>
        </template>
  </div>
</template>
<script>
import SchoolsService from "@/services/schoolsService";
import ClassesService from "@/services/classesService";

let service = null;
    
export default {
  data() {
        return {
            form: {
                level_id: null,
                name: null,
                attached_file:null,
                school_id:null
            },
            
            query:null,
             classes: null,
            _class:null,
            classDialog: false,
            successMsg: false,
            levels: [],
            selectedLevel: null,
            filename: null,
            error: false,
          attachment: null,
          classesService:null,
    };
    },
    props:['id'],
    created() {
        this.service = new SchoolsService();
        this.classesService = new ClassesService();
    },
    mounted() { 
      this.error=false
      this.loadData();
    
    },
    methods: {
        loadData(query = null) { 
           
            if (query) {
                this.query = Object.assign(this.query, query);
            }
            this.service.index(this.query).then(({ data }) => {
                if (data.code == 200) {
                    this.levels = data.data.Levels;
                    this.classes = data.data.Classes;
                }
                else { 
                      this.error=true; 
                }
               
            
            })
        },

        filterClasses() { 
            this.query = { level_id: this.selectedLevel.id };
          this.Classes() 
          this.query=null
                
        },

        Classes() {
            this.classesService.index(this.query).then(({ data }) => {  
                this.classes = data.data.Classes;
            })
        }, 
          
    openNew() {
      this.submitted = false;
      this.classDialog = true;
    },

    saveClass() {

        const formData = new FormData()
       
        formData.append('file_name', this.attachment)
        formData.append('data', JSON.stringify(this.form))
        const config = { headers: { 'Content-Type': 'multipart/form-data' } }
        
         this.submitted = true;
         this.classesService.store(formData,config,this.id).then(({ data }) => {  
            
               this.Classes() 
               this.classDialog = false;
                this.submitted = false;
                this.successMsg = true;
                this.restform()
               
            })
      },

      uploadFile(e) {
          this.form.attached_file = e.target.files[0].name;
           this.attachment=e.target.files[0]
 
      },

      restform() { 

                this.form.level_id=null,
                this.form.name= null,
                athis.form.ttached_file=null,
                this.form.school_id=null

      }
    // editClass(_class) {
    //   this._class = { ..._class };
    //   this.productDialog = true;
    // },
    // confirmDeleteProduct(_class) {
    //   this._class = _class;
    //   this.deleteProductDialog = true;
    // },


  },
};
</script>

<style lang="scss" scoped>
 .res_image{
  max-width: 100%;
  height: auto;
 }
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
.card {
  border-radius: 0%;
  padding: 0rem;
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
  top: 750px;
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
