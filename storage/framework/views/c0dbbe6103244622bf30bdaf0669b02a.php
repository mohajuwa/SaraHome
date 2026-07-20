<?php if(session('status')): ?>
    <div data-toast
        class="fixed bottom-6 left-1/2 z-50 -translate-x-1/2 rounded-full bg-ink px-6 py-3 text-sm font-bold text-white shadow-soft transition-all duration-500">
        <?php echo e(session('status')); ?>

    </div>
<?php endif; ?>
<?php /**PATH D:\01_Projects\SaraHome-Deploy\resources\views/partials/flash.blade.php ENDPATH**/ ?>