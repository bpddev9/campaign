import './bootstrap';

import 'slick-carousel';
import 'jquery-mask-plugin';

import { Modal, Tooltip, Toast } from 'bootstrap';
import * as docx from 'docx-preview';

window.docx = docx

const modalElemnt = document.getElementById('myModal')
const resumeModal = document.getElementById('docPreview')
const toastElemnt = document.querySelector('.toast')
const toolTipElem = document.querySelectorAll('[data-bs-toggle="tooltip"]')

if (modalElemnt) {
    window.myModal = new Modal(modalElemnt, { backdrop: 'static' })
}

if (resumeModal) {
    window.previewModal = new Modal(resumeModal, { backdrop: 'static' })
}

if (toastElemnt) {
    window.MyToast = new Toast(toastElemnt, { delay: 2000 })
}

if (toolTipElem.length) {
    let tooltipElements = Array.from(toolTipElem)
    let myToolTip = tooltipElements.map((el) => new Tooltip(el))
    window.myToolTip = myToolTip
}