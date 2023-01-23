<template>
<div class="col-12 md:col-12" id="printBook">
    <div class="grid">
        <div class="col-12 md:col-9 div-right">
            <span class="font-bold text-xl" style="color: var(--primary-color)">
            تسليم الكتب
            </span>
    </div>
    <div class="col-12 md:col-2 sm:col-7 button-dispaly">
    <Button 
        width="70%"
        label=" اضافة تسليم"
        icon="pi pi-plus"
        class="p-button-outlined align-left"
        @click="openNew"
         v-if="this.can('BOOK_ADD_EDIT')"
        />
    </div>
    <div class="col-12 md:col-1 sm:col-5 button-dispaly">
    <Button 
        width="70%"
        label="طباعة"
        class="p-button-outlined align-left"
        @click="printBook"
        v-if="this.can('BOOK_ADD_EDIT')"
        />
    </div>
    </div>

    <div class="col-12 md:col-12 mr-10"  id="printBook">
        <!-- <div hidden class="name">  الطالب : {{student_name}}</div> -->
    <DataTable  :value="student_books" class="p-datatable-lg font-bold" showGridlines  responsiveLayout="scroll">
    <Column  header="الرقم ">
        <template #body="slotProps">
                {{slotProps.index+1}}
            </template>
            </Column>
    <Column field="received_day" header="يوم التسليم">
            <template #body="slotProps">
                {{getDay(slotProps.data.received_date)}}
            </template>
      </Column>
      <Column field="hijri_date" header="تاريخ الهجري">
        </Column>
    <Column field="received_date" header="تاريخ التسليم">
    </Column>
    <Column field="book_name" header=" اسم الكتاب">
        
    </Column>
    <Column field="is_delivered" header=" التسليم">
        
    </Column>
    <Column field="student_signature" header=" توقيع الطالب">
        
    </Column>

    <Column  header="  الاجراءات" style="max-width:8rem">
        <template #body="slotProps">
            <!-- <Button icon="pi pi-download" class="p-button-rounded p-button-help ml-2" /> -->
            <Button v-if="this.can('BOOK_ADD_EDIT')" icon="pi pi-pencil" class="p-button-rounded p-button-success ml-2" @click="openEdit(slotProps.data)"/>
            <Button v-if="this.can('BOOK_DELETE')" icon="pi pi-trash" class="p-button-rounded p-button-danger ml-2" @click="openDelete(slotProps.data)"/>
        </template>

    </Column>
    </DataTable>

</div>
</div>


<Dialog v-model:visible="BookDialog" :style="{width: '450px'}" :header="header" :modal="true" 
class="p-fluid font-bold text-lg">
<div class="field col">
    <label>تاريخ التسليم / هجري </label>           
            <div class="grid">
                <div class="col-3">       
                        <Dropdown
                        v-model="form.day"
                        :options="days"
                        optionLabel="name"
                        placeholder="يوم"
                        option-value="id"
                        :class="{ 'p-invalid':v$.form.day.$invalid && submitted }"
                        />
                </div>
                <div class="col-5">
                    <Dropdown
                        v-model="form.month"
                        :options="hijri_months"
                        optionLabel="name"
                        ref="monthName"
                        placeholder="شهر"
                        option-value="id"
                        :class="{ 'p-invalid':v$.form.month.$invalid && submitted }"
                        />
                </div>
                <div class="col-4">
                    <Dropdown
                        v-model="form.year"
                        
                        :options="years"
                        optionLabel="name"
                        placeholder="سنة"
                        option-value="id"
                        :class="{ 'p-invalid':v$.form.year.$invalid && submitted }"
                        />
                </div>
            </div>

           
            <small class="p-error" v-if="v$.form.day.$invalid && submitted">يرجى اختيار  يوم , </small>
            <small class="p-error" v-if="v$.form.month.$invalid && submitted">يرجى اختيار  شهر ,  </small> 
            <small class="p-error" v-if="v$.form.year.$invalid && submitted">يرجى اختيار  سنة  </small>

          </div>
    <div class="field">
        <label for="received_date">تاريخ التسليم  / ميلادي</label>
        <Calendar id="received_date" :showIcon="true" 
        v-model="form.received_date"
        :class="{ 'p-invalid':v$.form.received_date.$invalid && submitted }"></Calendar>
        <small class="p-error" v-if="v$.form.received_date.$invalid && submitted">يرجى اختيار  تاريخ  </small>

      </div>
      
      <div class="field">
        <label for="book_name">اسم الكتاب </label>
        <InputText
        id="book_name"
        v-model.trim="form.book_name"
        :class="{ 'p-invalid':v$.form.book_name.$invalid && submitted }"/>
          <small class="p-error" v-if="v$.form.book_name.$invalid && submitted">يرجى  ادخال اسم الكتاب     </small>

        </div >
        <div class="field">
        <label for="is_delivered">  التسليم </label>
        <Dropdown
            id="is_delivered"
            v-model="form.is_delivered"
            :options="delivered_options"
            optionLabel="name"
            placeholder=" اختر"
            option-value="id"
            :class="{ 'p-invalid':v$.form.is_delivered.$invalid && submitted }"

          />
          <small class="p-error" v-if="v$.form.is_delivered.$invalid && submitted">يرجى  الاختيار      </small>

        </div >
        <div  class="field">
            <label for="student_signature"> توقيع الطالب </label>
            <InputText
            id="student_signature"
            v-model.trim="form.student_signature"
            required="true"
            :class="{ 'p-invalid':v$.form.student_signature.$invalid && submitted }"
            />
            <small class="p-error" v-if="v$.form.student_signature.$invalid && submitted">يرجى  ادخال توقيع     </small>

        </div>
      <div class="field">
        <Button label="تعديل" v-if="form.id" class="mt-5" type="submit" @click="save(!v$.$invalid)"  />
        <Button label="حفظ" v-if="form.id==null" class="mt-5" type="submit" @click="save(!v$.$invalid)"  />
      </div>
    </Dialog>

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
             <Button  label="حذف"  class=" p-button-outlined mt-5"   @click="deleteBook" />
        </div>
        <div class="col-6 md:col-6">            
             <Button v-if="this.can('BOOK_ADD_EDIT')"  label="الغاء"  class="p-button-outlined mt-5" @click="deleteconfirm = false"  />
        </div>
    </div>
        </template>

