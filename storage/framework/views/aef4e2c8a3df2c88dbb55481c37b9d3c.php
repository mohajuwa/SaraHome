<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="bg-canvas text-ink">

    
    <header class="sticky top-0 z-40 border-b border-line/70 bg-canvas/85 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4">
            <?php echo $__env->make('partials.brand', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <nav class="hidden items-center gap-6 text-sm font-medium text-ink/70 sm:flex">
                <a href="#how" class="transition hover:text-clay">كيف نعمل</a>
                <a href="#store" class="transition hover:text-clay">المتجر</a>
                <a href="#gallery" class="transition hover:text-clay">أعمالنا</a>
            </nav>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('login')); ?>" class="btn-ghost !py-2.5">تسجيل الدخول</a>
                <a href="<?php echo e(route('register')); ?>" class="btn-primary !py-2.5">ابدأ مجاناً</a>
            </div>
        </div>
    </header>

    
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -left-24 -top-24 h-80 w-80 rounded-full bg-clay-soft opacity-60"></div>
        <div class="pointer-events-none absolute -bottom-32 right-1/4 h-72 w-72 rounded-full bg-pine-soft opacity-50"></div>

        <div class="mx-auto grid max-w-6xl items-center gap-10 px-5 py-16 lg:grid-cols-2 lg:py-24">
            <div class="animate-fade-up">
                <p class="text-xs font-bold tracking-[.25em] text-clay">منصة التصميم الداخلي الذكية</p>
                <h1 class="mt-4 font-display text-4xl leading-tight sm:text-5xl">
                    بيتٌ أجمل يبدأ<br><span class="text-clay">بفكرة ذكية.</span>
                </h1>
                <p class="mt-5 max-w-md text-lg text-muted">
                    ارفع صورة غرفتك، حدّد ذوقك وميزانيتك، واستلم تصوّراً متكاملاً:
                    لوحة ألوان، أثاث بأسعار حقيقية، وخطة إضاءة — في ثوانٍ.
                </p>
                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="<?php echo e(route('register')); ?>" class="btn-primary !px-7 !py-3.5 text-base">صمّم مساحتك الآن</a>
                    <a href="#how" class="btn-ghost !px-7 !py-3.5 text-base">شاهد كيف</a>
                </div>
                <div class="mt-8 flex items-center gap-6 text-sm text-muted">
                    <span><b class="font-display text-xl text-ink">1,200+</b> مشروع</span>
                    <span class="h-4 w-px bg-line"></span>
                    <span><b class="font-display text-xl text-ink">4.8 ★</b> رضا العملاء</span>
                    <span class="h-4 w-px bg-line"></span>
                    <span><b class="font-display text-xl text-ink">14</b> مدينة</span>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="overflow-hidden rounded-[2.5rem] shadow-soft">
                    <img src="<?php echo e(asset('images/rooms/living-warm.svg')); ?>" alt="تصميم غرفة معيشة" class="w-full">
                </div>
                <div class="absolute -bottom-6 -left-6 w-52 overflow-hidden rounded-3xl border-4 border-white shadow-card">
                    <img src="<?php echo e(asset('images/rooms/bedroom-scandi.svg')); ?>" alt="غرفة نوم" class="w-full">
                </div>
                <div class="absolute -top-5 -right-5 rounded-2xl bg-white px-4 py-3 shadow-card">
                    <p class="text-xs text-muted">التكلفة التقديرية</p>
                    <p class="font-display text-xl text-clay">7,850 ريال</p>
                </div>
            </div>
        </div>
    </section>

    
    <section id="how" class="border-y border-line/60 bg-white/60">
        <div class="mx-auto max-w-6xl px-5 py-16">
            <div class="text-center">
                <p class="text-xs font-bold tracking-[.25em] text-clay">ثلاث خطوات فقط</p>
                <h2 class="mt-2 font-display text-3xl">كيف تعمل سارا هوم؟</h2>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                <?php $__currentLoopData = [
                    ['1', 'ارفع صورة غرفتك', 'صورة واضحة لمساحتك الحالية بأي جوال.'],
                    ['2', 'حدّد ذوقك وميزانيتك', 'اختر الأسلوب — مودرن، سكندنافي، كلاسيكي — ونطاق إنفاقك.'],
                    ['3', 'استلم تصوّرك واطلب', 'ألوان وأثاث بأسعار حقيقية تضيفها للسلة مباشرة.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$n, $title, $desc]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card p-7 text-center">
                        <span class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-clay text-lg font-bold text-white"><?php echo e($n); ?></span>
                        <h3 class="mt-4 font-display text-xl"><?php echo e($title); ?></h3>
                        <p class="mt-2 text-sm text-muted"><?php echo e($desc); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <?php if($featured->isNotEmpty()): ?>
        <section id="store" class="mx-auto max-w-6xl px-5 py-16">
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs font-bold tracking-[.25em] text-clay">من متجرنا</p>
                    <h2 class="mt-2 font-display text-3xl">قطع مختارة بعناية</h2>
                </div>
                <a href="<?php echo e(route('register')); ?>" class="text-sm font-bold text-clay">تصفّح الكل ←</a>
            </div>
            <div class="mt-8 grid gap-6 sm:grid-cols-3">
                <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card group overflow-hidden">
                        <div class="aspect-[4/3] overflow-hidden bg-sand">
                            <img src="<?php echo e($product->imageUrl()); ?>" alt="<?php echo e($product->name); ?>"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                        <div class="flex items-center justify-between p-4">
                            <h3 class="font-display text-lg"><?php echo e($product->name); ?></h3>
                            <span class="font-bold text-clay"><?php echo e($product->priceLabel()); ?></span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>

    
    <?php if($inspirations->isNotEmpty()): ?>
        <section id="gallery" class="border-y border-line/60 bg-white/60">
            <div class="mx-auto max-w-6xl px-5 py-16">
                <div class="text-center">
                    <p class="text-xs font-bold tracking-[.25em] text-clay">معرض الإلهام</p>
                    <h2 class="mt-2 font-display text-3xl">مساحات صمّمناها</h2>
                </div>
                <div class="mt-8 grid gap-6 sm:grid-cols-3">
                    <?php $__currentLoopData = $inspirations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group relative h-56 overflow-hidden rounded-3xl" style="background:<?php echo e($insp->accent_color); ?>;">
                            <?php if($insp->image_path): ?>
                                <img src="<?php echo e(asset('images/'.$insp->image_path)); ?>" alt="<?php echo e($insp->title); ?>"
                                     class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <?php endif; ?>
                            <div class="absolute inset-0" style="background:linear-gradient(180deg, transparent 40%, rgba(43,38,34,.55));"></div>
                            <div class="absolute inset-x-0 bottom-0 p-5 text-white">
                                <span class="pill bg-white/20 backdrop-blur"><?php echo e($insp->style); ?></span>
                                <h3 class="mt-2 font-display text-xl drop-shadow"><?php echo e($insp->title); ?></h3>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    
    <section class="mx-auto max-w-6xl px-5 py-16">
        <div class="relative overflow-hidden rounded-[2.5rem] bg-ink p-10 text-center text-white sm:p-14">
            <div class="pointer-events-none absolute -left-16 -top-16 h-56 w-56 rounded-full bg-clay/30"></div>
            <div class="pointer-events-none absolute -bottom-20 -right-10 h-64 w-64 rounded-full bg-pine/30"></div>
            <h2 class="relative font-display text-3xl sm:text-4xl">جاهز تشوف بيتك بشكل جديد؟</h2>
            <p class="relative mx-auto mt-3 max-w-md text-white/70">أنشئ حسابك مجاناً وابدأ أول مشروع تصميم خلال دقيقة.</p>
            <a href="<?php echo e(route('register')); ?>" class="btn-primary relative mt-7 !px-8 !py-3.5 text-base">ابدأ الآن — مجاناً</a>
        </div>
    </section>

    
    <footer class="border-t border-line/70">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-5 py-8 text-sm text-muted">
            <?php echo $__env->make('partials.brand', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <p>© <?php echo e(date('Y')); ?> سارا هوم — مشروع تخرّج بإشراف أكاديمي.</p>
            <a href="https://wa.me/966500000000" target="_blank" rel="noopener" class="font-bold text-pine">تواصل عبر واتساب</a>
        </div>
    </footer>
</body>
</html>
<?php /**PATH D:\01_Projects\SaraHome-Deploy\resources\views/landing.blade.php ENDPATH**/ ?>