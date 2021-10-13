<template>
    <FullCalendar
        ref="fullCalendar"
        defaultView="timeGridDay"
        :options="calendarOptions"
        :header="{
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
          }"
        :plugins="calendarPlugins"
        :weekends="calendarWeekends"
        :events="calendarEvents"
        @dateClick="handleDateClick"
        @eventDrop="handleEventDrop"
        @eventClick="handleEventClick"
        @eventResize="eventResize"
        :editable="true"
        navLinks="true"
        timeZone="UTC"
    />
</template>

<script>
export default {
    name: "Calender"
}
</script>

<style scoped>

</style>
