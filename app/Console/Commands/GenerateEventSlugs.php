<?php

namespace App\Console\Commands;

use App\Models\CalendarEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateEventSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for calendar events that do not have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating slugs for calendar events...');

        $events = CalendarEvent::whereNull('slug')->orWhere('slug', '')->get();

        if ($events->isEmpty()) {
            $this->info('All events already have slugs!');
            return 0;
        }

        $bar = $this->output->createProgressBar($events->count());
        $bar->start();

        foreach ($events as $event) {
            $slug = Str::slug($event->title);
            $originalSlug = $slug;
            $count = 1;

            // Ensure unique slug
            while (CalendarEvent::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $event->slug = $slug;
            $event->save();

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Successfully generated slugs for {$events->count()} events!");

        return 0;
    }
}
