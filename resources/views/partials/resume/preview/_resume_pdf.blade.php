<template x-if="totalPdfPages > 1">
    <div class="d-flex justify-content-between">
        <div><a class="text-dark fw-bold" x-show="pdfPageNum < totalPdfPages && pdfPageNum !== totalPdfPages" href=""
                x-on:click.prevent="pdfPageNum++">Next <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></div>
        <div x-text="`Page ${pdfPageNum} out of ${totalPdfPages}`"></div>
        <div><a class="text-dark fw-bold" x-show="pdfPageNum > 1 && pdfPageNum <= totalPdfPages" href=""
                x-on:click.prevent="pdfPageNum--"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Prev</a></div>
    </div>
</template>
<div class="d-flex justify-content-center mt-3">
    <canvas x-ref="pdfCanvas" height="0" width="0"></canvas>
</div>