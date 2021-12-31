<template>
    <div class="modal" tabindex="-1" role="dialog" ref="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit {{ name }}</h5>
                    <button type="button" class="close" @click.prevent="closeModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="project_name">Project name</label>
                        <input value="{ projectName }" type="text" name="project_name" id="project_name" class="form-control"  v-bind:class="{ 'is-invalid': isInvalid }" v-model="projectName" />
                        <div class="invalid-feedback">
                            project with that name already exist
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click.prevent="closeModal">Cancel</button>
                    <button type="button" :disabled="isInvalid" class="btn btn-success" @click.prevent="submit">Save project</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        project: null,
        projectName: '',
        isInvalid: false,
    }),
    props: ['projects'],
    computed: {
        name() {
            if (this.project) {
                return this.project.name;
            }
            return '';
        }
    },
    methods: {
        open(project) {
            this.project = project
            this.projectName = this.project.name
           $(this.$refs.modal).modal('show');
        },
        closeModal() {
            $(this.$refs.modal).modal('hide');
            this.projectName = '';
        },
        async submit() {
            try {
                let response = await axios.post('/projects/update', { id: this.project.id, name: this.projectName });
                if (response.data.status === 'success') {
                    $(this.$refs.modal).modal('hide');
                }
                else {
                    this.isInvalid = true;
                }
            } catch (error) {
                console.error(error);
            }
        },
    },
    watch: {
        'projectName': function(val) {
            this.isInvalid = this.$props.projects
                .map((project) => project.name)
                .includes(val)
        }
    }
}
</script>
