<template>
    <div>
        <div class="container mx-auto mt-10">
            <div class="wrapper bg-white rounded shadow w-full overflow-auto">
                <div class="header flex justify-between border-b p-2">
                <span class="text-lg font-bold">
                    {{week[0].replaceAll('-','/').substr(0,7)}}
                </span>
                    <div class="buttons">
                        <button class="p-1" @click="goToPreviousWeek">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                                <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                            </svg>
                        </button>
                        <button class="p-1" @click="goToNextWeek">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1 0-.708L10.293 8 7.646 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                                <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <table class="w-full">
                    <thead>
                    <tr>
                        <th class="p-2 border-r h-10 w-10 xl:text-sm text-xs">
                            <span >Jobs</span>
                        </th>
                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">Sunday</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Sun</span>
                            <div class="top h-5 w-full">
                                <span class="text-gray-500">{{ week[0].substr(8) }}</span>
                            </div>
                        </th>

                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">Monday</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Mon</span>
                            <div class="top h-5 w-full">
                                <span class="text-gray-500">{{ week[1].substr(8) }}</span>
                            </div>
                        </th>
                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">Tuesday</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Tue</span>
                            <div class="top h-5 w-full">
                                <span class="text-gray-500">{{ week[2].substr(8) }}</span>
                            </div>
                        </th>
                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">Wednesday</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Wed</span>
                            <div class="top h-5 w-full">
                                <span class="text-gray-500">{{ week[3].substr(8) }}</span>
                            </div>
                        </th>
                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">Thursday</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Thu</span>
                            <div class="top h-5 w-full">
                                <span class="text-gray-500">{{ week[4].substr(8) }}</span>
                            </div>
                        </th>
                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">Friday</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Fri</span>
                            <div class="top h-5 w-full">
                                <span class="text-gray-500">{{ week[5].substr(8) }}</span>
                            </div>
                        </th>
                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">Saturday</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Sat</span>
                            <div class="top h-5 w-full">
                                <span class="text-gray-500">{{ week[6].substr(8) }}</span>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="job of jobs"  class="text-center h-20 ">

                        <td class="border p-1 w-10 overflow-auto transition cursor-pointer duration-500 ease hover:bg-gray-300 ">
                            <div class="flex flex-col h-40 sm:w-20 w-10 mx-auto overflow-hidden">
                                {{job.title}}
                            </div>
                        </td>
                        <td v-for="day in week" key="weekday" class="border p-1 h-40 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 overflow-auto transition cursor-pointer duration-500 ease hover:bg-gray-300 ">
                            <div class="flex flex-col h-40 mx-auto xl:w-40 lg:w-30 md:w-30 sm:w-full w-10 mx-auto overflow-hidden">
                                <div class="bottom flex-grow overflow-auto h-30 py-1 w-full cursor-pointer" >
                                    <div class="event bg-purple-400 text-white rounded p-1 text-sm mb-1"
                                         :class="{'bg-green-300':schedule.verified ===1 , 'bg-yellow-300':schedule.verified === 0}"
                                         v-for="schedule of (currentSchedules[job.id] && currentSchedules[job.id][day]) || []" key="schedule.id">
                                        <span class="event-name block" >
                                            {{schedule.worker.name}}
                                        </span>
                                        <span class="time">
                                            {{schedule.start_hour}}~{{schedule.end_hour}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    components: {

    },

    props: {
        user:Object,
        schedules:Object,
        jobs:Object,
        week:Array
    },
    mounted() {

        let reqChannel = Echo.private('requests-channel-'+this.user.id)
        console.log(reqChannel)
            reqChannel.listen('.request-approved',function (data){
                let schedule = data.schedule
                if(schedule){
                    console.log('schedule approved.',schedule)
                    if(!this.currentSchedules[schedule.job_id][schedule.start_day])
                        this.currentSchedules[schedule.job_id][schedule.start_day]=[]
                    this.currentSchedules[schedule.job_id][schedule.start_day].push(schedule)
                    this.toast('your request for '+schedule.job.title +' at '+schedule.started_at+ ' approved successfully.')
                }
                else
                {
                    console.log('not connected to notification server.')
                }
            }.bind(this))
            .listen('.request-declined',function (data){
                let schedule = data.schedule
                if(schedule){
                    console.log('schedule declined.',schedule)
                    if(!this.currentSchedules[schedule.job_id][schedule.start_day])
                        this.currentSchedules[schedule.job_id][schedule.start_day]=[]
                    this.currentSchedules[schedule.job_id][schedule.start_day].push(schedule)
                    this.toast('your request for '+schedule.job.title +' at '+schedule.started_at+ ' declined.')
                }
                else
                {
                    console.log('not connected to notification server.')
                }
            }.bind(this))
            .error(function(err){
                console.log('connection error:',err)
            });
    },

    data() {
        return {
            currentSchedules : this.$props.schedules,
        }
    },
    methods: {
        toast(message){
            this.$page.props.flash.message = message
        },
        goToNextWeek(){
            let lastDay = this.week[6]
            let mday =  moment(lastDay, "YYYY-MM-DD");
            for(let i = 0;i<7;i++){
                this.week[i]= mday.add(1,"days").format('YYYY-MM-DD')
            }
        },
        goToPreviousWeek(){
            let firstDay = this.week[0]
            let mday =  moment(firstDay, "YYYY-MM-DD");
            for(let i = 6;i>=0;i--){
                this.week[i]= mday.subtract(1,"days").format('YYYY-MM-DD')
            }
        },
    },
}
</script>
