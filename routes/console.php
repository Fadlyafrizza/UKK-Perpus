<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('library:check-overdue', function () {
    $this->info('Checking overdue books...');
})->describe('Check overdue books and create fines')
  ->daily();
