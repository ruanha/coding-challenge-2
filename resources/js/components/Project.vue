<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10">
                    <h4 v-text="project.name"></h4>
                </div>
                <div class="col-2">
                    <div class="text-right">
                        <button v-show="running" type="button" class="btn btn-sm btn-danger" @click.prevent="stopTimer">Stop</button>
                        <button v-show="!running" type="button" class="btn btn-sm btn-success" @click.prevent="startTimer">Start</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="card-table table">
            <thead>
                <tr>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Time spent</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(entry, index) in project.entries" :key="index">
                    <td v-text="entry.start"></td>
                    <td v-text="entry.end"></td>
                    <td>
                        {{ formatTime(entry) }}
                    </td>
                    <td><button type="button" class="btn btn-sm btn-danger" @click.prevent="deleteEntry(entry)">Delete</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { formatTime } from '../shared';

export default {
    name: "Project",
    props: ['project'],
    data: () => ({
        running: false
    }),
    methods: {
        async deleteEntry(entry) {
            try {
                let response = await axios.post('/entries/delete', { id: entry.id });
                if (response.data.status === 'success') {
                    this.$props.project.entries = this.$props.project.entries.filter((item) => item.id !== entry.id);
                    this.$forceUpdate();
                }
            } catch (error) {
                console.error(error);
            }
        },
        formatTime(entry) {
            return formatTime(new Date(entry.end) - new Date(entry.start))
        },
        startTimer() {
            this.addEntry();
            this.running = true;
        },
        stopTimer() {
            this.running = false;
            this.updateEntry();
        },
        async addEntry() {
            try {
                await axios.post('/entries/start', { project_id: this.$props.project.id });
            } catch (error) {
                console.error(error);
            }
        },
        async updateEntry() {
            try {
                await axios.post('/entries/stop', { project_id: this.$props.project.id });
            } catch (error) {
                console.error(error);
            }
        },
    }
}
</script>
