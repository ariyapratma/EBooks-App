// vite.config.js
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/pdf-viewer.js"],
            refresh: true,
        }),
    ],
});
