 {{-- CoreUI/Bootstrap: jQuery + Popper + Bootstrap must load before CoreUI (avoids NaN layout / SVG errors). --}}
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/js/select2.min.js') }}"></script>
    <!-- External SVG sprite support for <use xlink:href="...free.svg#..."> (legacy IE pattern; safe to keep last) -->
    <script src="{{ asset('vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>