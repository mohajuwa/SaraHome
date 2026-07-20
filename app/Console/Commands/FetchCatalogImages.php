<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Downloads externally-hosted catalog images into public/images/catalog/
 * and rewrites each product to use the local copy.
 *
 * Run once after importing a supplier catalog:
 *   php artisan catalog:fetch-images
 */
class FetchCatalogImages extends Command
{
    protected $signature = 'catalog:fetch-images';

    protected $description = 'Download remote catalog images locally and update product paths';

    public function handle(): int
    {
        $dir = public_path('images/catalog');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $products = Product::where('image_path', 'like', 'http%')->get();

        if ($products->isEmpty()) {
            $this->info('لا توجد صور خارجية — كل الصور محليّة بالفعل.');

            return self::SUCCESS;
        }

        $this->info("تنزيل {$products->count()} صورة ...");
        $ok = 0;
        $failed = 0;

        foreach ($products as $product) {
            $url = $product->image_path;
            $name = basename(parse_url($url, PHP_URL_PATH));
            $target = $dir.DIRECTORY_SEPARATOR.$name;

            try {
                if (! file_exists($target)) {
                    $res = Http::timeout(25)->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (compatible; SaraHome/1.0)',
                    ])->get($url);

                    if (! $res->successful() || strlen($res->body()) < 500) {
                        throw new \RuntimeException('HTTP '.$res->status());
                    }

                    file_put_contents($target, $res->body());
                }

                $product->update(['image_path' => 'catalog/'.$name]);
                $this->line("  ✓ {$product->name}");
                $ok++;
            } catch (\Throwable $e) {
                $this->warn("  ✗ {$product->name} — {$e->getMessage()}");
                $failed++;
            }
        }

        $this->newLine();
        $this->info("تم: {$ok} ناجحة، {$failed} فاشلة.");

        return self::SUCCESS;
    }
}
