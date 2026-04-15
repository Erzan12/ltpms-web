<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    });
});
</script>
@endif


@if (session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: @json(session('error')),
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    });
});
</script>
@endif


@if (session('info'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: @json(session('info')),
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    });
});
</script>
@endif


@if (session('warning'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'warning',
        title: @json(session('warning')),
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    });
});
</script>
@endif