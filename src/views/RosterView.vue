<!--
	SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
	SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<FullCalendar ref="calendar" :options="calendarOptions" />
</template>

<script lang="ts">
import '@fullcalendar/core/vdom.js'
import FullCalendar, { Calendar, CalendarOptions } from '@fullcalendar/vue'
import timeGridPlugin from '@fullcalendar/timegrid'
import dayGridPlugin from '@fullcalendar/daygrid'
import { defineComponent, ref } from 'vue'

export default defineComponent({
	components: {
		FullCalendar,
	},

	props: {
		firstDay: {
			type: Number,
			default: 0,
		},
		initialDate: {
			type: [Date, String],
			default: new Date(),
		},
	},

	setup(props) {
		const calendar = ref<{getApi:()=>Calendar}>()
		// const api = computed(() => calendar.value?.getApi())

		const calendarOptions: CalendarOptions = {
			plugins: [dayGridPlugin, timeGridPlugin],
			initialView: 'timeGridWeek',
			initialDate: props.initialDate,
			firstDay: props.firstDay,
			headerToolbar: false,
		}

		return {
			calendar,
			calendarOptions,
		}
	},
})
</script>
<style lang="scss">
@import 'css/fullcalendar.scss';
</style>
