import * as pdfjsLib from "pdfjs-dist";

// Atur PDF.js worker src sesuai versi
pdfjsLib.GlobalWorkerOptions.workerSrc =
    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js";

function renderPDF(url) {
    const loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise
        .then(function (pdf) {
            console.log("PDF loaded");

            // Fetch the first page
            pdf.getPage(1).then(function (page) {
                console.log("Page loaded");

                const scale = 1.5;
                const viewport = page.getViewport({ scale: scale });

                // Prepare canvas using PDF page dimensions
                const canvas = document.getElementById("pdf-render");
                const context = canvas.getContext("2d");
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                };
                const renderTask = page.render(renderContext);
                renderTask.promise.then(function () {
                    console.log("Page rendered");
                });
            });
        })
        .catch(function (reason) {
            console.error(reason);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    const pdfUrl = document
        .getElementById("pdf-container")
        .getAttribute("data-pdf-url");
    renderPDF(pdfUrl);

    // Prevent text selection and copying
    document.addEventListener("copy", function (e) {
        e.preventDefault();
        console.log("Penyalinan teks tidak diizinkan.");
    });

    document.addEventListener("contextmenu", function (e) {
        e.preventDefault();
        console.log("Klik kanan tidak diizinkan.");
    });

    // Prevent download via URL
    document.addEventListener("keydown", function (e) {
        if (e.ctrlKey && (e.key === "s" || e.key === "p")) {
            e.preventDefault();
            console.log("Fungsi simpan dan cetak dinonaktifkan.");
        }
    });

    // Warn user if they try to switch tabs
    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            alert("Anda tidak dapat beralih tab saat melihat PDF.");
        }
    });
});
