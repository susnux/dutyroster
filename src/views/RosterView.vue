<!--
	SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
	SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<FullCalendar ref="calendar" :options="calendarOptions" />
</template>

<script lang="ts">
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import allLocales from '@fullcalendar/core/locales-all'

import { useRouter } from 'vue-router/composables'
import { Calendar, CalendarOptions, FormatterInput } from '@fullcalendar/core'
import { subscribe, unsubscribe } from '@nextcloud/event-bus'
import { getCanonicalLocale, getFirstDay } from '@nextcloud/l10n'
import { computed, defineComponent, onMounted, onUnmounted, ref } from 'vue'

import { dateString } from '../utils/date'

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
				if (to.params.view !== from.params.view) {
					api.value?.changeView(getView(to.params.view))
					if (to.params.view === 'month' || from.params.view === 'month') {
						api.value?.setOption('dayHeaderFormat', dayHeaderFormat(to.params.view))
					}
				}
				if (to.params.initialDate !== from.params.initialDate) api.value?.gotoDate(to.params.initialDate || new Date())
			}
			next()
		})

		const showDate = (date: Date) => {
			router.push({
				name: 'roster',
				params: {
					view: 'day',
					initialDate: dateString(date),
				},
			})
		}

		const dayHeaderFormat = (view: string = props.view): FormatterInput => {
			if (view === 'month') {
				return {
					weekday: 'long',
				}
			} else {
				return {
					weekday: 'short',
					year: 'numeric',
					day: 'numeric',
					month: 'numeric',
				}
			}
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
			dayHeaderFormat: dayHeaderFormat(),
		}

		return {
			calendar,
			calendarOptions,
		}
	},
})
</script>

<style lang="scss">
@import 'css/fullcalendar';
</style>
