<form class="preference" x-on:submit.prevent="saveData">
    <div class="mb-3 for-select-box">
        <label for="" class="form-label text-capitalize">Want Applicants To Call You?</label>
        <select x-model="form.can_call" class="form-control">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
    </div>
    <div class="mb-3 for-select-box">
        <label for="" class="form-label text-capitalize">Want Applicants To Submit resume?</label>
        <select x-model="form.can_post_resume" class="form-control">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
    </div>
    <div class="modal-button">
        <button class="btn " type="submit">Save</button>
        <button class="btn cancel " type="button" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>