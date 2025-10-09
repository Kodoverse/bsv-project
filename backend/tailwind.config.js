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
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, flowbitePlugin],
};
