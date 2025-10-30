import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import flowbitePlugin from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    safelist: [
        "bg-yellow-500/20",
        "text-yellow-400",
        "border-yellow-500/30",
        "bg-blue-500/20",
        "text-blue-400",
        "border-blue-500/30",
        "bg-green-500/20",
        "text-green-400",
        "border-green-500/30",
        "bg-red-500/20",
        "text-red-400",
        "border-red-500/30",
        "bg-gray-500/20",
        "text-gray-400",
        "border-gray-500/30",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", "sans-serif"],
            },
            colors: {
                background: "hsl(var(--color-background))",
                sidebar: "hsl(var(--color-sidebar))",
                surface: "hsl(var(--color-surface))",
                foreground: "hsl(var(--color-foreground))",
                muted: "hsl(var(--color-muted))",
                "accent-red": "hsl(var(--color-accent-red))",
                "accent-orange": "hsl(var(--color-accent-orange))",
                "accent-yellow": "hsl(var(--color-accent-yellow))",
            },
            boxShadow: {
                "card-light": "0 2px 6px rgba(0,0,0,0.08)",
                "btn-light": "0 4px 10px rgba(0,0,0,0.12)",
                "modal-light": "0 8px 20px rgba(0,0,0,0.2)",
                "card-dark": "0 2px 6px rgba(255,255,255,0.05)",
                "btn-dark-red": "0 0 10px rgba(228,84,75,0.25)",
                "btn-dark-orange": "0 0 10px rgba(242,133,93,0.25)",
                "btn-dark-yellow": "0 0 10px rgba(243,193,74,0.25)",
                "modal-dark": "0 8px 24px rgba(0,0,0,0.6)",
            },
            darkMode: "class",
        },
    },
    plugins: [forms, flowbitePlugin],
};
