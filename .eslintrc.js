// SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
// SPDX-License-Identifier: AGPL-3.0-or-later
module.exports = {
	extends: ['@nextcloud', 'plugin:@typescript-eslint/recommended'],

	parser: 'vue-eslint-parser',
	parserOptions: {
		parser: '@typescript-eslint/parser',
	},

	plugins: ['@typescript-eslint'],

	rules: {
		'import/extensions': [
			'error',
			'ignorePackages',
			{
				ts: 'never',
				tsx: 'never',
			},
		],
		// Does not work with typescript
		'n/no-missing-import': 'off',
	},
	settings: {
		'import/resolver': {
			typescript: {}, // this loads <rootdir>/tsconfig.json to eslint
		},
	},
	root: true,
}
