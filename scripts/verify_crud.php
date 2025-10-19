#!/usr/bin/env php
<?php

// Small verification script to run locally after migrating the database.
// Usage:
// 1) Ensure DB is running and .env is configured
// 2) php artisan migrate
// 3) php scripts/verify_crud.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Wilayah;
use App\Models\Destinasi;
use App\Models\FotoDestinasi;
use App\Models\Akomodasi;
use App\Models\Transportasi;

echo "Starting CRUD verification...\n";

try {
    $w = Wilayah::create(['nama' => 'TEST Wilayah ' . time(), 'slug' => 'test-wilayah-' . time(), 'deskripsi' => 'Auto-created for verification']);
    echo "Created Wilayah id={$w->id}\n";

    $d = Destinasi::create(['nama' => 'TEST Destinasi ' . time(), 'id_wilayah' => $w->id, 'deskripsi' => 'Auto dest for verification']);
    echo "Created Destinasi id={$d->id}\n";

    // create a foto record (no actual file required)
    $foto = FotoDestinasi::create(['id_destinasi' => $d->id, 'url' => 'test-placeholder.jpg', 'keterangan' => 'placeholder', 'apakah_slider_utama' => true]);
    echo "Created FotoDestinasi id={$foto->id} for Destinasi id={$d->id}\n";

    $a = Akomodasi::create(['nama' => 'TEST Akomodasi ' . time(), 'tipe' => 'Hotel', 'lokasi' => 'Test Location']);
    echo "Created Akomodasi id={$a->id}\n";

    $t = Transportasi::create(['nama' => 'TEST Transportasi ' . time(), 'tipe' => 'Bus', 'rute' => 'Demo route']);
    echo "Created Transportasi id={$t->id}\n";

    // Verify reads
    $w2 = Wilayah::find($w->id);
    $d2 = Destinasi::with('foto')->find($d->id);
    $a2 = Akomodasi::find($a->id);
    $t2 = Transportasi::find($t->id);

    echo "Read back: Wilayah={$w2->nama}, Destinasi={$d2->nama}, Fotos={$d2->foto->count()}, Akomodasi={$a2->nama}, Transportasi={$t2->nama}\n";

    echo "CRUD verification complete. Please remove these test records if desired.\n";
} catch (Exception $e) {
    echo "ERROR during verification: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
