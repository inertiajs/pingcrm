module.exports = {
  extends: [
    'eslint:recommended',
    'plugin:vue/recommended',
  ],
  rules: {
    "indent": ['error', 2],
    'quotes': ['warn', 'single'],
    'semi': ['warn', 'never'],
    'comma-dangle': ['warn', 'always-multiline'],
    'vue/max-attributes-per-line': false,
    'vue/require-default-prop': false,
    'vue/singleline-html-element-content-newline': false,
  }
}
