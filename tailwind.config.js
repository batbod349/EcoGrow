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
            'whiter': 'var(--whiter)',
            'greenDark': 'var(--greenDark)',
            'greenLight': 'var(--greenLight)',
            'greenMint': 'var(--greenMint)',
            'red': 'var(--red)'
        },
        fontFamily: {
            'rawles': "'Rawles', sans-serif",
            'inter': "'Inter', sans-serif",
            'monsterrat': "'Montserrat', sans-serif"
        },
        boxShadow: {
            'custom': '0px 4px 8px 0px rgba(29, 57, 50, 0.70)',
            'customfaible': '0px 2px 4px 0px rgba(29, 57, 50, 0.40)',
          },
        extend: {},
    },
    plugins: [],
}
