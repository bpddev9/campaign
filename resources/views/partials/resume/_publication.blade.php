<div class="publication">
    <form action="" method="post" x-on:submit.prevent="savePublication"
        x-bind:class="(processing) ? 'opacity-25' : ''">
        <div class="row">
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.publication.title" placeholder="Publication Title"
                        class="form-control">
                    <template x-if="errors.title">
                        <small class="text-danger" x-text="errors.title[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="my-2">
                    <input type="text" x-model="form.publication.publisher" placeholder="Publisher"
                        class="form-control">
                    <template x-if="errors.publisher">
                        <small class="text-danger" x-text="errors.publisher[0]"></small>
                    </template>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="my-2">
                    <textarea class="form-control" cols="30" rows="3" x-model="form.publication.summary"
                        placeholder="Publication Description"></textarea>
                    <template x-if="errors.summary">
                        <small class="text-danger" x-text="errors.summary[0]"></small>
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

    <template x-if="myPublications.length">
        <div class="list-group">
            <template x-for="(publ, index) in myPublications" :key="index">
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1" x-text="`${publ.title}`"></h5>
                    </div>
                    <p class="mb-1 fs-5" x-text="`${publ.summary.substring(0, 70)}`"></p>
                    <small x-text="`Publisher: ${publ.publisher}`"></small>

                    <ul class="list-inline mt-3">
                        <li class="list-inline-item"><a class="text-dark" href=""
                                x-on:click.prevent="setPublItem(publ.publication_id)">Edit</a></li>
                        <li class="list-inline-item"><a class="text-dark" href=""
                                x-on:click.prevent="">Delete</a></li>
                    </ul>
                </div>
            </template>
        </div>
    </template>
</div>
