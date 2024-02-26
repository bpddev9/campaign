<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper search-result-main" x-data="{ ...jobListings() }" x-init="fetchJobs(page)" x-on:scroll="pageScrolled">
        <h2 x-text="userRole"></h2>
        <div class="manin-wapper">
            <div class="heading">
                <h5>all jobs</h5>
            </div>
            <div class="text">
                <template x-if="loading">
                    <div class="m-5 d-flex justify-content-center align-middle">
                        <div class="spinner-border text-dark" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </template>

                <template x-if="!listings.length">
                    <p class="fs-5">No Listings Found</p>
                </template>

                <template x-for="(item, index) in listings" :key="index">
                    <div class="fst-sec">
                        <h3 x-text="item.job_title"></h3>
                        <p style="margin: 14px 0;" x-text="item.company_name"></p>
                        <p x-text="`${item.job_description.substring(0, 100)}`"></p>
                        <ul>
                            <li>
                                <span><img src="{{ asset('images/Icon-Calendar.svg') }}" alt=""></span>
                                <span x-text="item.posted_on"></span>
                            </li>
                            <template x-if="item.location !== null">
                                <li>
                                    <span><img src="{{ asset('images/Icon-Location.svg') }}" alt=""></span>
                                    <span x-text="item.location"></span>
                                </li>
                            </template>
                            <li>
                                <span><img src="{{ asset('images/Icon-Salary.svg') }}" alt=""></span>
                                <span
                                    x-text="displaySalary(item.min_salary, item.max_salary, item.pay_rate)"></span>
                            </li>
                            <li>
                                <span><img src="{{ asset('images/Icon-Job-Type.svg') }}" alt=""></span>
                                <span class="text-uppercase" x-text="`${item.job_type} - (${item.job_schedule})`"></span>
                            </li>
                        </ul>
                        <span class="extra-margin">
                            <a href="" x-on:click.prevent="window.location.href = '/my-account/job/' + item.id">Read More</a>
                        </span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function jobListings() {
                return {
                    listings: [],
                    loading: false,
                    page: 1,
                    last_page: '',
                    userRole: "{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Employer' }}",

                    async fetchJobs(page) {
                        this.loading = true
                        try {
                            let response = await fetch(`${window.location.origin}/my-account/jobs-listing?page=${page}`)
                            response = await response.json()
                            this.listings.push(...response.data.data)
                            this.last_page = response.data.last_page
                            this.loading = false
                        } catch (error) {
                            this.loading = false
                        }
                    },

                    displaySalary(min, max, rate) {
                        if (max !== null) {
                            return `$${min} to $${max} ${rate}`
                        }
                        return `$${min} ${rate}`
                    },

                    pageScrolled() {
                        let wrapper = document.querySelector('.search-result-main'),
                        lastDiv = document.querySelector('.search-result-main > .manin-wapper > .text > .fst-sec:last-child'),
                        lastDivOffset = lastDiv.offsetTop + lastDiv.clientHeight,
                        pageOffset = wrapper.scrollTop + wrapper.clientHeight
                        
                        if (pageOffset > lastDivOffset - 10 && this.page < this.last_page) {
                            this.page = this.page + 1
                            this.fetchJobs(this.page)
                        }
                    }
                }
            }
        </script>
    @endpush
</x-auth.authenticate>
