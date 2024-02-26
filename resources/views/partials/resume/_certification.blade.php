<div class="certification">
    <form action="" method="POST" x-on:submit.prevent="saveCertification"
        x-bind:class="(processing) ? 'opacity-25' : ''">
        <div class="row">
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.certification.certificate" placeholder="Enter Certificate/Award"
                        class="form-control">
                    <template x-if="errors.certificate">
                        <small class="text-danger" x-text="errors.certificate[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.certification.award_org"
                        placeholder="Enter Conferring Organization" class="form-control">
                    <template x-if="errors.award_org">
                        <small class="text-danger" x-text="errors.award_org[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="my-2">
                    <textarea x-model="form.certification.summary" cols="30" rows="4" class="form-control" placeholder="Summary"></textarea>
                    <template x-if="errors.summary">
                        <small class="text-danger" x-text="errors.summary[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="my-2">
                    <select x-model="form.certification.start_year" class="form-control">
                        <option value="">Select Start Year</option>
                        <template x-for="(year, index) in eduYears">
                            <option x-bind:value="year" x-text="year"></option>
                        </template>
                    </select>
                    <template x-if="errors.start_year">
                        <small class="text-danger" x-text="errors.start_year[0]"></small>
                    </template>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 my-3">
            <button class="btn btn-success" style="background-color: purple; border-radius: 5px;" type="submit"
                x-bind:disabled="processing">Save</button>
            <button class="btn btn-default" style="background-color: red; border-radius: 5px;" type="button"
                data-bs-dismiss="modal" x-bind:disabled="processing">Cancel</button>
        </div>
    </form>

    <template x-if="loading">
        @include('partials._loading_spinner')
    </template>

    <template x-if="myCertification.length">
        <div class="list-group">
            <template x-for="(cert, index) in myCertification" :key="index">
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1" x-text="`${cert.certificate}`"></h5>
                        <small class="text-muted" x-text="`Year: ${cert.start_year}`"></small>
                    </div>
                    <p class="mb-1 fs-5" x-text="`${cert.summary.substring(0, 100)}...`"></p>
                    <small class="text-muted" x-text="`Recieved from: ${cert.award_org}`"></small>

                    <ul class="list-inline mt-3">
                        <li class="list-inline-item"><a class="text-dark" href=""
                                x-on:click.prevent="setCertItem(cert.certification_id)">Edit</a></li>
                        <li class="list-inline-item"><a class="text-dark" href=""
                                x-on:click.prevent="removeCertItem(cert.certification_id)">Delete</a></li>
                    </ul>
                </div>
            </template>
        </div>
    </template>
</div>
