<template>
    <div class="grid">
        <div class="col-12 md:col-12 ">
            <div class="card">
                <h5>المراحل المدرسية > {{this.class.level_name}} >  {{this.class.name}}</h5>
                <div>
        <DataTable :value="products" responsiveLayout="scroll">
            <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field"></Column>
        </DataTable>
    </div>

  
        </div>
        </div>

    </div>
</template>

<script>

import ClassesService from "@/services/classesService";


    
export default {
    props:['id'],
    data() {
        return {
            columns: null,
            class: []
        }
    },
    classesService: null,
    created() {

        this.classesService = new ClassesService();

        this.columns = [
            // {field: 'code', header: 'Code'},
            {field: 'name', header: 'Name'},
            // {field: 'category', header: 'Category'},
            // {field: 'quantity', header: 'Quantity'}
        ];
    },
    mounted() {
        this.query = { id: this.id };
       
        // this.classesService.index(this.query).then(data => this.classes = data);

        this.classesService.index(this.query).then(({ data }) => {
                if (data.code == 200) {
                   
                    this.class = data.data.Classes[0];
                    console.log( this.class);
                }
              
               
            
            })
    },
   
};
</script>