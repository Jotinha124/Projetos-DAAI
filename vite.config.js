import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    build: {
        manifest: "manifest.json",
        rtl: true,
        outDir: "public/build",
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                assetFileNames: (css) => {
                    if (css.name.split(".").pop() == "css") {
                        return "css/" + `[name]` + ".min." + "css";
                    } else {
                        return "icons/" + css.name;
                    }
                },
                entryFileNames: "js/" + `[name]` + `.js`,
            },
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: "resources/imagens",
                    dest: "",
                },
                {
                    src: "resources/js",
                    dest: "",
                },
                {
                    src: "resources/css",
                    dest: "",
                },
                {
                    src: "resources/sass",
                    dest: "",
                },
            ],
        }),
    ],
});
