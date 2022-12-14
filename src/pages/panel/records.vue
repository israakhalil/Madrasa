<template>
    <div class="grid list_container" style="height: 87vh; padding:0rem;">
      <div class="col-12 md:col-12 re_quick" >
        <div class="card  list_container2">
            <div class="grid p-fluid mt-3 font-bold mr-5  ">
                <div class="col-12 md:col-12 justify-content-right">
                    <span class="font-bold text-xl">السجلات المدرسية</span>
                </div>
            </div>

            <div class="grid p-fluid mt-3 font-bold mr-5">
            <div class="field col-12 md:col-2">
                <label for="date">التاريخ  </label>
                <Calendar id="date" :showIcon="true" v-model="date"></Calendar>
            </div>
            <div class="field col-12 md:col-2">
                <label for="level_id">المرحلة </label>
                <Dropdown
                id="level_id"
                v-model="filter.level_id"
                :options="levels"
                optionLabel="name"
                placeholder=" المرحلة الدراسية"
                option-value="id"
                :class="{ 'p-invalid':v$.filter.level_id.$invalid && submitted }"
                @change="getClasses()"
                />
                <small class="p-error" v-if="v$.filter.level_id.$invalid && submitted">يجب اختيار  مرحلة</small>

            </div>
            <div class="field col-12 md:col-2">
                <label for="class_id"> الصف</label>
                <Dropdown
                id="class_id"
                v-model="filter.class_id"
                :options="filterclasses"
                optionLabel="name"
                placeholder="اختر الصف"
                option-value="id"
                :class="{ 'p-invalid':v$.filter.class_id.$invalid && submitted }"


                />
                <small class="p-error" v-if="v$.filter.class_id.$invalid && submitted">يرجى اختيار  الصف</small>

            </div>
            <div class="field col-12 md:col-2">
                <label for="type_id"> النوع </label>
                <Dropdown
                id="type_id"
                v-model="filter.type"
                :options="types"
                optionLabel="name"
                placeholder="اختر "
                option-value="id"
                />
            </div>
            <div class="field col-12 md:col-1">
                <label > </label>
                <Button label="بحث"
                    icon="pi pi-search"
                    class=" ml-3" 
                    @click="onFilter(!v$.$invalid)"/>
            </div>
            <div class="field col-12 md:col-3">
                <label > </label>
                <Button label="تفرغة حقول البحث"
                    icon="pi pi-search"
                    class=" ml-3" 
                    @click="reset()"/>
            </div>
           

            </div>
            <template v-if="filter.type==1 || filter.type==0 ">
                <div class="grid p-fluid mt-4 font-bold mr-5">    
                        <div class="col-12 md:col-12 mr-10">
                            <DataTable  :value="absences" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
                                <Column field="id_number" header="الرقم ">
                                    <template #body="slotProps">
                                            {{slotProps.index+1}}
                                    </template>
                                </Column>
                                <Column field="student_name" header="اسم الطالب"></Column>
                                <Column field="absence_date" header="تاريخ الغياب"></Column>
                                <Column field="absence_reason" header="سبب الغياب"></Column>
                                <Column field="absence_type_name" header="نوع الغياب"></Column>
                                <Column field="teacher_signature" header=" توقيع المعلم"></Column>
                            </DataTable>   
                        </div>
                    </div>
            </template>

            <template v-if="filter.type==2 || filter.type==0 ">
    
                <div class="grid p-fluid mt-5 font-bold mr-5">
                    <div class="col-12 md:col-12 mr-10">
                        <DataTable  :value="delays" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
                            <Column field="id_number" header="الرقم ">
                                <template #body="slotProps">
                                        {{slotProps.index+1}}
                                </template>
                            </Column>
                            <Column field="student_name" header="اسم الطالب"></Column>
                            <Column field="delay_date" header="تاريخ التاخير"></Column>
                            <Column field="delay_reason" header="سبب التاخير"></Column>
                            <Column field="delay_amount" header="مقدار التاخير"></Column>
                            <Column field="student_signature" header=" توقيع الطالب"></Column>
                        </DataTable>
                    </div>
                </div>
            </template>  
            <template v-if="filter.type==3 || filter.type==0 ">
                <div class="grid p-fluid mt-5 font-bold mr-5"> 
                    <div class="col-12 md:col-12 mr-10">
                        <DataTable  :value="violations" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
                            <Column field="id_number" header="الرقم ">
                                <template #body="slotProps">
                                        {{slotProps.index+1}}
                                    </template>
                            </Column>
                            <Column field="student_name" header="اسم الطالب"></Column>
                            <Column field="violation_date" header="تاريخ المخالفة"></Column>
                            <Column field="action_performed" header=" الاجراء المنفذ"></Column>
                            <Column field="violation_procedure_id" header="نوع الاجراء"></Column>
                            <Column field="violation_degree_id" header="درجة المخالفة"></Column>
                            <Column field="student_signature" header="توقيع الطالب"></Column>
                            <Column field="suprvisore_signature" header=" توقيع الاداري"></Column>
                        </DataTable>

                    </div>
                </div>
            </template>      
            <template v-if="filter.type==4 || filter.type==0 ">
    
                <div class="grid p-fluid mt-5 font-bold mr-5">         
                    <div class="col-12 md:col-12 mr-10">
                        <DataTable  :value="leaves" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
                            <Column  header="الاستئذان ">
                                <template #body="slotProps">
                                        {{slotProps.index+1}}
                                    </template>
                                    </Column>
                            <Column field="student_name" header="اسم الطالب"></Column>
                            <Column field="leave_date" header="تاريخ الاستئذان"></Column>
                            <Column field="leave_reason" header="سبب الاستئذان"></Column>
                            <Column field="leave_time" header="وقت الاستئذان"></Column>
                            <Column field="student_signature" header=" توقيع الطالب"></Column>
                        </DataTable>
                    </div>
                </div>
            </template>    
 
        <template v-if="filter.type==5 || filter.type==0 ">
            <div class="grid p-fluid mt-5 font-bold mr-5">
                <div class="col-12 md:col-12 mr-10">
                    <DataTable  :value="books" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
                    <Column  header="الرقم ">
                        <template #body="slotProps">
                                {{slotProps.index+1}}
                        </template>
                    </Column>
                    <Column field="student_name" header="اسم الطالب"></Column>
                    <Column field="received_date" header="تاريخ التسليم"></Column>
                    <Column field="book_name" header=" اسم الكتاب"></Column>
                    <Column field="is_delivered" header=" التسليم"></Column>
                    <Column field="student_signature" header=" توقيع الطالب"></Column>
                    </DataTable>
                </div>
            </div>
        </template>  
        </div>
      </div>
    </div>
