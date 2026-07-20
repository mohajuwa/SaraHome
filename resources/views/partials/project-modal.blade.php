<div id="project-modal" data-modal
     class="fixed inset-0 z-50 hidden items-center justify-center bg-ink/40 p-4 backdrop-blur-sm">
    <form method="POST" action="{{ route('client.projects.store') }}" enctype="multipart/form-data"
          class="w-full max-w-lg rounded-3xl bg-canvas p-6 shadow-soft">
        @csrf
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold tracking-wider text-clay">مشروع جديد</p>
                <h2 class="mt-1 font-display text-2xl text-ink">لنبدأ بتصميم مساحتك</h2>
            </div>
            <button type="button" data-modal-close class="text-2xl leading-none text-muted hover:text-clay">×</button>
        </div>

        <label class="mt-5 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-line bg-white py-7 text-center text-muted transition hover:border-clay/50">
            @include('partials.icon', ['name' => 'image', 'class' => 'h-7 w-7 text-clay'])
            <span class="text-sm font-bold text-ink">ارفعي صورة الغرفة</span>
            <span class="text-xs">JPG أو PNG — صورة واضحة للمكان</span>
            <input name="image" type="file" accept="image/*" class="hidden">
        </label>

        <div class="mt-4 space-y-3">
            <div>
                <label class="mb-1 block text-sm font-bold">اسم المشروع</label>
                <input name="name" required maxlength="60" class="field" placeholder="مثال: ركن الراحة">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="mb-1 block text-sm font-bold">نوع الغرفة</label>
                    <select name="room_type" class="field">
                        <option>غرفة المعيشة</option><option>غرفة النوم</option>
                        <option>مكتب منزلي</option><option>غرفة طعام</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-bold">أسلوب التصميم</label>
                    <select name="style" class="field">
                        <option>مودرن دافئ</option><option>سكندنافي</option>
                        <option>بسيط</option><option>كلاسيكي</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="mb-1 block text-sm font-bold">الميزانية</label>
                <select name="budget" class="field">
                    <option>أقل من 5,000 ريال</option>
                    <option>5,000 - 10,000 ريال</option>
                    <option>10,000 - 20,000 ريال</option>
                    <option>أكثر من 10,000 ريال</option>
                </select>
            </div>
        </div>

        <button class="btn-primary mt-5 w-full" data-busy-text="جارٍ الحفظ…">حفظ الطلب وبدء التصميم</button>
    </form>
</div>
