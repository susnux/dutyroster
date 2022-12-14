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
		</NcAppNavigation>
		<NcAppContent>
			<router-view />
		</NcAppContent>
	</NcContent>
</template>

<script lang="ts">
import {
	NcAppContent,
	NcAppNavigation,
	NcAppNavigationNew,
	NcContent,
} from '@nextcloud/vue'
import { computed, defineComponent } from 'vue'
import AppNavigationRosterButton from './components/AppNavigationRosterButton.vue'

import '@nextcloud/dialogs/dist/index.css'
import { useRoute, useRouter } from 'vue-router/composables'

export default defineComponent({
	name: 'App',
	components: {
		AppNavigationRosterButton,
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

textarea {
	flex-grow: 1;
	width: 100%;
}
</style>
