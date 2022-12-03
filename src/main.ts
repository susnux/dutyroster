import { generateFilePath } from '@nextcloud/router'
import { translate, translatePlural } from '@nextcloud/l10n'

import Vue from 'vue'
import App from './App.vue'
import router from './router'

// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, '', 'js/')

Vue.mixin({ methods: { t: translate, n: translatePlural } })
Vue.prototype.t = translate
Vue.prototype.n = translatePlural

export default new Vue({
	el: '#content',
	router,
	render: (h) => h(App),
})