</Dialog>

    <SuccessMsg :successMsg=successMsg  :Msg=Msg />
    <!-- <ErrorMsg :errorMsg=errorMsg /> -->
</template>


<script>
import BooksService from "@/services/booksService";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import {hijri_months} from "@/services/constants.js";
export default {
setup () {
    return { v$: useVuelidate() }
},
props: ["student_id",'class_id','student_name'],

data() {
    return {
        submitted:false,
        student_books: [],
        header:null,
        BookDialog: false,
        successMsg: false,
        Msg: null,
        deleteMsg:null,
        errorMsg: false,
        deleteconfirm:false,
        form:{},
        
        booksService: null,
        delivered_options: [
        {
            id: '1',
            name: 'تم التسليم'
        },
        {
            id: '2',
            name: 'لم يتم التسليم'
            }],
            days: Array.from({ length: 31 }, (_, i) => ({ id: String((i+1)), name: (i+1) })),
            hijri_months: [],
            years: Array.from({ length: 10 }, (_, i) => ({ id: String((i+1444)), name: (i+1444) })),
    }  
},
validations() {
    return {
    form: {
        received_date: { required },
        book_name: { required },
        is_delivered: { required },
            student_signature: { required },
            day: { required },
                month:{ required },
            year:{ required },
    }
    }
  },
created() {
    this.booksService = new BooksService();  
},
methods: {
    openNew() {
        this.header="اضافة تسليم كتاب"
        this.form = {};
        this.submitted = false;
        this.BookDialog = true;

    },
    openEdit(data) {
        this.header="تعديل تسليم كتاب"
        this.form = { ...data };  
        let hijri = this.form.hijri_date.split(',');
        this.form.day = hijri[0].trim();
        this.form.month = hijri[1].trim();
        this.form.year = hijri[2];
        this.BookDialog = true;
    },
    openDelete(data) { 
        this.form = data;
        this.deleteconfirm = true;
        this.deleteMsg = "هل انت متاكد من الحذف ";
    },
    save(isFormValid) {
             this.successMsg = false;
            this.submitted = true;
            if (!isFormValid) {
                return;
        }   
        this.form.class_id = this.class_id;
        this.form.student_id = this.student_id
        this.form.received_date=this.formatDate(this.form.received_date)
        this.form.hijri_date = this.form.day + ' ,' + this.form.month+' ,'+this.form.year;

        this.booksService.save(this.form, this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.BookDialog = false;
            this.successMsg = true;
            this.Msg = data.msg;
            this.getBooks();
        }
        });        },
    deleteBook() { 
        this.successMsg = false;
        this.booksService.delete(this.form.id).then(({ data }) => {
            if (data.code == 200) {
            this.deleteconfirm = false;
            this.successMsg = true;
                this.Msg = data.msg;
                this.student_books = this.student_books.filter(val => val.id !== this.form.id);
                this.form={}
        }
        });
      
    },

    getBooks() {
        this.query = { student_id: this.student_id };
        this.booksService.index(this.query).then(({ data }) => {
        if (data.code == 200) {
            this.student_books = data.data.books;

        }
    });
    },
    printBook () {
        this.$htmlToPaper('printBook');
      },

},

mounted() { 
    this.getBooks();
    this.hijri_months = hijri_months;
}
};
</script>

<style scoped>
.p-button:enabled:hover {
background: #7C3AED;
color: #ffffff;
border-color: #7C3AED;
}
.p-dialog .p-dialog-footer button{
width:100%
}
</style>