const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: [
          'Cerebri Sans',
          ...defaultTheme.fontFamily.sans,
        ],
      },
      colors: {
        'transparent': 'transparent',

        'black': '#22292f',
        'grey-darkest': '#3d4852',
        'grey-darker': '#606f7b',
        'grey-dark': '#8795a1',
        'grey': '#b8c2cc',
        'grey-light': '#dae1e7',
        'grey-lighter': '#f1f5f8',
        'grey-lightest': '#f8fafc',
        'white': '#ffffff',

        'red-darkest': '#3b0d0c',
        'red-darker': '#621b18',
        'red-dark': '#cc1f1a',
        'red': '#e3342f',
        'red-light': '#ef5753',
        'red-lighter': '#f9acaa',
        'red-lightest': '#fcebea',

        'orange-darkest': '#462a16',
        'orange-darker': '#613b1f',
        'orange-dark': '#de751f',
        'orange': '#f6993f',
        'orange-light': '#faad63',
        'orange-lighter': '#fcd9b6',
        'orange-lightest': '#fff5eb',

        'yellow-darkest': '#453411',
        'yellow-darker': '#684f1d',
        'yellow-dark': '#f2d024',
        'yellow': '#ffed4a',
        'yellow-light': '#fff382',
        'yellow-lighter': '#fff9c2',
        'yellow-lightest': '#fcfbeb',

        'green-darkest': '#0f2f21',
        'green-darker': '#1a4731',
        'green-dark': '#1f9d55',
        'green': '#38c172',
        'green-light': '#51d88a',
        'green-lighter': '#a2f5bf',
        'green-lightest': '#e3fcec',

        'teal-darkest': '#0d3331',
        'teal-darker': '#20504f',
        'teal-dark': '#38a89d',
        'teal': '#4dc0b5',
        'teal-light': '#64d5ca',
        'teal-lighter': '#a0f0ed',
        'teal-lightest': '#e8fffe',

        'blue-darkest': '#12283a',
        'blue-darker': '#1c3d5a',
        'blue-dark': '#2779bd',
        'blue': '#3490dc',
        'blue-light': '#6cb2eb',
        'blue-lighter': '#bcdefa',
        'blue-lightest': '#eff8ff',

        'indigo-darkest': '#191e38',
        'indigo-darker': '#2f365f',
        'indigo-dark': '#5661b3',
        'indigo': '#6574cd',
        'indigo-light': '#7886d7',
        'indigo-lighter': '#b2b7ff',
        'indigo-lightest': '#e6e8ff',

        'purple-darkest': '#21183c',
        'purple-darker': '#382b5f',
        'purple-dark': '#794acf',
        'purple': '#9561e2',
        'purple-light': '#a779e9',
        'purple-lighter': '#d6bbfc',
        'purple-lightest': '#f3ebff',

        'pink-darkest': '#451225',
        'pink-darker': '#6f213f',
        'pink-dark': '#eb5286',
        'pink': '#f66d9b',
        'pink-light': '#fa7ea8',
        'pink-lighter': '#ffbbca',
        'pink-lightest': '#ffebef',
      },
      boxShadow: theme => ({
        'outline': '0 0 0 2px ' + theme('colors.indigo'),
      }),
      fill: theme => theme('colors'),
    },
  },
  variants: {
    fill: ['responsive', 'hover', 'focus', 'group-hover'],
    textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    zIndex: ['responsive', 'focus'],
  },
  plugins: [],
}