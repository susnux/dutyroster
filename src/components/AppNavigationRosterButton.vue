<!--
	SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
	SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<div class="app-navigation-new">
		<div class="datepicker-button-section">
			<button v-shortkey="previousShortKey"
				:aria-label="previousLabel"
				class="datepicker-button-section__previous button"
				:title="previousLabel"
				type="button"
				@click="navigatePrevious"
				@shortkey="navigatePrevious">
				<ChevronLeftIcon :size="20" />
			</button>
			<button class="datepicker-button-section__datepicker-label button datepicker-label"
				@click.stop.prevent="toggleDatepicker"
				@mousedown.stop.prevent="() => {}"
				@mouseup.stop.prevent="() => {}">
				{{ currentRangeLabel }}
			</button>
			<!--<DatePicker ref="datepicker"
			class="datepicker-button-section__datepicker"
			:date="selectedDate"
			:is-all-day="true"
			:open.sync="isDatepickerOpen"
			@change="navigateToDate" />-->
			<button v-shortkey="nextShortKey"
				:aria-label="nextLabel"
				class="datepicker-button-section__next button"
				:title="nextLabel"
				type="button"
				@click="navigateNext"
				@shortkey="navigateNext">
				<ChevronRightIcon :size="20" />
			</button>
		</div>
	</div>
</template>

<script lang="ts">
import { getCanonicalLocale, getMonthNames, translate as t } from '@nextcloud/l10n'
import { useRoute, useRouter } from 'vue-router/composables'
import { computed, defineComponent } from 'vue'
import { formatDate } from '@fullcalendar/core'

import ChevronLeftIcon from 'vue-material-design-icons/ChevronLeft.vue'
import ChevronRightIcon from 'vue-material-design-icons/ChevronRight.vue'

import { dateString, weekNumber, weeksInYear } from '../utils/date'

export default defineComponent({
	name: 'AppNavigationRosterButton',

	components: {
		ChevronLeftIcon,
		ChevronRightIcon,
	},

	setup() {
		const route = useRoute()
		const router = useRouter()

		const nextLabel = computed(() => {
			switch (route.params?.view) {
			case 'day': return t('dutyroster', 'Next day')
			case 'month': return t('dutyroster', 'Next month')
			case 'week':
			default: return t('dutyroster', 'Next week')
			}
		})

		const previousLabel = computed(() => {
			switch (route.params?.view) {
			case 'day': return t('dutyroster', 'Previous day')
			case 'month': return t('dutyroster', 'Previous month')
			case 'week':
			default: return t('dutyroster', 'Previous week')
			}
		})

		const currentRangeLabel = computed(() => {
			const date = new Date(route.params.initialDate || new Date())
			switch (route.params?.view) {
			case 'day': return formatDate(route.params?.initialDate || new Date(), { locale: getCanonicalLocale() })
			case 'month': return `${getMonthNames()[date.getMonth()]} ${date.getFullYear()}`
			case 'week':
			default: return t('dutyroster', 'Week {week} of {weeks}', {
				week: weekNumber(date)[1],
				weeks: weeksInYear(date.getFullYear()),
			})
			}
		})

		// Short keys from google calendar & nextcloud calendar
		const previousShortKey = {
			prev_p: ['p'],
			prev_k: ['k'],
		}
		const nextShortKey = {
			next_n: ['n'],
			next_j: ['j'],
		}

		/**
		 * Return next date param for current view
		 *
		 * @param next If moving forwards
		 */
		function getDateParam(next: boolean) {
			const date = new Date(route.params.initialDate || new Date())
			const sign = next ? 1 : -1
			switch (route.params.view) {
			case 'day': date.setDate(date.getDate() + 1 * sign); break
			case 'month': date.setMonth(date.getMonth() + 1 * sign); break
			case 'week':
			default: date.setDate(date.getDate() + 7 * sign)
			}
			return dateString(date)
		}

		/**
		 * Navigate to prvious time interval in calendar
		 */
		function navigatePrevious() {
			router.push({
				name: router.currentRoute.name as string,
				hash: router.currentRoute.hash,
				params: { ...router.currentRoute.params, initialDate: getDateParam(false) },
			})
		}

		/**
		 * Navigate to next time interval in calendar
		 */
		function navigateNext() {
			router.push({
				name: router.currentRoute.name as string,
				hash: router.currentRoute.hash,
				params: { ...router.currentRoute.params, initialDate: getDateParam(true) },
			})
		}

		return {
			nextLabel,
			previousLabel,
			navigateNext,
			navigatePrevious,
			nextShortKey,
			previousShortKey,
			currentRangeLabel,
		}
	},
})
</script>

<style lang="scss" scoped>
// Same as `@nextcloud/vue`
.app-navigation-new {
	display: block;
	padding: calc(var(--default-grid-baseline, 4px)*2);
}
</style>

<style lang="scss">
.datepicker-button-section {
	display: flex;

	.button {
		// this border-radius affects the button in the middle of the group
		// for the rounded corner buttons on the sides, see further below
		border-radius: 0;
		font-weight: normal;
		margin: 3px -1px 3px 0;
		flex-grow: 1;
	}

	.button:first-child:not(:only-of-type) {
		border-radius: var(--border-radius-pill) 0 0 var(--border-radius-pill);
	}

	.button:last-child:not(:only-of-type) {
		border-radius: 0 var(--border-radius-pill) var(--border-radius-pill) 0;
	}

	.button:not(:only-of-type):not(:first-child):not(:last-child) {
		border-radius: 0;
	}

	.button:only-child {
		border-radius: var(--border-radius-pill);
	}

	.button:hover,
	.button:focus,
	.button.active {
		z-index: 50;
	}
}
.datepicker-button-section {
	&__datepicker-label {
		flex-grow: 4 !important;
		text-align: center;
	}

	&__datepicker {
		margin-left: 26px;
		margin-top: 48px;
		position: absolute !important;
		width: 0 !important;

		.mx-input-wrapper {
			display: none !important;
		}
	}

	&__previous,
	&__next {
		background-size: 10px;
		flex-grow: 0 !important;
		width: 34px;
		padding: 0 6px !important;
	}
}
</style>
