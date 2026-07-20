# Sera Home — منصة تصميم داخلي (Laravel)

منصة تصميم داخلي تساعد المستخدم على تصوّر مساحته: يرفع صورة الغرفة، يختار الأسلوب والميزانية،
فيقترح النظام لوحة ألوان وقائمة أثاث وخطة إضاءة. تتضمّن واجهة **عميل** وواجهة **مشرف**.

بُنيت بـ Laravel 11 + Blade + Tailwind CSS، وقاعدة بيانات MySQL، وواجهة عربية (RTL).

---

## المتطلبات

- PHP 8.2 أو أحدث
- Composer
- Node.js 18+ و npm
- MySQL 8 (أو MariaDB)

> نصيحة: على ويندوز استخدم **Laragon** أو **XAMPP** لتشغيل PHP و MySQL بسهولة.

---

## التشغيل بضغطة واحدة (الأسهل)

المشروع يستخدم **SQLite** (ملف واحد، بلا إعداد MySQL). على ويندوز مع Laragon أو XAMPP:

> **انقر مرتين على ملف `START-SeraHome.bat`**

يقوم الملف تلقائياً بتثبيت المكتبات، توليد المفتاح، تجهيز قاعدة البيانات والبيانات التجريبية،
ثم يشغّل الخادم ويفتح المتصفح على <http://localhost:8000>. لا حاجة لتشغيل `npm` —
الواجهة تعمل بالكامل عبر نسخة Tailwind الاحتياطية.

---

## التشغيل اليدوي (بديل)

```bash
composer install
php artisan key:generate            # الملف .env جاهز مسبقاً على SQLite
php artisan migrate:fresh --seed    # ينشئ database/database.sqlite + بيانات تجريبية
php artisan storage:link            # لعرض الصور المرفوعة
php artisan serve
```

ثم افتح: <http://localhost:8000>

> اختياري: `npm install && npm run dev` لبناء الأصول عبر Vite بدل نسخة CDN الاحتياطية.
> التصميم يعمل تماماً في الحالتين.

### تفعيل التوليد بالذكاء الاصطناعي (اختياري)

ضع مفتاح OpenAI في `.env` ثم `php artisan config:clear`:

```
OPENAI_API_KEY=sk-...
```

بدون مفتاح، يعمل مولّد التصميم تلقائياً بمنطق قواعد ذكي كبديل — فلا شيء يتعطّل.

---

## الحسابات التجريبية

| الدور  | البريد                  | كلمة المرور |
|--------|-------------------------|-------------|
| عميل   | sara@serahome.test      | password    |
| مشرف   | admin@serahome.test     | password    |

---

## بنية قاعدة البيانات

- **users** — المستخدمون مع حقل `role` (client / admin) وتفضيلات التصميم.
- **projects** — مشاريع العملاء (الغرفة، الأسلوب، الميزانية، الحالة، نسبة الإنجاز، الصورة).
- **designs** — ناتج التصميم لكل مشروع (لوحة ألوان + أثاث + إضاءة + تكلفة تقديرية) بصيغة JSON.
- **inspirations** — بطاقات معرض الإلهام.
- **messages** — رسائل الدردشة بين العميل والمصمم.

العلاقات: `User hasMany Project`، `Project hasOne Design`، `Project hasMany Message`.

---

## أين تجد الأشياء المهمة

| المكوّن                     | المسار                                             |
|-----------------------------|----------------------------------------------------|
| مولّد التصميم (المنطق الذكي) | `app/Services/DesignGenerator.php`                 |
| صلاحيات الأدوار             | `app/Http/Middleware/EnsureRole.php`               |
| المسارات                    | `routes/web.php`                                    |
| نظام الألوان والخطوط         | `tailwind.config.js` + `resources/css/app.css`     |
| القالب الأساسي (RTL)        | `resources/views/layouts/app.blade.php`            |
| واجهات العميل               | `resources/views/client/`                          |
| واجهات المشرف               | `resources/views/admin/`                           |

> `app/Services/DesignGenerator.php` مكتوب كطبقة مستقلة: استبدله لاحقاً بنداء نموذج ذكاء اصطناعي حقيقي دون تغيير بقية التطبيق.

---

## هوية التصميم

- الألوان: طيني/تيراكوتا `#C15F3C`، فحمي `#2B2622`، خلفية ورقية دافئة `#F7F2EC`، مع لمسات صنوبرية وذهبية.
- الخطوط: **Tajawal** للنصوص، و**Playfair Display** للعناوين اللاتينية.

> النموذج القديم محفوظ في مجلد `_old_prototype/` للرجوع إليه.
