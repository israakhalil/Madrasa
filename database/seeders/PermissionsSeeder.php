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
             'code'=>"SUPERVISOR_VIEW_ALL",
             'group'=>1
            ]);
        Permission::create(
            [
                'name'=>" قائمة المدارس",
                'code'=>"SCHOOL_VIEW_ALL",
                'group'=>1
            ]);


            Permission::create(
                [
                    'name'=>"   قائمة المراحل ",
                    'code'=>"LEVEL_VIEW_ALL",
                    'group'=>2
                ]);
            Permission::create(
                [
                    'name'=>"   قائمة الصفوف",
                    'code'=>"GRADE_VIEW_ALL",
                    'group'=>2
                ]);
            Permission::create(
                [
                    'name'=>"   قائمة الاداريين ",
                    'code'=>"ADMINISTRATOR_VIEW_ALL",
                    'group'=>2
                ]);
            Permission::create(
                [
                    'name'=>"   قائمة الشهادات ",
                    'code'=>"CERTIFICATE_VIEW_ALL",
                    'group'=>2
                ]);
            Permission::create(
                [
                    'name'=>" قائمة  السجلات ",
                    'code'=>"RECORD_VIEW_ALL",
                    'group'=>2
                ]);
             Permission::create(
                [
                    'name'=>"اضافة صف",
                    'code'=>"CLASS_ADD",
                    'group'=>3
                ]);
            Permission::create(
                [
                    'name'=>"حذف  صف",
                    'code'=>"CLASS_DELETE",
                    'group'=>3
                ]);
                    // Permission::create(
                    //     [
                    //         'name'=>"قائمة الطلاب",
                    //         'code'=>"STUDENT_VIEW_ALL",
                    //         'group'=>1
                    //     ]);
                    Permission::create(
                        [
                            'name'=>"اضافة وتعديل طالب",
                            'code'=>"STUDENT_ADD_EDIT",
                            'group'=>3
                        ]);
                    Permission::create(
                        [
                            'name'=>"حذف طالب",
                            'code'=>"STUDENT_DELETE",
                            'group'=>3
                        ]);
                        Permission::create(
                            [
                                'name'=>" استيراد طلاب",
                                'code'=>"STUDENT_IMPORT",
                                'group'=>3
                            ]);
                    Permission::create(
                        [
                            'name'=>"اضافة وتعديل غياب",
                            'code'=>"ABSENCE_ADD_EDIT",
                            'group'=>3
                        ]);

                    Permission::create(
                        [
                            'name'=>"حذف غياب",
                            'code'=>"ABSENCE_DELETE",
                            'group'=>3
                        ]);
                        Permission::create(
                            [
                                'name'=>"اضافة وتعديل تاخير",
                                'code'=>"DELAY_ADD_EDIT",
                                'group'=>3
                            ]);
                        Permission::create(
                            [
                                'name'=>"حذف تاخير",
                                'code'=>"DELAY_DELETE",
                                'group'=>3
                            ]);
                            Permission::create(
                                [
                                    'name'=>"اضافة وتعديل مخالفات سلوكية",
                                    'code'=>"VIOLATION_ADD_EDIT",
                                    'group'=>3
                                ]);
                            Permission::create(
                                [
                                    'name'=>"حذف مخالفات سلوكية",
                                    'code'=>"VIOLATION_DELETE",
                                    'group'=>3
                                ]);
                                Permission::create(
                                    [
                                        'name'=>"اضافة وتعديل  اذونات",
                                        'code'=>"LEAVE_ADD_EDIT",
                                        'group'=>3
                                    ]);
                                Permission::create(
                                    [
                                        'name'=>"حذف  اذونات",
                                        'code'=>"LEAVE_DELETE",
                                        'group'=>3
                                    ]);
                                Permission::create(
                                    [
                                        'name'=>"اضافة وتعديل  كتب",
                                        'code'=>"BOOK_ADD_EDIT",
                                        'group'=>3
                                    ]);
                                Permission::create(
                                    [
                                        'name'=>"حذف  كتب",
                                        'code'=>"BOOK_DELETE",
                                        'group'=>3
                                    ]);
    }
}
