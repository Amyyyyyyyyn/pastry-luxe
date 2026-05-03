<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('pastry:publish-brand-logo', function (): int {
    $sources = [
        storage_path('app/brand-logo.png'),
        base_path('brand-logo.png'),
    ];
    foreach ($sources as $src) {
        if (! is_file($src) || filesize($src) === 0) {
            continue;
        }
        foreach (['brand-logo.png', 'favicon.png'] as $name) {
            copy($src, public_path($name));
        }
        $this->info('Published '.basename($src).' → public/brand-logo.png and public/favicon.png');

        return 0;
    }
    $this->error('No logo found. Save your PNG as storage/app/brand-logo.png (or brand-logo.png in the project root), then run this command again.');
    $this->line('Tip: You can drag your logo file into Cursor under storage/app/ without using the terminal.');

    return 1;
})->purpose('Copy brand logo PNG into public/ for favicon + home hero (every browser tab)');
