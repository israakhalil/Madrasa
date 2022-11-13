<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(
            [
                'name'=>" قائمة المشرفين",
             'code'=>"SUPERVISOR_VIEW_ALL"
            ]);
            Permission::create(
                [
                    'name'=>" قائمة المدارس",
                 'code'=>"SCHOOL_VIEW_ALL"
                ]);
            Permission::create(
                [
                    'name'=>" قائمة المراحل الدراسية",
                    'code'=>"LEVEL_VIEW_ALL"
                ]);
            Permission::create(
                [
                    'name'=>"  المراحل ",
                    'code'=>"GRADE_VIEW_ALL"
                ]);
            Permission::create(
                [
                    'name'=>"  الاداريين ",
                    'code'=>"ADMINISTRATOR_VIEW_ALL"
                ]);
            Permission::create(
                [
                    'name'=>"  الشهادات ",
                    'code'=>"CERTIFICATE_VIEW_ALL"
                ]);
            Permission::create(
                [
                    'name'=>"  السجلات ",
                    'code'=>"RECORD_VIEW_ALL"
                ]);
                Permission::create(
                    [
                        'name'=>"اضافة صف",
                        'code'=>"CLASS_ADD"
                    ]);
                    Permission::create(
                        [
                            'name'=>"قائمة الطلاب",
                            'code'=>"STUDENT_VIEW_ALL"
                        ]);
                    Permission::create(
                        [
                            'name'=>"اضافة وتعديل طالب",
                            'code'=>"STUDENT_ADD_EDIT"
                        ]);
                        Permission::create(
                            [
                                'name'=>"حذف طالب",
                                'code'=>"STUDENT_DELETE"
                            ]);
                            Permission::create(
                                [
                                    'name'=>"اضافة وتعديل غياب",
                                    'code'=>"ABSENCE_ADD_EDIT"
                                ]);
                                Permission::create(
                                    [
                                        'name'=>"حذف غياب",
                                        'code'=>"ABSENCE_DELETE"
                                    ]);
    }
}
