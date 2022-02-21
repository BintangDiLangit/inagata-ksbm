    <!-- CoreUI and necessary plugins-->

    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>

    <!-- We use those scripts to show code examples, you should remove them in your application.-->

    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/prism.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/unescaped-markup/prism-unescaped-markup.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/normalize-whitespace/prism-normalize-whitespace.js">
    </script>

    <!-- Plugins and scripts required by this view-->
    {{-- <script src="{{ asset('vendors/chart.js/js/chart.min.js') }}"></script> --}}

    <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/utils/js/coreui-utils.js') }}"></script>

    {{-- <script src="{{ asset('js/main.js') }}"></script> --}}

    @stack('js')
