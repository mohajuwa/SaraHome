<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="min-h-screen bg-canvas text-ink">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <div class="mb-8"><?php echo $__env->make('partials.brand', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>

        <div class="relative hidden overflow-hidden bg-ink text-white lg:block">
            <div class="absolute inset-0 opacity-95"
                 style="background:radial-gradient(120% 120% at 100% 0%, #C79B6D 0%, #7a5c38 38%, #2C3A5A 100%);"></div>
            <div class="relative flex h-full flex-col justify-between p-12">
                <span class="font-display text-2xl tracking-wide">SARA<span class="text-white/80">HOME</span></span>

                <div class="space-y-6">
                    <div class="flex gap-3">
                        <div class="h-28 w-24 rounded-2xl bg-white/15 backdrop-blur"></div>
                        <div class="mt-8 h-28 w-24 rounded-2xl bg-white/25"></div>
                        <div class="h-28 w-24 rounded-2xl bg-white/10"></div>
                    </div>
                    <h2 class="font-display text-4xl leading-snug">بيتٌ أجمل يبدأ<br>بفكرة ذكية.</h2>
                    <p class="max-w-sm text-white/75">
                        ارفع صورة غرفتك، حدّد ذوقك وميزانيتك، ودع سارا هوم تقترح تصميماً مصمّماً لأجلك — لوحة ألوان وأثاث وخطة إضاءة.
                    </p>
                </div>

                <div class="flex items-center gap-6 text-sm text-white/70">
                    <span>+1,200 عميل</span><span class="h-1 w-1 rounded-full bg-white/40"></span>
                    <span>4.8 ★ متوسط الرضا</span>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH D:\01_Projects\SaraHome-Deploy\resources\views/layouts/guest.blade.php ENDPATH**/ ?>