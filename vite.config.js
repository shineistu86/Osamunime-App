import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['import', 'global-builtin', 'color-functions', 'if-function']
            }
        }
    },
    // Production build configuration
    build: {
        manifest: true,
        rollupOptions: {
            output: {
                // Use absolute paths for assets in production
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'css/[name].[hash][extname]';
                    }
                    if (assetInfo.name.endsWith('.js')) {
                        return 'js/[name].[hash][extname]';
                    }
                    return 'assets/[name].[hash][extname]';
                }
            }
        }
    },
    // Base URL for assets (important for production deployments)
    base: process.env.APP_URL ? `${process.env.APP_URL}/` : '/',
});
