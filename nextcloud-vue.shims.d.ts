// Allow importing vue files
declare module '*.vue' {
	import Vue from 'vue'
	export default Vue
}

declare module '@nextcloud/vue';
declare module 'vue-shortkey';

// Declare global variables from webpack define plugin
declare const appName: string
declare const appVersion: string

// Declare webpack
// eslint-disable-next-line camelcase
declare let __webpack_public_path__: string
