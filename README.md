# Madrasa — Backend API

> نظام إدارة شؤون طلاب المدرسة — خدمة REST API مبنية بـ Laravel 9.
> School student management system — REST API built with Laravel 9.

---

## 🇸🇦 نظرة عامة

خدمة backend لنظام **مدرسة** لإدارة شؤون الطلاب في المدارس الثانوية: الطلاب، الفصول، المستويات، الغياب، التأخير، الإجازات، المخالفات والإجراءات التأديبية، مع نظام صلاحيات وأدوار كامل.

- واجهة الـ frontend (Vue 3): [Madrasa-frontend](https://github.com/israakhalil/Madrasa-frontend)

### المزايا

- 🏫 **إدارة مدارس متعددة** بمستوياتها وفصولها
- 👨‍🎓 **سجل كامل للطلاب** مع بياناتهم وأرقام ذويهم وجنسياتهم
- 📋 **متابعة سلوكية**: غياب، تأخير، إجازات، مخالفات
- 📚 **سجل الكتب المسلّمة** للطلاب
- 🔐 **صلاحيات تفصيلية** (Role-Based Access Control) مع Laravel Sanctum
- 📊 **تقارير جاهزة** عبر API

## 🇬🇧 Overview

Backend service for **Madrasa**, a secondary-school student management platform. Tracks students, classes, levels, absences, delays, leaves, disciplinary violations, and distributed books, with role-based access control.

- Frontend (Vue 3): [Madrasa-frontend](https://github.com/israakhalil/Madrasa-frontend)

### Features

- Multi-school support with levels and classes
- Full student records (contacts, nationality, date of birth, attachments)
- Behavior tracking: absences, delays, leaves, violations
- Books-handed-out log
- Role-based permissions with Laravel Sanctum
- Reports via REST endpoints

---

## 🧱 Tech Stack

- **PHP** 8.0+
- **Laravel** 9.19
- **Laravel Sanctum** (API auth)
- **MySQL** / MariaDB
- **Maatwebsite/Excel** (exports)
- **Guzzle** (HTTP client)

---

## 🚀 Setup / التثبيت

```bash
# clone
git clone https://github.com/israakhalil/Madrasa-backend.git
cd Madrasa-backend

# install dependencies
composer install

# environment
cp .env.example .env
php artisan key:generate

# edit .env with your DB credentials, then:
php artisan migrate --seed
php artisan serve
```

API يعمل افتراضياً على `http://127.0.0.1:8000`.

### بيانات تسجيل الدخول التجريبية / Demo credentials

بعد تشغيل `migrate --seed`:

- **Email**: `admin@gmail.com`
- **Password**: `123456`

> ⚠️ هذه بيانات تجريبية فقط. غيّرها قبل أي نشر إنتاجي.
> Demo-only credentials. Change before any production deployment.

### Demo data via Seeders

تستخدم الـ seeders مكتبة **Faker** لتوليد بيانات واقعية بالعربية:
- 2 مدارس · 5 مستويات · 7 فصول
- ~100–175 طالب موزّعين على الفصول (أسماء ومواليد وجنسيّات عربية)
- سجلات غياب عشوائية خلال آخر 6 أشهر

---

## 📂 Project Structure

```
app/
├── Http/Controllers/
│   ├── Auth/           # Login, Users, Permissions
│   ├── School/         # Schools, Levels, Classes, Students
│   └── Procedures/     # Absences, Delays, Leaves, Violations, Books
├── Models/
│   ├── Auth/
│   ├── School/
│   └── Procedures/
database/
├── migrations/         # 23 migrations
└── seeders/            # Demo data via Faker
routes/api.php          # REST endpoints
```

---

## 📜 License

MIT
