<template>
	<div class="datepicker-button-section">
		<button v-shortkey="previousShortKeyConf"
			:aria-label="previousLabel"
			class="datepicker-button-section__previous button"
			:title="previousLabel"
			type="button"
			@click="navigateToPreviousTimeRange"
			@shortkey="navigateToPreviousTimeRange">
			<ChevronLeftIcon :size="22" />
		</button>
		<button class="datepicker-button-section__datepicker-label button datepicker-label"
			@click.stop.prevent="toggleDatepicker"
			@mousedown.stop.prevent="doNothing"
			@mouseup.stop.prevent="doNothing">
			{{ selectedDate | formatDateRage(view, locale) }}
		</button>
		<div>date picker</div>
		<!--<DatePicker ref="datepicker"
			class="datepicker-button-section__datepicker"
			:date="selectedDate"
			:is-all-day="true"
			:open.sync="isDatepickerOpen"
			@change="navigateToDate" />-->
		<button v-shortkey="nextShortKeyConf"
			:aria-label="nextLabel"
			class="datepicker-button-section__next button"
			:title="nextLabel"
			type="button"
			@click="navigateToNextTimeRange"
			@shortkey="navigateToNextTimeRange">
			<ChevronRightIcon :size="22" />
		</button>
	</div>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from 'vue'

import ChevronLeftIcon from 'vue-material-design-icons/ChevronLeft.vue'
import ChevronRightIcon from 'vue-material-design-icons/ChevronRight.vue'

export default defineComponent({
	name: 'AppNavigationRosterButton',

	components: {
		ChevronLeftIcon,
		ChevronRightIcon,
	},

	setup() {
		const view = ref('')

		const previousLabel = computed(() => {
			switch (view.value) {
			case 'day': return 'Next day'
			default: return 'Next week'
			}
		})
		return {
			previousLabel,
		}
	},
})
</script>