</template>
  
<script>
import BooksService from "@/services/booksService";
import AbsencesService from "@/services/absencesService";
import DelaysService from "@/services/delaysService";
import LeavesService from "@/services/leavesService";
import ViolationsService from "@/services/violationsService";
import SchoolsService from "@/services/schoolsService";
import { useVuelidate } from "@vuelidate/core";
import {required} from "@vuelidate/validators";

    
export default {
  setup () {
    return { v$: useVuelidate() }
  },
      data() {
          return {
              classes: [],
              filterclasses:[],
              levels: [],
              form: {},
              filter: {},
              date:null,
              types: [
                 { id: "", name: "اختر" },
                  { id: 1, name: "غياب" },
                  { id: 2, name: "تاخير صباحي" },
                  { id: 3, name: " مخالفات سلوكية" },
                  { id: 4, name: " اذونات" },
                  { id: 5, name :" تسليم كتب"},
              ],
              absences: [],
              books: [],
              delays: [],
              leaves: [],
              violations: [],
              submitted: false,
              
          };
      },
      validations() {
    return {
      filter: {
            class_id: { required },
            level_id:{required}
      }
    }
  },
    created() {
          this.service = new SchoolsService();
          this.absencesService = new AbsencesService();
          this.delaysService = new DelaysService();
          this.leavesService = new LeavesService();
          this.violationsService = new ViolationsService();
          this.booksService = new BooksService();
    },

    methods: {
          getAbsences() {
              this.absencesService.index(this.query).then(({ data }) => {
                  if (data.code == 200) {
                      this.absences = data.data.absences;
                  }
              });
          },
          getBooks() {
            this.booksService.index(this.query).then(({ data }) => {
                if (data.code == 200) {
                    this.books = data.data.books;
                }
              });
          },
          getDelays() {
            this.delaysService.index(this.query).then(({ data }) => {
                if (data.code == 200) {
                    this.delays = data.data.delays;
                }
             });
          },
          getLeaves() {
            this.leavesService.index(this.query).then(({ data }) => {
                if (data.code == 200) {
                    this.leaves = data.data.leaves;
                }
            });
          },
          getViolations() {
            this.violationsService.index(this.query).then(({ data }) => {
                if (data.code == 200) {
                    this.violations = data.data.violations;
                }
            });
          },
          getClasses() { 
              this.filterclasses = this.classes.filter((_class) => { return _class.level_id == this.filter.level_id });
        },
        loadData() {
            this.getAbsences();
            this.getDelays();
            this.getViolations();
            this.getBooks()
            this.getLeaves();
        },
        
        onFilter(isFormValid) {
            this.submitted = true;
            if (!isFormValid) {
                return;
            }
            this.filter_loading = true;
            this.query = {
                  level_id:this.filter.level_id,
                  class_id: this.filter.class_id,
                //   date:this.formatDate(this.filter.date)
              };
            this.filter.type=this.filter.type?this.filter.type:0
            if (this.date) {
            this.filter.date = this.formatDateForSearch(this.date);
            }

            this.query = Object.assign(this.query, this.filter);
            this.loadData();
        },
        reset() { 
            this.submitted = false;
            this.filter={}
                }
    
       },
    mounted() {
        this.query = {
                  level_id:this.filter.level_id,
                  class_id: this.filter.class_id,
              };
        this.currentUser = this.$store.getters['settings/currentUser'];
        this.service.index(this.query).then(({ data }) => {
            if (data.code == 200) {
                this.levels = data.data.Levels;
                this.classes = data.data.Classes;

                if (this.currentUser.classes.length> 0) {
                    this.classes = this.currentUser.classes;
                    this.levels = this.levels.filter(level => {
                        return this.currentUser.classes.map((el) => { return el.level_id }).includes(level.id)
                    });
                }
            }

        });
    },
    
  };
  </script>
  
  <style scoped>
  .card {
    border-radius: 0%;
  }
  /* .grid {
    margin-left: -0.035rem;
  }
  .md\:col-12 {
    padding: 0.5rem 0.5rem 0.5rem 0rem;
  } */
  
  .x {
    background-color: blueviolet;
    color: white;
  }
  .p-button.p-button-outlined:enabled:hover {
    background-color: blueviolet;
    color: white;
  }


.grid {
  margin-left: 0rem;
  margin-right: 0rem;
}

::-webkit-scrollbar {
    width: 14px !important;

  }
  </style>
  