<?php

use App\Models\Profile;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('sitemap:generate', function () {
    $this->info('Starting sitemap generation...');

    $sitemap = Sitemap::create();

    // Static pages using named routes
    $sitemap->add(Url::create(route('welcome')));
    $sitemap->add(Url::create(route('features')));
    $sitemap->add(Url::create(route('register')));
    $sitemap->add(Url::create(route('login')));
    $sitemap->add(Url::create(route('my-profile')));
    $sitemap->add(Url::create(route('events-finder')));
    $sitemap->add(Url::create(route('progress-tracker')));
    $sitemap->add(Url::create(route('timetable-builder')));
    $sitemap->add(Url::create(route('study-partners-suggester.suggester-form')));
    $sitemap->add(Url::create(route('clubs-finder')));

    // route name('view-user-profile')
    $specificProfileIds = [1, 20, 19, 24, 25];
    $profiles = Profile::whereIn('profile_id', $specificProfileIds)->get();
    foreach ($profiles as $profile) {
        $sitemap->add(Url::create(route('view-user-profile', ['profile_id' => $profile->profile_id])));
    }

    // Save to file
    $sitemap->writeToFile(public_path('sitemap.xml'));

    $this->info('Sitemap generated successfully');
});
