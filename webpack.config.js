// SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
// SPDX-License-Identifier: AGPL-3.0-or-later
// eslint-disable-next-line @typescript-eslint/no-var-requires
const webpackConfig = require('@nextcloud/webpack-vue-config')

// Add TS loader
webpackConfig.module.rules.push({
	test: /\.tsx?$/,
	loader: 'ts-loader',
	exclude: /node_modules/,
	options: {
		// Tell to ts-loader: if you check .vue file extension, handle it like a ts file
		appendTsSuffixTo: [/\.vue$/],
	},
})

// Add `.ts` and `.tsx` as a resolvable extension.
webpackConfig.resolve.extensions.push('.ts', '.tsx')

webpackConfig.resolve.enforceExtension = false

// Add support for TypeScripts fully qualified ESM imports.
webpackConfig.resolve.extensionAlias = {
	'.js': ['.js', '.ts'],
	'.cjs': ['.cjs', '.cts'],
	'.mjs': ['.mjs', '.mts'],
}

module.exports = webpackConfig
