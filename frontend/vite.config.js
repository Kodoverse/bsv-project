import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    host: "0.0.0.0",
    port: 5175,
    hmr: {
      host: "192.168.0.115",
      protocol: "http",
      port: 5176,
    },
  },
});
