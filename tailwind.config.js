/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        colors: {
            'black': 'var(--black)',
            'white': 'var(--white)',
            'greenDark': 'var(--greenDark)',
            'greenLight': 'var(--greenLight)',
            'greenMint': 'var(--greenMint)',
            'red': 'var(--red)'
        },
        extend: {},
    },
    plugins: [],
}
