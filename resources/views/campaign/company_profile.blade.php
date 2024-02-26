<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>

    <div class="login-wapper form-element">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <h5>Profile</h5>
        <form action="{{ route('company.profile.store') }}" method="post" id="applicant-form-main" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-holder" id="image-preview">
                        <div class="profile-picture">
                            <figure id="profile-pic-applicant" style="background-image: url({{ $logo_img }}); cursor: pointer;">
                            </figure>
                            <input type="file" name="company_logo" id="profile-picture-input">
                            <a href="" id="remove-image" class="remove-img" style="display: none;">x</a>
                        </div>
                        <span class="upload_img_note">click here to add or update profile image/logo</span>
                    </div>
                    <div class="form-holder default_form">
                        <div class="holder-input ">
                            <label for="">company name </label>
                            <input type="text" name="company_name" id="company_name"
                                value="{{ old('company_name', optional(auth()->user()->companyProfile)->company_name) }}">
                            @error('company_name')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-holder default_form">
                        <div class="holder-input ">
                            <label for="">company email </label>
                            <input type="text" name="company_email" id="company_email"
                                value="{{ old('company_email', optional(auth()->user()->companyProfile)->company_email) }}">
                            @error('company_email')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-holder default_form">
                        <div class="holder-input ">
                            <label for="">contact person </label>
                            <input type="text" name="contact_person" id="contact_person"
                                value="{{ old('contact_person', optional(auth()->user()->companyProfile)->contact_person) }}">
                            @error('contact_person')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-holder default_form">
                        <div class="holder-input ">
                            <label for="">street address </label>
                            <input type="text" name="street_address" id="street_address"
                                value="{{ old('street_address', optional(auth()->user()->companyProfile)->street_address) }}">
                            @error('street_address')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="party-main-select" style="margin-bottom: 20px">
                        <label for="">Political Group</label>
                        <select id="political_group" name="political_group">
                            <option value="democrat" {{ auth()->user()->political_group == 'democrat' ? 'selected' : '' }}>
                                Democrat</option>
                            <option value="republican" {{ auth()->user()->political_group == 'republican' ? 'selected' : '' }}>Republican
                            </option>
                            <option value="nonpartisan" {{ auth()->user()->political_group == 'nonpartisan' ? 'selected' : '' }}>Nonpartisan
                            </option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-holder default_form">
                                <div class="holder-input ">
                                    <label for="">city </label>
                                    <input type="text" name="city" id="city"
                                        value="{{ old('city', optional(auth()->user()->companyProfile)->city) }}">
                                    @error('city')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-holder default_form">
                                <div class="holder-input ">
                                    <label for="">state </label>
                                    <input type="text" name="state" id="state"
                                        value="{{ old('state', optional(auth()->user()->companyProfile)->state) }}">
                                    @error('state')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-holder default_form">
                                <div class="holder-input ">
                                    <label for="">zip code </label>
                                    <input type="text" name="zip_code" id="zip-code"
                                        value="{{ old('zip_code', optional(auth()->user()->companyProfile)->zip_code) }}">
                                    @error('zip_code')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <input type="hidden" name="profile_id"
                            value="{{ optional(auth()->user()->companyProfile)->id }}">
                        <button type="submit" class="save">Save</button>
                        @if (!is_null(auth()->user()->companyProfile))
                        <ul>
                            <li><a href="{{ route('applicant.questions.index') }}">Set Applicant Questions</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            let profilePicEl = document.getElementById('profile-pic-applicant'),
                profileImg = '',
                imageRemoveEl = document.querySelector('#remove-image'),
                fileInputElemn = document.getElementById('profile-picture-input')

            profilePicEl.onclick = function(event) {
                profileImg = event.target.style.backgroundImage

                fileInputElemn.onchange = function(e) {
                    let reader = new FileReader();
                    reader.readAsDataURL(e.target.files[0])

                    reader.onload = function() {
                        profilePicEl.style.backgroundImage = `url(${reader.result})`
                        document.querySelector('#remove-image').style.display = 'block'
                    }
                }

                fileInputElemn.click()
            }

            imageRemoveEl.onclick = function(e) {
                e.preventDefault()
                profilePicEl.style.backgroundImage = profileImg
                e.target.style.display = 'none'
                fileInputElemn.value = ''
            }
        </script>
    @endpush
</x-auth.authenticate>
