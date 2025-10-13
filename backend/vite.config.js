import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), "");

    return {
        server: {
            host: env.VITE_HOST || "0.0.0.0",
            port: Number(env.VITE_PORT) || 5174,
            strictPort: true,
            hmr: {
                host: env.VITE_HMR_HOST || "localhost",
                port: Number(env.VITE_PORT) || 5174,
                protocol: "ws",
            },
        },
        plugins: [
            laravel({
                input: ["resources/css/app.css", "resources/js/app.js"],
                refresh: true,
            }),
        ],
    };
});
