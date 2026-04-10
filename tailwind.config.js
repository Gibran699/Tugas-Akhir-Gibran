/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './public/js/**/*.js',
    ],
    corePlugins: {
        // Disable Preflight (CSS reset) to avoid conflicts with Bootstrap
        preflight: false,
    },
    theme: {
        extend: {},
    },
    plugins: [],
}
