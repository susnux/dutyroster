/*
* SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
* SPDX-License-Identifier: AGPL-3.0-or-later
*/

// Allow importing vue files
declare module '*.vue' {
	import Vue from 'vue'
	export default Vue
}

declare module '@nextcloud/vue';
declare module 'vue-shortkey';

declare module 'vue-material-design-icons/*.vue' {
	import type { DefineComponent } from 'vue'

	const IconVue : DefineComponent<
		{
			/// `size` defaults to 24
			size: number,
			/// `fillColor` defaults to 'currentColor'
			fillColor: string,
			title?: string,
		}>
	export default IconVue
}

// Declare global variables from webpack define plugin
declare const appName: string
declare const appVersion: string

// Declare webpack
// eslint-disable-next-line camelcase
declare let __webpack_public_path__: string
