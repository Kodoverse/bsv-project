import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import flowbitePlugin from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", "sans-serif"],
            },
            colors: {
                brand: {
                    red: "#E4544B",
                    orange: "#F2855D",
                    yellow: "#F3C14A",
                },
                light: {
                    bg: "#FFFFFF",
                    card: "#F9FAFB",
                    text: "#111827",
                    textSecondary: "#4B5563",
                },
                dark: {
                    bg: "#111827",
                    card: "#1F2937",
                    text: "#F9FAFB",
                    textSecondary: "#D1D5DB",
                },
            },
            boxShadow: {
                // Light
                "card-light": "0 2px 6px rgba(0,0,0,0.08)",
                "btn-light": "0 4px 10px rgba(0,0,0,0.12)",
                "modal-light": "0 8px 20px rgba(0,0,0,0.2)",

                // Dark
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
