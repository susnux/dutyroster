<!--
	SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
	SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<!-- hack for vue2 as it does not support fragments, with vue3 the outer span cen be removed-->
	<span>
		<NcAppNavigationItem :title="t('dutyroster', 'Show today')"
			@click="gotoToday">
			<template #icon>
				<IconCalendarToday :size="20" />
			</template>
		</NcAppNavigationItem>
		<NcAppNavigationItem :title="t('dutyroster', 'Calendar view mode')"
			:menu-open.sync="viewSelectorOpen"
			:force-display-actions="true"
			@click="viewSelectorOpen = !viewSelectorOpen">
			<template #icon>
				<IconDay v-if="activeView === 'day'" />
				<IconWeek v-else-if="activeView === 'week'" />
				<IconMonth v-else />
			</template>
			<template #actions>
				<NcActionButton close-after-click
					:disabled="activeView === 'day'"
					@click="toggleView('day')">
					<template #icon>
						<IconDay />
					</template>
					{{ t('dutyroster', 'Day') }}
				</NcActionButton>
				<NcActionButton close-after-click
					:disabled="activeView === 'week'"
					@click="toggleView('week')">
					<template #icon>
						<IconWeek />
					</template>
					{{ t('dutyroster', 'Week') }}
				</NcActionButton>
				<NcActionButton close-after-click
					:disabled="activeView === 'month'"
					@click="toggleView('month')">
					<template #icon>
						<IconMonth />
					</template>
					{{ t('dutyroster', 'Month') }}
				</NcActionButton>
			</template>
		</NcAppNavigationItem>
	</span>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from 'vue'
import { NcActionButton, NcAppNavigationItem } from '@nextcloud/vue'
import { useRoute, useRouter } from 'vue-router/composables'

import IconDay from 'vue-material-design-icons/ViewDay.vue'
import IconWeek from 'vue-material-design-icons/ViewWeek.vue'
import IconMonth from 'vue-material-design-icons/CalendarMonth.vue'
import IconCalendarToday from 'vue-material-design-icons/CalendarToday.vue'
import { dateString } from '../utils/date'

export default defineComponent({
	name: 'NavigationRoster',
	components: {
		IconDay,
		IconWeek,
		IconMonth,
		IconCalendarToday,
		NcActionButton,
		NcAppNavigationItem,
	},
	setup() {
		const router = useRouter()
		const route = useRoute()

		const activeView = computed(() => route.params.view as string)
		const viewSelectorOpen = ref(false)

		const toggleView = (view: 'day'|'week'|'month') => {
			const current = Object.assign({}, router.currentRoute)
			if (current.name === 'roster' && current.params.view !== view) {
				router.push({
					name: current.name,
					hash: current.hash,
					params: { ...current.params, view },
				})
			}
		}

		const gotoToday = () => {
			const current = Object.assign({}, router.currentRoute)
			const initialDate = dateString()
			if (current.name === 'roster' && current.params.initialDate !== initialDate) {
				router.push({
					name: current.name,
					hash: current.hash,
					params: { ...current.params, initialDate },
				})
			}
		}

		return {
			activeView,
			toggleView,
			gotoToday,
			viewSelectorOpen,
		}
	},
})
</script>
