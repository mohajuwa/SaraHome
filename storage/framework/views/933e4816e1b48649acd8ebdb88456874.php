<?php $__env->startSection('title', 'إنشاء حساب'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="font-display text-3xl text-ink">أنشئ حسابك</h1>
    <p class="mt-2 text-muted">ابدأ رحلتك مع سارا هوم خلال دقيقة.</p>

    <form method="POST" action="<?php echo e(route('register.store')); ?>" class="mt-8 space-y-5">
        <?php echo csrf_field(); ?>
        <div>
            <label class="mb-1.5 block text-sm font-bold">الاسم</label>
            <input name="name" value="<?php echo e(old('name')); ?>" required autofocus class="field" placeholder="سارة أحمد">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs font-bold text-clay"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-bold">البريد الإلكتروني</label>
            <input name="email" type="email" value="<?php echo e(old('email')); ?>" required class="field" placeholder="you@email.com">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs font-bold text-clay"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="mb-1.5 block text-sm font-bold">كلمة المرور</label>
                <input name="password" type="password" required class="field" placeholder="••••••••">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs font-bold text-clay"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-bold">تأكيد كلمة المرور</label>
                <input name="password_confirmation" type="password" required class="field" placeholder="••••••••">
            </div>
        </div>
        <button class="btn-primary w-full">إنشاء الحساب</button>
    </form>

    <p class="mt-6 text-center text-sm text-muted">
        لديك حساب بالفعل؟ <a href="<?php echo e(route('login')); ?>" class="font-bold text-clay">سجّل الدخول</a>
    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\01_Projects\SaraHome-Deploy\resources\views/auth/register.blade.php ENDPATH**/ ?>