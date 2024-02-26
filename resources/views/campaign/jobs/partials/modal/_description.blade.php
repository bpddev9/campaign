<form class="job-description" x-on:submit.prevent="saveData">
    <div class="mb-3 form-group">
        <label for="" class="form-label text-capitalize">job description</label>
        <textarea class="form-control" :class="error.job_description ? 'is-invalid' : ''" x-model="form.job_description" rows="3"></textarea>
        <template x-if="error.job_description">
            <span class="invalid-feedback" x-text="error.job_description[0]"></span>
        </template>
    </div>
    <div class="modal-button">
        <button class="btn" x-bind:disabled="form.job_description == ''" type="submit">Save</button>
        <button class="btn cancel" type="button" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>