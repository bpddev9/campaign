<form class="other-details" x-on:submit.prevent="saveData">
    <div class="mb-3 for-select-box">
        <label for="" class="form-label text-capitalize">Type</label>
        <select x-model="form.job_type" class="form-control">
            <option value="">Select...</option>
            @foreach ($jobTypes as $type)
                <option value="{{ $type }}">{{ Str::title($type) }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3 for-select-box">
        <label for="" class="form-label text-capitalize">Schedule</label>
        <select x-model="form.job_schedule" class="form-control">
            <option value="">Select...</option>
            @foreach ($jobSchedules as $schedule)
                <option value="{{ $schedule }}">{{ Str::title($schedule) }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3 for-select-box">
        <label for="" class="form-label text-capitalize">No of people to hire</label>
        <select x-model="form.no_of_people" class="form-control">
            <option value="">Select...</option>
            @foreach (range(1, 10) as $i)
                <option value="{{ $i }}">{{ $i }}</option>
            @endforeach
        </select>
    </div>
    <div class="modal-button">
        <button class="btn" type="submit"
            x-bind:disabled="form.job_type == '' || form.job_schedule == '' || form.no_of_people == ''">Save</button>
        <button class="btn cancel" type="button"
            data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
