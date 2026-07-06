{{-- OverlayScrollbars plugin initialization script --}}
<script is:inline>

    initOverlayScrollbars();

    /*
     * Initializes the OverlayScrollbars plugin on the sidebar wrapper element.
     */
    function initOverlayScrollbars() {
        // Get the sidebar wrapper element and check if OverlayScrollbars is
        // defined in the global scope.

        const sidebarWrapper = document.querySelector(".sidebar-wrapper");
        const osGlobal = OverlayScrollbarsGlobal;
        const osDefined = osGlobal?.OverlayScrollbars !== undefined;

        if (sidebarWrapper && osDefined) {
            // Destroy any existing OverlayScrollbars instance on the sidebar
            // wrapper.

            if (osGlobal.OverlayScrollbars(sidebarWrapper)) {
                osGlobal.OverlayScrollbars(sidebarWrapper).destroy();
            }

            // Initialize a new OverlayScrollbars instance on the sidebar
            // wrapper.

            osGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: "{{ $theme }}",
                    autoHide: "leave",
                    clickScroll: true
                }
            });
        }
    }

</script>
