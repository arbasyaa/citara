import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',     // public site
        'resources/css/auth.css',    // auth/panel login layout
        'resources/js/app.js',       // public site
        'resources/js/admin.js',     // panel sidebar toggle, etc.
      ],
      refresh: true,
    }),
  ],
});