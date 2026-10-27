# Madrasa — Frontend (Vue 3)

> واجهة مستخدم لنظام إدارة شؤون طلاب المدرسة — Vue 3 + PrimeVue.
> Student management system UI — Vue 3 + PrimeVue SPA.

---

## 🇸🇦 نظرة عامة

واجهة ويب تفاعلية لنظام **مدرسة**: لوحة تحكم مدرسية لمتابعة الطلاب والفصول والغياب والمخالفات، بدعم كامل للغة العربية (RTL) والتاريخ الهجري.

- خدمة الـ backend (Laravel): [Madrasa-backend](https://github.com/israakhalil/Madrasa-backend)

### المزايا

- 🌐 **ثنائية اللغة** (عربي / إنجليزي) عبر vue-i18n، مع دعم RTL كامل
- 📅 **دعم التاريخ الهجري** (إدخال اليوم والشهر والسنة الهجرية)
- 📊 **رسوم بيانية** للتقارير بـ Chart.js
- 🖨️ **طباعة التقارير** بـ vue-html-to-paper
- ✅ **تحقق من المدخلات** بـ Vuelidate
- 🧩 **مكتبة مكوّنات غنية** بـ PrimeVue (DataTable, Dialog, Calendar…)
- 🔔 **إشعارات** بـ vue-toaster

## 🇬🇧 Overview

Interactive web UI for the **Madrasa** platform: a school dashboard for managing students, classes, attendance, and disciplinary records, with full Arabic (RTL) and Hijri calendar support.

- Backend (Laravel): [Madrasa-backend](https://github.com/israakhalil/Madrasa-backend)

### Features

- Bilingual (Arabic / English) with RTL via vue-i18n
- Hijri date entry (day / month / year) alongside Gregorian dates
- Report charts via Chart.js
- Printable reports via vue-html-to-paper
- Form validation via Vuelidate
- Rich component kit via PrimeVue
- Toast notifications via vue-toaster

---

## 🧱 Tech Stack

- **Vue** 3.2
- **Vite** 3
- **PrimeVue** 3 · PrimeFlex · PrimeIcons
- **Vuex** 4 (state)
- **Vue Router** 4
- **Vue i18n** 9
- **Axios** · **Chart.js** · **Moment** · **Vuelidate**

---

## 🚀 Setup / التثبيت

```bash
# clone
git clone https://github.com/israakhalil/Madrasa-frontend.git
cd Madrasa-frontend

# install
npm install

# dev server
npm run dev

# production build
npm run build
```

تأكد من تشغيل الـ backend أولاً على `http://127.0.0.1:8000`، أو عدّل `baseURL` في `src/axios/`.

Make sure the backend is running at `http://127.0.0.1:8000`, or adjust `baseURL` in `src/axios/`.

---

## 📂 Project Structure

```
src/
├── assets/            # Styles, images, fonts
├── axios/             # API client config
├── components/        # Shared components (toasts…)
├── localization/      # i18n files (ar/en)
├── mixins/            # Shared helpers
├── pages/
│   ├── account/
│   ├── admin/
│   ├── auth/
│   ├── class/         # Absences, Delays, Books, Violations
│   ├── layouts/
│   └── student/
├── router/
├── services/          # Constants, API services
├── store/             # Vuex modules
└── App.vue
```

---

## 📜 License

MIT
