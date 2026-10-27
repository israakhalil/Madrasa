import { createI18n } from 'vue-i18n';

const messages = {
  en: {},
  ar: {
    'app_title': 'وزارة المالية - نظام رواتب المدنين',
    'home': 'الرئيسية',
    'develped_by': 'تم التطوير بواسطة -',
    'admins': 'المدراء',
    'users_management':'ادارة المستخدمين',
    'roles': 'الأدوار',
    'permissions': 'الصلاحيات',
    'users': 'المستخدمين',
    'departments':'الدوائر',
     'lookups' :'الثوابت',
     'required':'هذا الحقل مطلوب',

    'general':{
      'name': 'الاسم',
      'status': 'الحالة',
      'actions': 'اجراءات',
      'detail': 'تفاصيل',
      'note': 'ملاحظات',
      'all': 'الكل',
      'yes': 'نعم',
      'no': 'لا',
      'created_at': 'تاريخ الإنشاء',
      'type':'نوع',
      'choose' :'اختر..',
       'description': 'الوصف',
        'id': 'م',
      'active':'فعال',
      'not-active':'غير فعال'
    },
    'user':{
      'user':'مستخدم',
      'id': 'م',
      'id_number': 'رقم الهوية',
      'username': 'اسم المستخدم',
      'title': 'الوصف',
      'email': 'البريد الإلكتروني',
      'old_password': 'كلمة المرور القديمة',
      'password': 'كلمة المرور',
      'password_confirmation': 'تاكيد كلمة المرور ',
      'profile': 'الملف الشخصي',
      'change_password': 'تغيير كلمة المرور',
      'administrative_structure': 'الهيكلية الادارية',
      'ministries': 'الوزارات',
      'unites': 'الإدارات',
      'departments': 'الدائرة',
      'sections': 'الاقسام',
    },
 
    'messages':{
      'select_one_at_least' : 'يرجى اختيار عنصر على الاقل',
      'choose_roles' : 'يرجى اختيار الأدوار ',
      'choose_permissions' : 'يرجى اختيار الصلاحيات ',
      'are_you_sure_to_complete_process' : "هل انت متأكد من العملية ؟ " ,
      'are_you_sure_to_delete_record' : "هل انت متأكد من حذف هذا العنصر؟ " ,
      'logout_message': 'تم تسجيل الخروج بنجاح ',
      'fetching Data': 'جاري جلب البيانات',
      'no_data_found': 'لا يوجد بيانات',
    },
    'actions':{
      'save': 'حفظ',
      'delete': 'حذف',
      'add': 'إضافة',
      'edit': 'تعديل',
      'print': 'طباعة',
      'search': 'بحث',
      'clear': 'مسح',
      'show' : "عرض" ,
      'close' : 'اغلاق',
      'logout': 'تسجيل خروج',
      'login': 'تسجيل الدخول',
      'go_home': 'الرجوع للصفحة الرئيسية',
      'confirmation' : "تاكيد" ,
      'delete_confirmation' : "تأكيد الحذف" ,
      'main':'الرئيسية'
    },


    'auth' : {
      'sign_in_to_continue'  : "يرجى تسجيل الدخول للمتابعة",
      'forget_password'  : "نسيت كلمة المرور؟",
      'forget_password_hint'  : "ادخل رقم الهوية الخاص بك وسوف يتم ارسال رمز اعادة التعيين اليك",
      'request_reset_password'  : "طلب رمز التعيين",
      'back_to_login'  : "العودة لصفحة الدخول",
    },

    'errors' : {
      'error_occured'  : "حدث خطأ ما",
      'error_page_title': 'لقد حدث خطأ ما',
      'error_page_content': 'حدث خطأ ما اثناء معالجة البيانات , يرجى المحاولة مرة اخرى',
    },

    'search_keys' : {
      'search_by_name'  : "بحث بالاسم",
      'search_by_note'  : "بحث بالملاحظات",
    },



    'file_upload':{
          'upload':'تحميل',
          'choose':'اختر ملف',
          'import':'استيراد' ,
          'export': 'تصدير'

    },

   },
};

const i18n = createI18n({
  locale: localStorage.getItem('lang') || 'ar',
  messages,
  silentTranslationWarn: true
});

export default i18n;
