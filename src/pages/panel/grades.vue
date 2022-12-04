<template>
  <div class="grid">
    <template v-if="!this.error" >
        <div id="right" class="md:col-2 sm:col-12 xs:col-12 lg:col-2 " >
      <div class="card p-fluid"  style="height: 87vh;">
        <div class="grid formgrid  re_quick" >

          <div class="col-12 md:col-12 lg:col-12 "   >
            <div class="flex-1 justify-content-center text-center md:text-center" >
              <div class="font-bold text-2xl py-3" style="cursor: pointer" @click="filterClasses">المراحل المدرسية:</div>
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
       

          <!-- <div class="col-12 md:col-12 " style="height:50vh"  > -->
            <div class="font-bold  justify-content-center text-center md:text-center text-2xl pt-4 pb-4">الاضافات السريعة:</div>
            <div class="flex-1 justify-content-center text-center md:text-center ">

              <Button v-if="this.can('ABSENCE_ADD_EDIT')" label="اضافة غياب"  class="p-button-outlined mb-4" @click="this.$router.push({ name: 'quick-index', params: { type: 1 } })"/>
              <Button  v-if="this.can('DELAY_ADD_EDIT')" label="اضافة تاخير" class="p-button-outlined mb-4"  @click="this.$router.push({ name: 'quick-index', params: { type: 2 } })"/>
              <Button v-if="this.can('VIOLATION_ADD_EDIT')" label="اضافة مخالفة سلوكية" class="p-button-outlined mb-4" @click="this.$router.push({ name: 'quick-index', params: { type: 3 } })"/>
              <Button v-if="this.can('LEAVE_ADD_EDIT')" label="اضافة استئذان" class="p-button-outlined mb-4" @click="this.$router.push({ name: 'quick-index', params: { type: 4 } })"/>
              <Button v-if="this.can('BOOK_ADD_EDIT')" label="اضافة تسليم كتب" class="p-button-outlined mb-8" @click="this.$router.push({ name: 'quick-index', params: { type: 5 } })"/>
            </div>
          <!-- </div> -->
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
              
                <Card >
                <template #header>
                  <div class="flex mt-2 lign-items-center justify-content-between">
                    <div class="flex align-items-center">
                      <span class="font-semibold mr-2">{{ (index+1) }}</span>
                    </div>
                    <div v-if="this.can('CLASS_DELETE')" class="flex align-items-left">
                      <span  style="cursor: pointer" class="font-semibold ml-2" @click="openDelete(_class)" ><i class="pi pi-times"></i></span>
                    </div>
                  </div>
                </template>
                <template #content>
                  <div
                    class="flex-1 justify-content-center text-center md:text-center"
                    style="cursor: pointer" @click="this.$router.push({ name: 'class-all', params: { id: _class.id } })"
                  >
                    <img src="/images/1.jpg" class="shadow-2 mb-3 res_image" />

                    <div class="font-bold text-lg">
                      <span>{{_class.name}}-{{_class.level_name}}</span>
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
          class="p-fluid font-bold text-lg">
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
              :class="{ 'p-error':v$.form.level_id.$invalid && submitted }"
            >
            </Dropdown>

            <small class="p-error" v-if="v$.form.level_id.$invalid && submitted">يرجى اختبار المرحلة المدرسية  </small>

          </div>
          <div class="field">
            <label for="name">شعبة الصف</label>
            <InputText
              id="name"
              v-model.trim="form.name"
              required="true"
              autofocus
              :class="{ 'p-error':v$.form.name.$invalid && submitted }"
            />
            <small class="p-error" v-if="v$.form.name.$invalid && submitted">يرجى ادخال اسم الصف</small>
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

              <!-- <small class="p-error" v-if="v$.form.attached_file.$invalid && submitted">يرجى ارفاق ملف    </small> -->

            </div>
                 
          </div>

          <div class="field">
            <Button label="حفظ" class="mt-5" type="submit" @click="saveClass(!v$.$invalid)"  />
          </div>
        </Dialog>
        <SuccessMsg :successMsg=successMsg  :Msg=Msg />

      </div>

      <div class="layout-add">
        <Button
        v-if="this.can('CLASS_ADD')"
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

        <Dialog
      id="deleteconfirm"
      v-model:visible="deleteconfirm"
      :style="{ width: '450px' }"
      header=""
      :modal="true"
      class="font-bold text-3xl"
    >
      <div>
        <div class="justify-content-center text-center md:text-center">
          <i class="pi pi-times-circle" style="font-size: 5rem; color:red"></i>
        </div>
  
        <div class="justify-content-center text-center md:text-center">
          <span> {{deleteMsg}} </span>
        </div>
      </div>

      <template #footer>
        <div class="grid p-fluid">
            <div class="col-6 md:col-6">  
                 <Button label="حذف"  class=" p-button-outlined mt-5"   @click="deleteClass" />
            </div>
            <div class="col-6 md:col-6">            
                 <Button label="الغاء"  class="p-button-outlined mt-5" @click="deleteconfirm = false"  />
            </div>
        </div>
            </template>

    </Dialog>

  </div>


