<x-auth.authenticate>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.5.141/web/pdf_viewer.min.css">
        <style>
            [x-cloak] {
                display: none !important;
            }

            .drop-area {
                border: 2px dashed #ccc;
                border-radius: 20px;
                font-family: sans-serif;
                margin: 50px auto;
            }

            .drop-area.highlight {
                border-color: purple;
            }

            p {
                margin-top: 0;
            }

            .my-form {
                margin-bottom: 10px;
            }

            #gallery {
                margin-top: 10px;
            }

            #gallery img {
                width: 150px;
                margin-bottom: 10px;
                margin-right: 10px;
                vertical-align: middle;
            }

            .button {
                display: inline-block;
                background: #ccc;
                cursor: pointer;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            .button:hover {
                background: #ddd;
            }

            .fileElem {
                display: none;
            }

            .processing {
                opacity: 0.45;
            }
        </style>
    @endpush
    <div class="arrow">
        <a href="{{ route('manage.resume') }}"></a>
    </div>
    <div x-data="{ ...resumeUpload() }" x-cloak>
        <div class="login-wapper">
            <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
            <h5>Upload your resume</h5>

            <div x-ref="dropArea" class="drop-area p-5" x-on:dragover.prevent="dragOverFile"
                x-on:dragleave.prevent="dragLeft" x-on:drop.prevent="triggerUpload(event)"
                x-bind:class="processing ? 'processing' : ''">
                <p class="fs-6">Drop files here to upload</p>
                <input type="file" class="fileElem" x-on:change="fileSelect(event)" id="fileElem"
                    x-bind:disabled="processing" />
                <label class="button p-2 mt-3" for="fileElem">Select file</label>
            </div>

            <template x-if="userResume">
                <ul>
                    <li>
                        <a href="" data-bs-toggle="modal" data-bs-target="#docPreview">Preview Resume</a>
                    </li>
                </ul>
            </template>

            <template x-if="processing">
                <span class="help-block mt-3 fs-5 text-light"
                    x-html="`<i class='fa fa-refresh fa-spin fa-1x fa-fw'></i> Upload in progress. Please wait...`"></span>
            </template>
            <template x-if="msg.errorMsg">
                <span class="help-block mt-3 fs-5 fw-700 text-warning"
                    x-html="`<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ${msg.errorMsg}`"></span>
            </template>
            <template x-if="msg.successMsg">
                <span class="help-block mt-3 fs-5 fw-700 text-light"
                    x-html="`<i class='fa fa-check-circle' aria-hidden='true'></i> ${msg.successMsg}`"></span>
            </template>
        </div>
        <!-- Document Review Modal -->
        <x-resume-preview-modal>
            <div x-ref="docxResume"
                x-show="mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'"></div>
            <div x-ref="pdfResume" x-show="mimeType === 'application/pdf'">
                @include('partials.resume.preview._resume_pdf')
            </div>
            <div x-ref="txtResume" x-show="mimeType === 'text/plain'" class="p-2"></div>
        </x-resume-preview-modal>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.5.141/build/pdf.min.js" defer></script>
        <script defer>
            function resumeUpload() {
                return {
                    userResume: null,
                    msg: {
                        errorMsg: '',
                        successMsg: '',
                    },
                    processing: false,
                    formData: new FormData(),
                    mimeType: '',
                    pdfPageNum: 1,
                    totalPdfPages: 1,
                    reader: new FileReader(),

                    init() {
                        this.fetchResume()
                        const modalElm = this.$refs.docPreview

                        this.$watch('msg', () => {
                            setTimeout(() => {
                                Object.keys(this.msg).forEach(item => {
                                    if (this.msg[item] !== '') {
                                        this.msg[item] = ''
                                    }
                                })
                            }, 2000);
                        })

                        this.$watch('pdfPageNum', (value) => {
                            this.getPdfResume(value)
                        })

                        modalElm.addEventListener('show.bs.modal', (event) => {
                            this.mimeType = this.userResume.mime_type

                            if (this.mimeType ===
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                                this.getDocxResume()
                            }

                            if (this.mimeType === 'application/pdf') {
                                this.getPdfResume(this.pdfPageNum)
                            }

                            if (this.mimeType === 'text/plain') {
                                this.getTxtResume()
                            }
                        });

                        modalElm.addEventListener('hidden.bs.modal', (event) => {
                            if (this.$refs.pdfCanvas !== undefined || this.$refs.pdfCanvas !== null) {
                                let context = this.$refs.pdfCanvas.getContext('2d')
                                context.clearRect(0, 0, context.canvas.width, context.canvas.height)
                            }

                            if (this.mimeType === 'application/pdf') {
                                if (this.pdfPageNum > 1) {
                                    this.pdfPageNum = 1
                                }
                            }
                        })
                    },

                    dragOverFile() {
                        this.$refs.dropArea.classList.add('highlight')
                    },

                    dragLeft() {
                        this.$refs.dropArea.classList.remove('highlight')
                    },

                    fileSelect(event) {
                        this.fileUpload(event.target.files[0])
                    },

                    triggerUpload(event) {
                        this.$refs.dropArea.classList.remove('highlight')
                        let {
                            files
                        } = event.dataTransfer
                        if (files.length > 1) {
                            this.msg.errorMsg = "You're only allowed to upload one file"
                            return
                        }
                        this.fileUpload(files[0])
                    },

                    async fetchResume() {
                        let response = await fetch("{{ route('resume.fetch') }}")
                        response = await response.json()
                        this.userResume = response.data
                    },

                    async fileUpload(param) {
                        this.processing = true
                        this.formData.append('file', param)
                        this.formData.append('upload_id', "{{ optional(auth()->user()->resume)->id }}")

                        try {
                            let response = await window.axios.post("{{ route('resume.upload.store') }}", this.formData)
                            this.msg.successMsg = response.data.message
                            this.userResume = response.data.data
                            this.mimeType = this.userResume.mime_type
                        } catch (error) {
                            this.msg.errorMsg = error.response.data.message
                        }

                        this.processing = false
                    },

                    async getDocxResume() {
                        let ResumeEl = document.createElement('div')
                        ResumeEl.setAttribute('id', 'docx-resume')

                        let fileData = await fetch(`${window.location.origin}/storage/${this.userResume.file_path}`)
                        let docxData = await fileData.blob()
                        await window.docx.renderAsync(docxData, ResumeEl)
                        this.$refs.docxResume.appendChild(ResumeEl)
                    },

                    getPdfResume(pageNum) {
                        let filePath = `${window.location.origin}/storage/${this.userResume.file_path}`
                        let canvasContext = this.$refs.pdfCanvas.getContext("2d")

                        pdfjsLib.getDocument(filePath).promise.then(pdf => {
                            this.totalPdfPages = pdf._pdfInfo.numPages
                            pdf.getPage(pageNum).then(page => {
                                let pageViewPort = page.getViewport({
                                    scale: 1
                                })
                                this.$refs.pdfCanvas.width = pageViewPort.width
                                this.$refs.pdfCanvas.height = pageViewPort.height
                                page.render({
                                    canvasContext,
                                    viewport: pageViewPort
                                })
                            })
                        }).catch(error => {
                            //
                        })
                    },

                    async getTxtResume() {
                        let fileData = await fetch(`${window.location.origin}/storage/${this.userResume.file_path}`)
                        let textData = await fileData.blob()
                        
                        let file = new File([textData], this.userResume.file_name, {type: this.userResume.mime_type})
                        this.reader.readAsText(file)

                        this.reader.onload = () => {
                            this.$refs.txtResume.innerText = this.reader.result
                        }
                    },
                }
            }
        </script>
    @endpush
</x-auth.authenticate>
