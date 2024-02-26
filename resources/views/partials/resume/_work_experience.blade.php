<div class="work-exp">
    <form action="" method="post" x-on:submit.prevent="saveExperience"
        x-bind:class="(processing) ? 'opacity-25' : ''">
        <div class="row">
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.workExp.title" placeholder="Title" class="form-control">
                    <template x-if="errors.title">
                        <small class="text-danger" x-text="errors.title[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.workExp.companyName" placeholder="Company Name"
                        class="form-control">
                    <template x-if="errors.title">
                        <small class="text-danger" x-text="errors.companyName[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" placeholder="Start Date" x-model="form.workExp.startDate" x-ref="startDate"
                        class="form-control">
                    <template x-if="errors.startDate">
                        <small class="text-danger" x-text="errors.startDate[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" placeholder="End Date" x-model="form.workExp.endDate" class="form-control"
                        x-bind:disabled="form.workExp.isCurrentlyWorking" x-ref="endDate">
                    <template x-if="errors.endDate">
                        <small class="text-danger" x-text="errors.endDate[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="my-2 form-check">
                    <input class="form-check-input" x-model="form.workExp.isCurrentlyWorking" type="checkbox"
                        id="currentlyWorking">
                    <label class="form-check-label" for="currentlyWorking">
                        I'm currently working here
                    </label>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="my-2">
                    <textarea class="form-control" cols="30" x-model="form.workExp.description"
                        placeholder="Describe your work experience" rows="3"></textarea>
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

    <template x-if="myExperiences.length">
        <div class="list-group">
            <template x-for="(exp, index) in myExperiences" :key="index">
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1" x-text="exp.title"></h5>
                        <template x-if="exp.isCurrentlyWorking">
                            <small class="text-muted" x-text="`${exp.startDate} to Preset`"></small>
                        </template>
                        <template x-if="!exp.isCurrentlyWorking">
                            <small class="text-muted" x-text="`${changeDateTimeFormat(exp.startDate)} to ${changeDateTimeFormat(exp.endDate)}`"></small>
                        </template>
                    </div>
                    <p class="mb-1 fs-5"
                        x-text="(exp.description !== null) ? exp.description.substring(0, 80) + '...' : 'N/a'"></p>
                    <small class="text-muted fw-bold" x-text="exp.companyName"></small>
                    <ul class="list-inline mt-2">
                        <li class="list-inline-item">
                            <a href="" class="text-dark" x-on:click.prevent="selectExpItem(exp.id)">Edit</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="" class="text-dark" x-on:click.prevent="removeExp(exp.id)">Delete</a>
                        </li>
                    </ul>
                </div>
            </template>
        </div>
    </template>
</div>
