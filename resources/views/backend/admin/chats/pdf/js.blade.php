<script>
    "use strict";

    document.getElementById('pdfFile').addEventListener('change', function () {

        // Clear any previous content in the vision_image element
        let fileNameDisplay = document.getElementById('vision_image');
        fileNameDisplay.innerHTML = '';

        // Get the selected file
        let file = this.files[0];

        // Update the path to the PDF icon accordingly
        let pdfSvg = "{{ asset('img/pdf-icon.svg') }}";

        // Check if a file is selected
        if (file) {
            // Display the selected PDF file's name along with an icon
            fileNameDisplay.innerHTML = 'Selected xrPDF: ' + file.name + ' <img src="' + pdfSvg + '" loading="lazy" alt="Icon Not Found." />';
        } else {
            // Display a message if no PDF is selected
            fileNameDisplay.innerHTML = 'No PDF selected';
        }
    });
</script>