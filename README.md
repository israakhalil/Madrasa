# Madrasa — School Management System | نظام إدارة مدرسية

> منصة متكاملة لإدارة شؤون طلاب المدارس الثانوية: الطلاب، الفصول، الغياب، التأخير، الإجازات، المخالفات والصلاحيات.
> A full-stack platform for managing secondary-school student affairs: students, classes, absences, delays, leaves, violations and role-based access.

| Part | Stack | Docs |
|---|---|---|
| [`backend/`](backend) | Laravel 9 · Sanctum · MySQL | [backend/README.md](backend/README.md) |
| [`frontend/`](frontend) | Vue 3 · Vite · PrimeVue · Vuex · i18n | [frontend/README.md](frontend/README.md) |

## Features / المزايا

- Multi-school support with levels and classes / دعم عدة مدارس بمستوياتها وفصولها
- Student records and behavior tracking: absences, delays, leaves, violations, books / سجل الطلاب والمتابعة السلوكية
- Role-based permissions (Laravel Sanctum) / صلاحيات وأدوار تفصيلية
- Arabic (RTL) and English UI, Hijri date entry / واجهة عربية وإنجليزية مع التاريخ الهجري
- Printable reports and charts / تقارير قابلة للطباعة ورسوم بيانية

## Quick start / تشغيل سريع

```bash
# backend
cd backend
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan serve

# frontend (new terminal)
cd frontend
npm install
cp .env.example .env   # VITE_API_URL=http://127.0.0.1:8000/api
npm run dev
```

Demo login after seeding: `admin@gmail.com` / `123456` (demo only — change before any deployment).

## History

This repository merges the former `Madrasa-backend` and `Madrasa-frontend` repositories with their full commit history preserved.

## License

MIT
