<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImagePlaceholderSeeder extends Seeder
{
    public function run(): void
    {
        // 1x1 px JPEG (white) placeholder
        $jpegBase64 = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxAQEBAQEA8QDw8QDw8PDw8PDw8QEA8PFREWFhURFhUYHSggGBolGxUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGxAQGy0lICUtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAAEAAQMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABQYBBAIDB//EADYQAAIBAwMBBgQEBwAAAAAAAAECAwAEEQUSITFBBhMiUWEUMnGBkbEjQlJiobHR8PH/xAAXAQEBAQEAAAAAAAAAAAAAAAAAAQID/8QAHBEBAQADAQEBAAAAAAAAAAAAAAERAhIhMUFR/9oADAMBAAIRAxEAPwD2qioqqqqqqqqqrh0l7z6Gv1Q6r2k4cQe9a6P2f4f3G5jQb9gM7mPZzS9m7pQmY2zQ6tQ2oS3QpX6bT2I8eTjQv9zM3mVxk4y6o4n1d2rQkqKcQ3KcQ4mIQj7vV7mKp5Qe8x4yYw8q9E3m9m3mM6qQqkJQhSgQkY3h7a6q+qVVVVI4I3h/wC1oqqqqqqqqqqqv/Z';
        $jpegData = base64_decode($jpegBase64);

        // Ensure base folder exists
        if (! Storage::disk('public')->exists('destinasi')) {
            Storage::disk('public')->makeDirectory('destinasi');
        }

        // Seed placeholders for missing FotoDestinasi files
        if (\Illuminate\Support\Facades\Schema::hasTable('foto_destinasi')) {
            $records = \App\Models\FotoDestinasi::query()->select('url')->get();
            foreach ($records as $rec) {
                $path = ltrim((string) $rec->url, '/');
                if ($path === '') {
                    continue;
                }
                if (! Storage::disk('public')->exists($path)) {
                    // Ensure nested directory exists
                    $dir = dirname($path);
                    if ($dir !== '.' && ! Storage::disk('public')->exists($dir)) {
                        Storage::disk('public')->makeDirectory($dir);
                    }
                    Storage::disk('public')->put($path, $jpegData);
                }
            }
        }
    }
}
