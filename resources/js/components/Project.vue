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
                </tr>
            </thead>
            <tbody>
                <tr v-for="(entry, index) in project.entries" :key="index">
                    <td v-text="entry.start"></td>
                    <td v-text="entry.end"></td>
                    <td>
                        {{ formatTime(entry) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Project",
    props: ['project'],
    data: () => ({
        running: false,
        millisecondsPerHour: 1000 * 60 * 60
    }),
    methods: {
        formatTime(entry) {
            var diff = new Date(entry.end) - new Date(entry.start);
            var hours = Math.floor(diff / 3.6e5);
            var minutes = Math.floor((diff % 3.6e5) / 6e4);
            var seconds = Math.floor((diff % 6e4) / 1000);
            return `${hours} hrs, ${minutes} min and ${seconds} sec`;
        },
        startTimer() {
            this.addEntry();
            console.log(this.$props.project);
            this.running = true;
        },
        stopTimer() {
            this.running = false;
            this.updateEntry();
        },
        async addEntry() {
            console.log("start entry for project: " + this.$props.project.id);
            try {
                let response = await axios.post('/entries/start', { project_id: this.$props.project.id });
                console.log(response);
                if (response.data.status === 'success') {
                    console.log('much success!');
                }
                else {
                    console.log('much failure!');
                }
            } catch (error) {
                console.error(error);
            }
        },
        async updateEntry() {
            console.log("stop entry for project: " + this.$props.project.id);
            try {
                let response = await axios.post('/entries/stop', { project_id: this.$props.project.id });
                if (response.data.status === 'success') {
                    console.log('much success!');
                    console.log(response)
                }
                else {
                    console.log('much failure!');
                }
            } catch (error) {
                console.error(error);
            }
        },
    }
}
</script>
