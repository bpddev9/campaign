<x-auth.authenticate>
    @push('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush

    <div @if (auth()->user()->role === 'applicant') x-cloak x-data="{ ...state() }" @endif>
        <div class="login-wapper" data-resume="{{ auth()->user()->resume }}">
            <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
            @if (auth()->user()->role === 'applicant')
                <ul>
                    <li><a href="{{ route('jobs.listing') }}">All Jobs</a></li>
                    <li><a href="{{ route('applied.job') }}">Applied Jobs</a></li>
                    <li><a href="{{ route('my.profile') }}">Edit Profile</a></li>
                    <li><a href="{{ route('manage.resume') }}">Resume Management</a></li>
                    <template x-if="userResume != null">
                        <li>
                            <a href="" data-bs-toggle="modal" data-bs-target="#docPreview">Preview Resume</a>
                        </li>
                    </template>
                </ul>
            @else
                <ul>
                    <li><a href="{{ route('company.profile') }}">Profile Management</a></li>
                    <li><a href="{{ route('jobs.menu') }}">Job Management</a></li>
                    <li><a href="{{ route('job.applicants') }}">Applicant Management</a></li>
                </ul>
            @endif
        </div>
        <!-- Resume preview modal -->
        @if (auth()->user()->role === 'applicant')
        <x-resume-preview-modal>
            <!-- Preview Resume in DOCX Format -->
            <div x-ref="docxResume" x-show="userResume.mime_type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'"></div>

            <!-- Preview Resume in PDF Format -->
            <div x-ref="pdfResume" x-show="userResume.mime_type === 'application/pdf'">
                @include('partials.resume.preview._resume_pdf')
            </div>

            <!-- Preview Resume in TXT Format -->
            <div x-ref="txtResume" x-show="userResume.mime_type === 'text/plain'" class="p-2"></div>
        </x-resume-preview-modal>
        @endif
        <!-- Resume preview modal -->
    </div>

    @if (auth()->user()->role === 'applicant')
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.5.141/build/pdf.min.js" defer></script>
        <script defer>
            function state() {
                return {
                    userResume: null,
                    pdfPageNum: 1,
                    totalPdfPages: 1,
                    reader: new FileReader(),

                    init() {
                        const modalElmt = document.querySelector('#docPreview')
                        this.userResume = JSON.parse(document.querySelector('.login-wapper').dataset.resume)

                        modalElmt.addEventListener("show.bs.modal", () => {
                            let {mime_type} = this.userResume

                            switch (mime_type) {
                                case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                                    this.getDocxResume()
                                    break;

                                case "application/pdf":
                                    this.getPdfResume(this.pdfPageNum)
                                    break;

                                case "text/plain":
                                    this.getTxtResume()
                                    break;

                                default:
                                    break;
                            }
                        })

                        modalElmt.addEventListener("hidden.bs.modal", () => {
                            let {mime_type} = this.userResume

                            switch (mime_type) {
                                case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                                    document.getElementById('docx-resume').remove()
                                    break;

                                case "text/plain":
                                    break;

                                case "application/pdf":
                                    if (this.$refs.pdfCanvas !== undefined || this.$refs.pdfCanvas !== null) {
                                        let context = this.$refs.pdfCanvas.getContext('2d')
                                        context.clearRect(0, 0, context.canvas.width, context.canvas.height)
                                    }

                                    if (this.pdfPageNum > 1) {
                                        this.pdfPageNum = 1
                                    }
                                    break;

                                default:
                                    break;
                            }
                        })

                        this.$watch('pdfPageNum', (value) => {
                            this.getPdfResume(value)
                        })
                    },

                    async getDocxResume() {
                        let { file_path } = this.userResume
                        let ResumeEl = document.createElement('div')
                        let filePath = `${window.location.origin}/storage/${file_path}`

                        ResumeEl.setAttribute('id', 'docx-resume')

                        try {
                            let fileData = await fetch(`${window.location.origin}/storage/${this.userResume.file_path}`)
                            let docxData = await fileData.blob()
                            await window.docx.renderAsync(docxData, ResumeEl)
                            this.$refs.docxResume.appendChild(ResumeEl)
                        } catch (error) {
                            console.log(error);
                        }
                    },

                    getPdfResume(pageNum) {
                        let { file_path } = this.userResume
                        let filePath = `${window.location.origin}/storage/${file_path}`

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
                            }).catch(error => {
                                //
                            })
                        })
                    },

                    async getTxtResume() {
                        let { file_path, mime_type, file_name } = this.userResume

                        try {
                            let fileData = await fetch(`${window.location.origin}/storage/${file_path}`)
                            let textData = await fileData.blob()

                            let file = new File([textData], file_name, {type: mime_type})
                            this.reader.readAsText(file)

                            this.reader.onload = () => {
                                this.$refs.txtResume.innerText = this.reader.result
                            }
                        } catch (error) {
                            console.log(error);
                        }
                    },
                }
            }
        </script>
    @endpush
    @endif
</x-auth.authenticate>
