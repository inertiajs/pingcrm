module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: ['eslint:recommended', 'plugin:vue/vue3-essential'],
  overrides: [
    {
      env: {
        node: true,
      },
      files: ['.eslintrc.{js,cjs}'],
      parserOptions: {
        sourceType: 'script',
      },
    },
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: ['vue'],
  rules: {
    indent: ['error', 2],
    quotes: ['warn', 'single'],
    semi: ['warn', 'never'],
    'no-unused-vars': ['error', { vars: 'all', args: 'after-used', ignoreRestSiblings: true }],
    'comma-dangle': ['warn', 'always-multiline'],
    'vue/multi-word-component-names': 'off',
    'vue/max-attributes-per-line': 'off',
    'vue/no-v-html': 'off',
    'vue/require-default-prop': 'off',
    'vue/singleline-html-element-content-newline': 'off',
    'vue/html-self-closing': [
      'warn',
      {
        html: {
          void: 'always',
          normal: 'always',
          component: 'always',
        },
      },
    ],
  },
}
