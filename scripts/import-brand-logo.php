<?php

/**
 * Copy your Caramella logo into public/ for tab icon + home hero.
 *
 * Usage (from project root): php scripts/import-brand-logo.php
 *
 * Looks for (first hit wins):
 * - storage/app/brand-logo.png
 * - brand-logo.png at project root
 * - latest Cursor workspace asset matching image-*.png under your user .cursor folder (optional dev path)
 */
declare(strict_types=1);

$root = dirname(__DIR__);

$sources = [
    $root.'/storage/app/brand-logo.png',
    $root.'/brand-logo.png',
];

$home = getenv('USERPROFILE') ?: getenv('HOME');
if (is_string($home) && $home !== '') {
    $assetsDir = $home.'/.cursor/projects/c-Users-dhaou-OneDrive-Ministere-de-l-Enseignement-Superieur-et-de-la-Recherche-Scientifique-Desktop-PROJECTS-pastry-luxe/assets';
    if (is_dir($assetsDir)) {
        $pngs = glob($assetsDir.'/*image-*.png') ?: [];
        rsort($pngs);
        foreach ($pngs as $p) {
            $sources[] = $p;
            break;
        }
    }
}

foreach ($sources as $src) {
    if (is_file($src) && filesize($src) > 0) {
        if (! is_dir($root.'/public')) {
            mkdir($root.'/public', 0755, true);
        }
        copy($src, $root.'/public/brand-logo.png');
        copy($src, $root.'/public/favicon.png');
        fwrite(STDOUT, "Copied to public/brand-logo.png and public/favicon.png from:\n{$src}\n");

        exit(0);
    }
}

fwrite(STDERR, "No PNG found. Save your logo as storage/app/brand-logo.png then run again, or run: php artisan pastry:publish-brand-logo\n");
exit(1);
