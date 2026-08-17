import js from '@eslint/js'
import vuePlugin from 'eslint-plugin-vue'
import globals from 'globals'

export default [
    js.configs.recommended,
    ...vuePlugin.configs['flat/recommended'],
    {
        languageOptions: {
            globals: {
                ...globals.browser,
            }
        },
        rules: {
            'no-unused-vars': 'error',
            'no-console': 'warn',
            'eqeqeq': 'error',
        }
    }
]
