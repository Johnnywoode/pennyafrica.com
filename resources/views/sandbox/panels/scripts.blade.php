<!--begin::Script-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
<!--end::Third Party Plugin(OverlayScrollbars)-->
<!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<!--end::Required Plugin(popperjs for Bootstrap 5)-->
<!--begin::Required Plugin(Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>

<!-- jQuery -->
<script src="{{ asset('app/plugins/jquery/jquery.min.js') }}"></script>

<!--end::Required Plugin(Bootstrap 5)-->
<!--begin::Required Plugin(AdminLTE)-->
<script src="{{ asset('app/js/adminlte/adminlte.min.js') }}"></script>
<!--end::Required Plugin(AdminLTE)-->

<script src="{{ asset('app/js/sweetalert/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('app/js/font-awesome/all.min.js') }}"></script>

<script src="{{ asset('app/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('hfhggh') }}" crossorigin="anonymous"></script>

<!--begin::OverlayScrollbars Configure-->
<script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
</script>
<!--end::OverlayScrollbars Configure-->
<!-- OPTIONAL SCRIPTS -->
<!-- sortablejs -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
    integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script>
<!-- sortablejs -->
<script>
    const connectedSortables = document.querySelectorAll('.connectedSortable');
    connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
            group: 'shared',
            handle: '.card-header',
        });
    });

    const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
    cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
    });


    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        grow: 'row',
        timerProgressBar: true,
        timer: 3000
    });

    //icon => ['success', 'error', 'warning', 'info', 'qquestion']
    function showToast(icon, title, text = '') {
        Toast.fire({
            icon: icon,
            title: title,
            text: text
        })
    }
</script>

@if (Session::has('message'))
    <script>
        let type = "{{ Session::get('status', 'success') }}",
            message = "{!! Session::get('message') !!}",
            catchPhraseArray = [];
        catchPhraseArray["info"] = "info"
        catchPhraseArray["warning"] = "warning"
        catchPhraseArray["success"] = "success"
        catchPhraseArray["error"] = "error"
        catchPhraseArray["question"] = "question"
        showToast(type, message)
    </script>
@endif

<script>
    $(document).ready(function() {
        $('.phone').on('input', function() {
            let phone = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters

            // Handle phone number based on starting digit
            if (phone.startsWith('0')) {
                phone = phone.substring(1, 11); // Remove leading 0 and limit to 10 digits
            } else {
                phone = phone.substring(0, 9); // Limit to 9 digits
            }

            $(this).val(phone); // Update the input field

            // Show error notification if the phone number is invalid
            if ((phone.length === 9 && !phone.startsWith('0')) || phone.length > 10) {
                showToast('warning',
                    "{{ __('validation.max_digits', ['attribute' => 'phone', 'max' => 9]) }}");
            }
        })
    })
</script>

@yield('page_script')
