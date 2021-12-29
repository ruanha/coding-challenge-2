<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <h4>Projects</h4>
                    </div>
                    <div class="col-2">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-success" @click.prevent="addProject">Add project</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="card-table table">
                <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Entries</th>
                    <th>Total hours</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(project, index) in projectsData" :key="index">
                        <td v-text="project.name"></td>
                        <td v-text="project.entries.length"></td>
                        <td>
                            {{ formatTime(project.entries) }}
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-sm btn-danger" @click.prevent="deleteProject(project)">Delete</button>
                            <button type="button" class="btn btn-sm btn-dark" @click.prevent="editProject(project)">Edit</button>
                            <a :href="`/projects/${project.id}`" class="btn btn-sm btn-secondary">Details</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <add-project v-bind="$props" ref="add"></add-project>
        <edit-project ref="edit"></edit-project>
    </div>
</template>

<script>
import AddProject from "./AddProject";
import EditProject from "./EditProject";

import shared from '../shared';

export default {
    name: "Projects",
    components: {
        'add-project': AddProject,
        'edit-project': EditProject
    },
    props: ['projects'],
    data() {
        return {
            projectsData: this.$props.projects
        }
    },
    methods: {
        async deleteProject(project) {
            try {
                let response = await axios.post('/projects/delete', { id: project.id });
                if (response.data.status === 'success') {
                    this.projectsData = this.projectsData.filter((item) => item.id !== project.id);
                    this.$forceUpdate();
                }
            } catch (error) {
                console.error(error);
            }
        },
        formatTime(entries) {
            console.log(entries);
            return shared.formatTime(
                entries.reduce((total, entry) => total += (new Date(entry.end) - new Date(entry.start)), 0));
        },
         addProject() {
            this.$refs.add.open();
        },
        editProject(project) {
            this.$refs.edit.open(project);
        }
    }
}
</script>
