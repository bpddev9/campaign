<x-auth.authenticate>
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    @endpush
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper form-element">
        <h2>{{ __('Applicant') }}</h2>
        <form id="applicant-form-main" action="{{ route('my.profile.update') }}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-holder" id="image-preview">
                        <div class="profile-picture">
                            <figure id="profile-pic-applicant" style="background-image: url({{ $profile_pic }}); cursor: pointer;"></figure>
                            <input id="profile-picture-input" name="profile_pic" type="file">
                            <a class="remove-img" id="remove-image" href="" style="display: none;">x</a>
                        </div>
                        <span class="upload_img_note">click here to add or update profile image</span>
                    </div>

                    <div class="form-holder default_form">
                        <div class="holder-input">
                            <label for="">Name <span class="star-profile">*</span> </label>
                            <input id="name" name="name" type="text" value="{{ auth()->user()->name }}">
                            <small class="error-message" id="name_error"></small>
                        </div>
                    </div>

                    <div class="form-holder default_form">
                        <div class="holder-input">
                            <label for="">Address <span class="star-profile">*</span></label>
                            <input id="street_address" name="street_address" type="text"
                                value="{{ optional(auth()->user()->profile)->street_address }}">

                            <small class="error-message" id="street_address_error"></small>
                        </div>
                    </div>

                    <div class="form-holder default_form">
                        <div class="holder-input">
                            <label for="">Phone <span class="star-profile">*</span> </label>
                            <input id="phone_no" name="phone_no" data-mask="(000) 000-0000" type="text" value="{{ auth()->user()->phone_no }}">
                            <small class="error-message" id="phone_no_error"></small>
                        </div>
                    </div>

                    <div class="form-holder default_form">
                        <div class="holder-input">
                            <label for="">Email <span class="star-profile">*</span> </label>
                            <input id="email" name="email" type="text" value="{{ auth()->user()->email }}">
                            <small class="error-message" id="email_error"></small>
                        </div>
                    </div>

                    <div class="party-main-select">
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

                    <div class="col-lg-12">
                        <button class="save" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
        <span class="or">OR</span>
        <ul>
            <li><a href="{{ route('manage.resume') }}">Resume Management</a></li>
            <li><a href="{{ route('profile.question') }}">Profile Questions</a></li>
        </ul>
    </div>

    @include('partials._image_crop_modal')

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
        <script>
            let profilePicEl = document.getElementById('profile-pic-applicant'),
                profileImg = '',
                imageRemoveEl = document.querySelector('#remove-image'),
                fileInputElemn = document.getElementById('profile-picture-input'),
                imageToCropr = document.querySelector('#imageToCrop'),
                modalElement = document.querySelector('#myModal'),
                saveImageBtn = document.querySelector('#save-image'),
                mainForm = document.querySelector('#applicant-form-main'),
                saveBtn = document.querySelector('.save'),
                formData = new FormData(),
                cropper,
                fileName,
                fileType,
                profilePic

            const reader = new FileReader();

            profilePicEl.onclick = function(event) {
                profileImg = event.target.style.backgroundImage

                fileInputElemn.onchange = function(e) {
                    let file = e.target.files[0]
                    fileName = file.name
                    fileType = file.type
                    reader.readAsDataURL(e.target.files[0])

                    reader.onload = () => {
                        imageToCropr.src = reader.result
                    }
                    window.myModal.show()
                }

                fileInputElemn.click()
            }

            imageRemoveEl.onclick = function(e) {
                e.preventDefault()
                profilePicEl.style.backgroundImage = profileImg
                e.target.style.display = 'none'
                fileInputElemn.value = ''
            }

            modalElement.addEventListener('shown.bs.modal', () => {
                cropper = new Cropper(imageToCropr, {
                    autoCropArea: 0.5,
                    background: false,
                    minCanvasWidth: 300,
                    minCanvasWidth: 550,
                    ready: () => {
                        document.querySelector('.cropper-container').style.width = "100%"
                    }
                })
            })

            modalElement.addEventListener('hidden.bs.modal', () => {
                cropper.destroy()
            })

            saveImageBtn.onclick = () => {
                cropper.getCroppedCanvas().toBlob((blob) => {
                    blob.name = fileName
                    profilePic = new File([blob], fileName, {
                        type: fileType
                    })
                    reader.readAsDataURL(profilePic)

                    reader.onload = () => {
                        formData.append('profile_pic', profilePic)
                        profilePicEl.style.backgroundImage = `url(${reader.result})`
                        document.querySelector('#remove-image').style.display = 'block'
                    }

                    window.myModal.hide()
                })
            }

            mainForm.onsubmit = async (e) => {
                e.preventDefault()
                saveBtn.setAttribute('disabled', 'disabled')
                saveBtn.classList.add('opacity-25')

                formData.append('name', document.querySelector('#name').value)
                formData.append('email', document.querySelector('#email').value)
                formData.append('phone_no', document.querySelector('#phone_no').value)
                formData.append('street_address', document.querySelector('#street_address').value)
                formData.append('political_group', document.querySelector('#political_group').value)

                let url = mainForm.getAttribute('action')

                try {
                    let res = await window.axios.post(url, formData)
                    saveBtn.removeAttribute('disabled')
                    saveBtn.classList.remove('opacity-25')
                    window.location.href = '/my-account/profile/applicant'
                } catch (error) {
                    Object.keys(error.response.data.errors).forEach((item, index) => {
                        document.getElementById(`${item}_error`).innerText = error.response.data.errors[item]
                    })
                    saveBtn.removeAttribute('disabled')
                    saveBtn.classList.remove('opacity-25')
                }
            }
        </script>
    @endpush
</x-auth.authenticate>