</template>
<script>
import SchoolsService from "@/services/schoolsService";
import ClassesService from "@/services/classesService";
import { useVuelidate } from "@vuelidate/core";
import {required} from "@vuelidate/validators";

let service = null;
    
export default {
  setup () {
    return { v$: useVuelidate() }
  },
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
          submitted: false,
          attachment: null,
          classesService:null,
          currentUser: {},
          deleteconfirm: false,
          Msg:null
    };
  },
  validations() {
    return {
      form: {
        level_id: { required },
        name: { required },
        // attached_file: { required },
      }
    }
  },
    props:['id'],
    created() {
        this.service = new SchoolsService();
        this.classesService = new ClassesService();
    }, 
    mounted() { 
      this.error=false
      this.currentUser = this.$store.getters['settings/currentUser'];

      this.loadData();


    },
  methods:
  {
        loadData(query = null) { 
           
            if (query) {
                this.query = Object.assign(this.query, query);
            }
            this.service.index(this.query).then(({ data }) => {
                if (data.code == 200) {
                  this.levels = data.data.Levels;
                  this.classes =data.data.Classes;

                  if (this.currentUser.role_id == 3) {
                    this.classes = this.currentUser.classes;
                    this.levels= this.levels.filter(level => {
                       return this.currentUser.classes.map((el) => { return el.level_id }).includes(level.id)
                    });
                  }
                  // else {
                  //   this.classes =data.data.Classes;
                  // }
                }
                else { 
                      this.error=true; 
                }
               
            
            })
        },

        filterClasses() { 
          if (this.currentUser.role_id == 3) {
            if (this.selectedLevel) {
              this.classes = this.currentUser.classes;
             this.classes=this.classes.filter((_class) => { return _class.level_id == this.selectedLevel.id });
            }
            else {
              this.classes = this.currentUser.classes;
           } 
             this.selectedLevel=null
            } 
          else {
            if (this.selectedLevel) {
              this.query = { level_id: this.selectedLevel.id };
              this.Classes( );
            }
            else{
              this.Classes();
            }
            this.selectedLevel = null
            this.query={}
          }
          
                
        },

      Classes() {

        this.classesService.index(this.query).then(({ data }) => {
          this.classes = data.data.Classes;
        });
        },
            
 
      openNew() {
      // this.restform()
      this.submitted = false;
      this.classDialog = true;
        },

      saveClass(isFormValid) {
       
      this.submitted = true;
      if (!isFormValid) {
        return;
      }    
        const formData = new FormData()
        formData.append('file_name', this.attachment)
        formData.append('data', JSON.stringify(this.form))
        const config = { headers: { 'Content-Type': 'multipart/form-data' } }
  
         this.classesService.store(formData,config,this.id).then(({ data }) => {  
            
              this.Classes();
              this.classes.push(this.form);
              this.classDialog = false;
              this.submitted = false;
              this.successMsg = true;
              this.Msg = "تمت اضافة الصف بنجاح";
              this.restform()
               
            })
      },

      uploadFile(e) {
          this.form.attached_file = e.target.files[0].name;
           this.attachment=e.target.files[0]
 
      },

      restform() { 
        this.form={}

    },
      
      openDelete(data) { 
            this.form = data;
            this.deleteconfirm = true;
            this.deleteMsg = "هل انت متاكد من حذف الصف ";
        },

           deleteClass() { 
             this.successMsg = false;
             this.classesService.delete(this.form.id).then(({ data }) =>
              {
                  if (data.code == 200) {
                  this.deleteconfirm = false;
                  this.successMsg = true;
                    this.Msg = data.msg;
                    this.Classes();
                  //this.classes = this.classes.filter(val => val.id !== this.form.id);
              }
            });
            this.form = {};
        },


  },
};
</script>

<style lang="scss" scoped>

.re_quick{
  overflow: auto;
  height: 84vh;
}
.phone {
    height: auto;
   
    overflow: hidden;
    padding: 0;
    border-radius: 3%;
    border: 2px solid red;
}
 .res_image{
  max-width: 100%;
  height: 18vh;
 }
.inputfile-box {
  position: relative;
}

.inputfile {
  display: none;
}


.card {
  border-radius: 0%;
  padding: 0rem;
}

.card {
  border-radius: 0%;
  /*padding: 0rem;*/
}
.grid {
  margin-left: 0rem;
  margin-right: 0rem;
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
  // padding-left: 0%;
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
  top: 80vh;
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


.p-button:enabled:hover {
    background: #7C3AED;
    color: #ffffff;
    border-color: #7C3AED;
}
.p-dialog .p-dialog-footer button{
    width:100%
}

</style>
