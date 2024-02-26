<x-auth.authenticate>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush

    <div class="arrow">
        <a href="{{ route('company.profile') }}"></a>
    </div>

    <div class="login-wapper form-element" data-questions="{{ optional(auth()->user()->companyProfile)->appl_quest }}">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <h5>Questions for Applicants</h5>

        <div x-data="{ ...state() }">
            <form action="{{ route('applicant.questions.store') }}" method="post" id="applicant-form-main" autocomplete="off">
                @csrf
                <div class="row">
                    <template x-for="(item, index) in questions" :key="index">
                        <div class="col-lg-12">
                            <div class="form-holder default_form">
                                <div class="holder-input">
                                    <template x-if="index === 0">
                                        <a href="#" class="float-end me-3 fs-4"
                                            x-on:click.prevent="appendItem(`add`, i)">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </a>
                                    </template>
                                    <template x-if="index > 0">
                                        <a href="#" class="float-end me-3 fs-4"
                                            x-on:click.prevent="appendItem(`remove`, item.sl_no)">
                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                        </a>
                                    </template>
                                    <label for="" x-text="`Question: ${index + 1}`"> </label>
                                    <input type="text" x-bind:name="`question[]`" x-bind:value="questions[index] ? questions[index].quest : ''" required>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="col-lg-12">
                        <button type="submit" class="save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script defer>
            function state() {
                return {
                    questions: [],
                    i: 1,

                    init() {
                        const formElement = document.querySelector('.form-element')
                        
                        if (formElement.dataset.questions !== '') {
                            this.questions = JSON.parse(formElement.dataset.questions)
                            this.i = this.questions.length
                        } else {
                            this.questions.push({
                                sl_no: this.i,
                                quest: ''
                            })
                        }
                    },

                    appendItem(mode, param) {
                        if (mode === 'add') {
                            this.i = param + 1
    
                            this.questions.push({
                                sl_no: this.i,
                                quest: ''
                            })
                        } else {
                            this.questions = this.questions.filter(q => q.sl_no !== param)
                        }
                    },
                }
            }
        </script>
    @endpush
</x-auth.authenticate>
