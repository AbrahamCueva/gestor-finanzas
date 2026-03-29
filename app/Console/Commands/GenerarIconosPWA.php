<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class GenerarIconosPWA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generar-iconos-p-w-a';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera los iconos PWA desde el logo de Settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!extension_loaded('gd')) {
            $this->error('La extensión GD de PHP no está instalada.');
            return;
        }

        $settings = Setting::first();
        $logoPath = null;

        if ($settings?->logo_dark) {
            $path = storage_path('app/public/' . $settings->logo_dark);
            if (file_exists($path)) $logoPath = $path;
        }

        if (!$logoPath) {
            $this->warn('No hay logo configurado. Generando iconos con texto RICOX...');
            $logoPath = null;
        }

        $sizes = [72, 96, 128, 144, 152, 192, 384, 512];
        $dir   = public_path('icons');

        if (!is_dir($dir)) mkdir($dir, 0755, true);

        foreach ($sizes as $size) {
            $img = imagecreatetruecolor($size, $size);

            $bg   = imagecolorallocate($img, 15, 23, 42);    // #0f172a
            $gold = imagecolorallocate($img, 251, 191, 36);  // #fbbf24
            imagefill($img, 0, 0, $bg);

            $radio = (int)($size * 0.42);
            $cx    = (int)($size / 2);
            $cy    = (int)($size / 2);
            imagefilledellipse($img, $cx, $cy, $radio * 2, $radio * 2, $gold);

            $text     = 'R';
            $fontSize = (int)($size * 0.35);
            $textColor = imagecolorallocate($img, 15, 23, 42);

            $fontW = imagefontwidth(5) * strlen($text);
            $fontH = imagefontheight(5);
            imagestring($img, 5,
                (int)(($size - $fontW * ($fontSize / 10)) / 2),
                (int)(($size - $fontH * ($fontSize / 10)) / 2),
                $text, $textColor
            );

            $output = "{$dir}/icon-{$size}.png";
            imagepng($img, $output);
            imagedestroy($img);

            $this->info("✅ Generado: icon-{$size}.png");
        }

        $this->info('🎉 Iconos PWA generados en public/icons/');
    }
}
