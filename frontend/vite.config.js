import { join } from "path";

import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import vueJsx from "@vitejs/plugin-vue-jsx";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue(), vueJsx()],
  base:process.env.NODE_ENV==='production'?'/':'/',
  resolve: {
    alias: {
      "@": join(__dirname,"src"),
    },
  },
  devServer: {
    Proxy:'http://localhost:3000'
  }
});
