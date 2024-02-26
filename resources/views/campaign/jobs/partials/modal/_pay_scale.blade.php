<form class="pay-scale" x-on:submit.prevent="saveData">
    <div class="mb-3">
        <label for="" class="form-label text-capitalize">minimun salary</label>
        <input type="text" x-model="form.min_salary" class="form-control">
    </div>
    <div class="mb-3">
        <label for="" class="form-label text-capitalize">maximum salary</label>
        <input type="text" x-model="form.max_salary" class="form-control">
    </div>
    <div class="mb-3 for-select-box">
        <label for="" class="form-label text-capitalize">Payment Rate</label>
        <select x-model="form.pay_rate" class="form-control">
            <option value="">Select...</option>
            @foreach ($payRates as $rate)
                <option value="{{ $rate }}">{{ Str::title($rate) }}</option>
            @endforeach
        </select>
    </div>
    <div class="modal-button">
        <button class="btn" type="submit"
            x-bind:disabled="form.min_salary == '' || form.pay_rate == ''">Save</button>
        <button class="btn cancel" type="button"
            data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
