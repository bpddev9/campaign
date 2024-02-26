<form class="basic-info" x-on:submit.prevent="saveData">
    <div class="mb-3 form-group for-select-box">
        <label for="" class="form-label text-capitalize">Industry</label>
        <select x-model="form.job_title" class="form-control" x-on:change="roleSelected">
            <template x-for="(role, index) in jobRoles.data" :key="index">
                <option x-bind:value="role.title" x-bind:selected="role.title == form.job_title" x-text="role.title"></option>
            </template>
        </select>
    </div>
    <div class="mb-3 form-group for-select-box">
        <label for="" class="form-label text-capitalize">Job Title</label>
        <select class="form-control" x-model="form.job_position" x-on:change="positionSelected">
            <template x-for="(item, index) in designations" :key="index">
                <option x-bind:value="item" x-text="item" x-bind:selected="item == form.job_position"></option>
            </template>
        </select>
    </div>
    <div class="mb-3 form-group for-select-box">
        <label for="" class="form-label text-capitalize">Location Type</label>
        <select x-model="form.location_type" class="form-control">
            <option value="remote" x-bind:selected="form.location_type == 'remote'">Remote</option>
            <option value="office" x-bind:selected="form.location_type == 'office'">Office</option>
        </select>
    </div>
    <div class="modal-button">
        <button class="btn" type="submit">Save</button>
        <button class="btn cancel" type="button" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>