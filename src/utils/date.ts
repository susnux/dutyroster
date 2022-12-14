/**
 * Get ISO week number of given date
 *
 * @param {Date|number|string} date The date to query week number for
 */
export function weekNumber(date: Date|number|string) {
	const d = new Date(date)
	d.setHours(0, 0, 0, 0)
	d.setDate(d.getDate() + 4 - (d.getDay() || 7))
	const yearStart = new Date(d.getFullYear(), 0, 1).getTime()
	const weekNo = Math.ceil((((d.getTime() - yearStart) / 86400000) + 1) / 7)
	return [d.getFullYear(), weekNo]
}

/**
 * Get total number of ISO weeks in given year
 *
 * @param {number|string} year The year to query weeks
 */
export function weeksInYear(year: number|string) {
	const d = new Date(+year, 11, 31)
	const week = weekNumber(d)[1]
	return week === 1 ? 52 : week
}
