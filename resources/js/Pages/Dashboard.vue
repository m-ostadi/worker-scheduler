<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <jet-secondary-button v-if="$page.props.can.request_schedule" @click="showScheduleRequestModal = true" class="px-6">Request schedule</jet-secondary-button>
        </template>

        <div class="py-12">
            <p v-if="$page.props.can.request_schedule == false" class="text-center">
                For submitting schedule requests, you should login with a worker account.
            </p>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Calendar :user="$page.props.user" :schedules="$page.props.schedules" :jobs="$page.props.jobs" :week="$page.props.week" />
                    <jet-dialog-modal :show="showScheduleRequestModal" @close="closeModal">
                        <template #title>
                            Request a schedule
                        </template>

                        <template #content>

                            <form @submit.prevent="submitRequest">
                                <div class="mt-4">
                                    <label class="block mb-1">Select your job</label>
                                    <select v-model="form.job_id" required>
                                        <option v-for="job in jobs" :value="job.id">{{job.title}}</option>
                                    </select>
                                    <jet-input-error :message="form.errors.job_id" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <label class="mr-2">When it start?</label>
                                    <jet-input class="border" v-model="form.started_at" type="datetime-local" required/>
                                    <jet-input-error :message="form.errors.started_at" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                    <label class="mr-2">When it finish?</label>
                                    <jet-input class="border" v-model="form.ended_at" type="datetime-local" required/>
                                    <jet-input-error :message="form.errors.ended_at" class="mt-2" />
                                </div>
                            </form>


                        </template>

                        <template #footer>
                            <jet-secondary-button @click="closeModal">
                                Cancel
                            </jet-secondary-button>

                            <jet-danger-button class="ml-2" @click="submitRequest" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit Request
                            </jet-danger-button>
                        </template>
                    </jet-dialog-modal>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetActionSection from '@/Jetstream/ActionSection.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import Calendar from "./Calendar";

    export default {
        props:{
            jobs:Object,
            schedules:Object,
            user:Object,
            week:Array
        },
        components: {
            Calendar,
            AppLayout,
            JetActionSection,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },
        data(){
            return{
                showScheduleRequestModal:false,
                form: this.$inertia.form({
                    job_id: '',
                    started_at: '',
                    ended_at:'',
                })
            }
        },
        methods:{
            closeModal() {
                this.showScheduleRequestModal = false
                this.form.reset()
            },
            submitRequest() {

                this.form.post(route('worker.schedules.store'), {
                    preserveScroll: true,
                    onSuccess: () => {this.closeModal(); this.$page.props.flash.message = "your schedule request submitted for approval by admin." },
                    onError: () => console.log('error store request'),
                    onFinish: () => this.form.reset(),
                })
            },
        }

    }
</script>
