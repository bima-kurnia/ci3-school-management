<script>
    // Init DataTables globally
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            responsive: true,
            pageLength: 10,
        });
    }

    // SweetAlert2 delete confirmation.
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e94560',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
</script>
</body>
</html>