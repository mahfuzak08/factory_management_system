<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset('admin/assets/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('admin/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset('admin/assets/js/off-canvas.js')}}"></script>
<script src="{{asset('admin/assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('admin/assets/js/misc.js')}}"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{asset('admin/assets/js/dashboard.js')}}"></script>
<script src="{{asset('admin/assets/js/todolist.js')}}"></script>
<!-- End custom js for this page -->
<script>
    var printButton = document.getElementById("printButton");
    var printableContent = document.querySelector(".printable-content");

    printButton.addEventListener("click", function() {
        // Clone the printable content div to avoid modifying the original content
        var printableContentClone = printableContent.cloneNode(true);

        // Create a new window and append the cloned content to it
        var printWindow = window.open('', '_blank');
        printWindow.document.body.appendChild(printableContentClone);

        // Link the print.css file for styling the print layout
        var cssLink = printWindow.document.createElement("link");
        cssLink.href = "path/to/print.css"; // Specify the correct path to your print.css file
        cssLink.rel = "stylesheet";
        printWindow.document.head.appendChild(cssLink);

        // Print the new window
        printWindow.print();
    });
</script>