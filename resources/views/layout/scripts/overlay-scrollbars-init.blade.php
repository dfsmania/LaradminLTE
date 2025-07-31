{{-- OverlayScrollbars plugin initialization script --}}
<script is:inline>

    document.addEventListener("DOMContentLoaded", function () {
        const sidebarWrapper = document.querySelector(".sidebar-wrapper");
        const osGlobal = OverlayScrollbarsGlobal;
        const osDefined = osGlobal?.OverlayScrollbars !== undefined;

        if (sidebarWrapper && osDefined) {
            osGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: "{{ $theme }}",
                    autoHide: "leave",
                    clickScroll: true
                }
            });
        }
    });

</script>
