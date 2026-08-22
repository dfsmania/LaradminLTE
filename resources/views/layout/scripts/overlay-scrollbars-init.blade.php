{{-- OverlayScrollbars plugin initialization script --}}
<script is:inline>

    /*
     * Initializes the OverlayScrollbars plugin on the sidebar wrapper element.
     */
    function initOverlayScrollbars() {
        // Get the sidebar wrapper element and check if OverlayScrollbars is
        // defined in the global scope. If either is not available, we exit the
        // function early.

        const sidebarWrapper = document.querySelector(".sidebar-wrapper");
        const osGlobal = globalThis.OverlayScrollbarsGlobal;
        const overlayScrollbars = osGlobal?.OverlayScrollbars;

        if (!sidebarWrapper || !overlayScrollbars) {
            return;
        }

        // If an OverlayScrollbars instance already exists on the sidebar
        // wrapper, we destroy it to avoid duplicate instances.

        const osInstance = overlayScrollbars(sidebarWrapper);

        if (osInstance) {
            osInstance.destroy();
        }

        // Initialize a new OverlayScrollbars instance on the sidebar wrapper
        // element with the specified options.

        overlayScrollbars(sidebarWrapper, {
            scrollbars: {
                theme: @json($theme),
                autoHide: "leave",
                clickScroll: true
            }
        });
    }

    // Check if OverlayScrollbars is already loaded in the global scope. If it
    // is, initialize it immediately. If not, wait for the window load event to
    // ensure all the scripts are fully loaded before initializing.

    if (globalThis.OverlayScrollbarsGlobal) {
        initOverlayScrollbars();
    } else {
        window.addEventListener("load", initOverlayScrollbars, {
            once: true
        });
    }

</script>
