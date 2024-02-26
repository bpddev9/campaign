<div class="education">
    <form action="" method="post" x-on:submit.prevent="saveQualification"
        x-bind:class="(processing) ? 'opacity-25' : ''">
        <div class="row">
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.education.institute_name" placeholder="Collage/University"
                        class="form-control">
                    <template x-if="errors.institute_name">
                        <small class="text-danger" x-text="errors.institute_name[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.education.degree" placeholder="Degree" class="form-control">
                    <template x-if="errors.degree">
                        <small class="text-danger" x-text="errors.degree[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="my-2">
                    <select x-model="form.education.start_year" class="form-control">
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
            <div class="col-lg-6">
                <div class="my-2">
                    <select x-model="form.education.end_year" class="form-control">
                        <option value="">Select End Year</option>
                        <template x-for="(year, index) in eduYears">
                            <option x-bind:value="year" x-text="year"></option>
                        </template>
                    </select>
                    <template x-if="errors.end_year">
                        <small class="text-danger" x-text="errors.end_year[0]"></small>
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

    <template x-if="myEducations.length">
        <div class="list-group">
            <template x-for="(edu, index) in myEducations" :key="index">
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1" x-text="`${edu.degree}`"></h5>
                        <small class="fs-6" x-text="`${edu.start_year} to ${edu.end_year}`"></small>
                    </div>
                    <p class="mb-1 fs-5" x-text="`From ${edu.institute_name}`"></p>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a class="text-dark" href="" x-on:click.prevent="setEduItem(edu.id)">Edit</a></li>
                        <li class="list-inline-item"><a class="text-dark" href="" x-on:click.prevent="removeEduItem(edu.id)">Delete</a></li>
                    </ul>
                </div>
            </template>
        </div>
    </template>
</div>
