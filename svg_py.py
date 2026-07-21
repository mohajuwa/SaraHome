import cv2
import numpy as np

# إضافة حرف r قبل مسار الويندوز يحل مشكلة الـ SyntaxWarning
img_path = r'D:\01_Projects\SaraHome-Deploy\public\images\logo.jpeg'
img = cv2.imread(img_path)

if img is None:
    print(f"عذراً، لم يتم العثور على الصورة في المسار المحدد: {img_path}")
else:
    # 1. معالجة وتفريغ الخلفية الكريمة لتصبح شفافة
    h, w = img.shape[:2]
    mask = np.zeros((h + 2, w + 2), np.uint8)
    img_flood = img.copy()

    # تفريغ ألوان الخلفية المتقاربة من الزاوية
    cv2.floodFill(img_flood, mask, (0, 0), (0, 0, 0), (18, 18, 18), (18, 18, 18), cv2.FLOODFILL_FIXED_RANGE)
    bg_mask = (img_flood[:, :, 0] == 0) & (img_flood[:, :, 1] == 0) & (img_flood[:, :, 2] == 0)

    # تحويل الصورة إلى BGRA (قناة شفافية Alpha)
    rgba = cv2.cvtColor(img, cv2.COLOR_BGR2BGRA)
    rgba[bg_mask, 3] = 0  # جعل الخلفية شفافة

    # 2. حفظ النسخة الكاملة المفرغة logo-full.png
    cv2.imwrite(r'D:\01_Projects\SaraHome-Deploy\public\images\logo-full.png', rgba)

    # 3. قص الشعار الصافي (الرمز العلوي فقط) وحفظ logo-emblem.png
    # الأبعاد محسوبة بدقة حسب حجم صورتك
    y1, y2 = int(h * 0.12), int(h * 0.62)
    x1, x2 = int(w * 0.20), int(w * 0.80)
    emblem = rgba[y1:y2, x1:x2]

    cv2.imwrite(r'D:\01_Projects\SaraHome-Deploy\public\images\logo-emblem.png', emblem)

    print("تم استخراج الصور المفرغة الصافية (logo-full.png و logo-emblem.png) بنجاح!")