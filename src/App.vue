<template>
	<!--
		SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
		SPDX-License-Identifier: AGPL-3.0-or-later
	-->
	<NcContent app-name="dutyroster">
		<NcAppNavigation>
			<NcAppNavigationNew v-if="routeName !== 'roster'"
				:text="t('dutyroster', 'View duty roster')"
				@click="goRoster" />
			<AppNavigationRosterButton v-else />
			<NcAppNavigationNew :text="t('dutyroster', 'Your shifts')"
				:disabled="routeName === 'shifts'"
				@click="goShifts" />
			<NcActionSeparator />
			<NavigationRoster v-if="routeName === 'roster'" />
			<!--<NavigationShifts />-->
		</NcAppNavigation>
		<NcAppContent>
			<router-view />
		</NcAppContent>
	</NcContent>
</template>

<script lang="ts">
import {
	NcActionSeparator,
	NcAppContent,
	NcAppNavigation,
	NcAppNavigationNew,
	NcContent,
} from '@nextcloud/vue'
import { computed, defineComponent } from 'vue'
import { useRoute, useRouter } from 'vue-router/composables'
import AppNavigationRosterButton from './components/AppNavigationRosterButton.vue'
import NavigationRoster from './components/NavigationRoster.vue'

import '@nextcloud/dialogs/dist/index.css'

export default defineComponent({
	name: 'App',
	components: {
		AppNavigationRosterButton,
		NavigationRoster,
		NcActionSeparator,
		NcAppContent,
		NcAppNavigation,
		NcAppNavigationNew,
		NcContent,
	},

	setup() {
		const router = useRouter()
		const route = useRoute()

		const routeName = computed(() => route.name)

		/**
		 * Navigate to the "my shifts" view
		 */
		function goShifts() {
			router.push({ name: 'shifts' })
		}

		/**
		 * Navigate to the roster view
		 */
		function goRoster() {
			router.push({ name: 'roster', params: { view: 'week' } })
		}

		return {
			routeName,
			goRoster,
			goShifts,
		}
	},
})
</script>

<style scoped>
#app-content > div {
	width: 100%;
	height: 100%;
	padding: 20px;
	display: flex;
	flex-direction: column;
	flex-grow: 1;
}

.app-navigation .action {
	list-style-type: none;
}

textarea {
	flex-grow: 1;
	width: 100%;
}
</style>
