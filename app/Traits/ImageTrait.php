<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageTrait
{
    /**
     * رفع صورة جديدة وترجع المسار عشان تتخزن في الداتابيز
     */
    public function uploadImage(UploadedFile $image, string $folder = 'images'): string
    {
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

        $path = $image->storeAs($folder, $filename, 'public');

        return $path;
    }

    /**
     * حذف صورة من التخزين باستخدام المسار المخزن في الداتابيز
     */
    public function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * تحديث صورة: حذف القديمة (لو موجودة) ورفع الجديدة
     */
    public function updateImage(UploadedFile $newImage, ?string $oldPath, string $folder = 'images'): string
    {
        $this->deleteImage($oldPath);

        return $this->uploadImage($newImage, $folder);
    }

    /**
     * ترجع الرابط الكامل للصورة عشان تتعرض
     */
    public function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return asset('storage/' . $path);
    }
}
