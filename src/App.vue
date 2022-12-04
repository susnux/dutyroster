<template>
	<!--
		SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
		SPDX-License-Identifier: AGPL-3.0-or-later
	-->
	<NcContent app-name="dutyroster">
		<NcAppNavigation>
			<NcAppNavigationNew v-if="$route.name !== 'roster'"
				:text="t('dutyroster', 'View duty roster')"
				@click="goRoster" />
			<AppNavigationRosterButton v-else />
			<NcAppNavigationNew :text="t('dutyroster', 'Your shifts')"
				:disabled="$route.name === 'shifts'"
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
import { defineComponent } from 'vue'
import AppNavigationRosterButton from './components/AppNavigationRosterButton.vue'

import '@nextcloud/dialogs/dist/index.css'

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
		/**
		 * Navigate to the "my shifts" view
		 */
		function goShifts() {
			this.$router.push({ name: 'shifts' })
		}

		/**
		 * Navigate to the roster view
		 */
		function goRoster() {
			this.$router.push({ name: 'roster' })
		}

		return {
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
