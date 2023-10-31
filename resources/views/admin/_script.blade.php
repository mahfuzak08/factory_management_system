<!-- container-scroller -->
<!-- plugins:js -->
<button id="install-button" style="display: none;">Install App</button>

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
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                console.log('Service Worker registered with scope:', registration.scope);
            }).catch(function(error) {
                console.log('Service Worker registration failed:', error);
            });
        });
    }

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 76 and later from automatically showing the install prompt
        e.preventDefault();
        deferredPrompt = e;

        // Show a custom install button or similar if desired
        showInstallButton();
    });

    function showInstallButton() {
        // Assuming you have an install button element with id "install-button"
        const installButton = document.getElementById('install-button');

        // Show the install button
        installButton.style.display = 'block';

        // Add click event listener to the install button
        installButton.addEventListener('click', () => {
            // Hide the install button
            installButton.style.display = 'none';

            // Show the installation prompt
            deferredPrompt.prompt();

            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }

                // Reset the deferredPrompt variable
                deferredPrompt = null;
            });
        });
    }

</script>