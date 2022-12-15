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
import allLocales from '@fullcalendar/core/locales-all'
import timeGridPlugin from '@fullcalendar/timegrid'
import dayGridPlugin from '@fullcalendar/daygrid'
import { computed, defineComponent, onMounted, onUnmounted, ref } from 'vue'
import { getCanonicalLocale, getFirstDay } from '@nextcloud/l10n'
import { useRouter } from 'vue-router/composables'
import { subscribe, unsubscribe } from '@nextcloud/event-bus'

export default defineComponent({
	components: {
		FullCalendar,
	},

	props: {
		initialDate: {
			type: [Date, String],
			default: () => new Date(),
		},
		view: {
			type: String,
			default: 'week',
		},
	},

	setup(props) {
		const router = useRouter()

		const calendar = ref<{getApi:()=>Calendar}>()
		const api = computed(() => calendar.value?.getApi())

		const resizeCalendar = () => { api.value?.updateSize() }

		onMounted(() => {
			subscribe('navigation-toggled', resizeCalendar)
		})
		onUnmounted(() => {
			unsubscribe('navigation-toggled', resizeCalendar)
		})

		router.beforeResolve((to, from, next) => {
			if (to.name === from.name && to.name === 'roster') {
				if (to.params.view !== from.params.view) api.value?.changeView(getView(to.params.view))
				if (to.params.initialDate !== from.params.initialDate) api.value?.gotoDate(to.params.initialDate)
			}
			next()
		})

		const showDate = (date: Date) => {
			router.push({
				name: 'roster',
				params: {
					view: 'day',
					initialDate: date.toISOString().split('T')[0] as string,
				},
			})
		}

		const getView = (view: string = props.view) => view === 'month' ? 'dayGridMonth' : `timeGrid${view === 'day' ? 'Day' : 'Week'}`

		const calendarOptions: CalendarOptions = {
			plugins: [dayGridPlugin, timeGridPlugin],
			initialView: getView(),
			initialDate: props.initialDate,
			firstDay: getFirstDay(),
			locales: allLocales,
			locale: getCanonicalLocale(),
			navLinkDayClick: showDate,
			navLinks: true,
			headerToolbar: false,
			dayHeaderFormat: {
				weekday: 'short',
				year: 'numeric',
				day: 'numeric',
				month: 'numeric',
			},
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
