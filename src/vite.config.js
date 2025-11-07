import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    
    
    server: {
        host: '0.0.0.0', 
        port: 5173,      
        
        hmr: {
            host: 'http://164.92.249.94/',
            clientPort: 5173,
            protocol: 'ws',
        },
        
        // Optional: Explicitly allow the host application URL for development safety
        cors: {
            origin: [
                'http://164.92.249.94:9002', // Your public IP and application port
                'http://localhost:9002',       // Localhost for testing
            ],
            methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
            credentials: true,
        },
    },
});