@extends('layouts.app')
@section('title', 'Attendees')

@section('page_styles')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<!-- DataTables Buttons CSS -->
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="col-12 mb-2">
    <div class="col">
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#addAttendeeModal">
                <i class="bi bi-plus-circle"></i> New
            </button>
            <button type="button" class="btn btn-indigo btn-sm" data-bs-toggle="modal"
                data-bs-target="#importAttendeeModal">
                <i class="bi bi-file-earmark-arrow-up"></i> Import
            </button>
        </div>
    </div>
</div>
<div class="card p-2">
    <table id="attendees-datatable" class="table table-sm table-striped table-hover display" style="width: 100%">
        <thead>
            <tr>
                {{-- <th><input type="checkbox" id="select-all"></th> --}}
                <th></th>
                <th></th>
                <th>ID</th>
                <th>Title</th>
                <th>Gender</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

{{-- @include('admin.attendees._create_modal')
@include('admin.attendees._import_modal')
@include('admin.attendees._edit_modal') --}}

@endsection


@section('page_script')

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
            // const table = $('#attendees-datatable').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: {
            //         url: "{{ route(config('app.admin_path') .'.users.search') }}",
            //         type: "POST",
            //         data: function (d) {
            //             d._token = "{{ csrf_token() }}"; // Include CSRF token for Laravel
            //         },
            //     },
            //     columns: [
            //         {"data": 'responsive_id', orderable: false, searchable: false,
            //         render: function () {
            //         return '<input type="checkbox" class="row-checkbox">';
            //         },},
            //         {"data": "uuid", visible: false},
            //         {"data": "uuid", "render": function (data, type, row) {
            //             return `<a href="${row.show}" class="btn btn-link btn-sm">${data}</a>`;
            //         }},
            //         {"data": "title"},
            //         {"data": "gender", className: 'text-center'},
            //         {"data": "first_name"},
            //         {"data": "last_name"},
            //         {"data": "email"},
            //         {"data": "phone"},
            //         {"data": "date"},
            //         {"data": "action", orderable: false, searchable: false, className: 'text-center', "render": function (data, type, row) {
            //             return `
            //                 <div class="btn-group" role="group">
            //                     <a href="${row.show}" class="btn btn-sm btn-primary" title="View"><i class="bi bi-eye px-2"></i> </a>

            //                     <button class="btn btn-sm btn-warning edit-btn" data-uuid="${row.uuid}">
            //                         <i class="bi bi-pencil px-2"></i>
            //                     </button>

            //                     <button class="btn btn-sm btn-success check-in" data-id="${row.uuid}" title="Check-In"><i class="bi bi-check px-2"></i> </button>
            //                 </div>
            //             `;
            //         }}
            //     ],
            //     searchDelay: 1500,
            //     order: [[8, 'desc']], // Default sorting by 'date' column
            //     responsive: true, // Enables responsive design
            //     lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Entries dropdown
            //     language: {
            //         paginate: {
            //             previous: '<i class="fas fa-angle-left"></i>',
            //             next: '<i class="fas fa-angle-right"></i>',
            //         },
            //         search: '<i class="fas fa-search"></i>',
            //         searchPlaceholder: 'Search attendees...',
            //     },
            //     dom: '<"row mb-3"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4 justify-content-center"B><"col-sm-12 col-md-4 text-end"f>>' +
            //         '<"table-responsive"tr>' +
            //         '<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            //     buttons: [
            //         {
            //             extend: 'copy',
            //             className: 'btn btn-light btn-outline-primary btn-sm',
            //             text: '<i class="bi bi-clipboard"></i> Copy',
            //             exportOptions: { columns: ':visible:not(:last-child)' },
            //         },
            //         {
            //             extend: 'csv',
            //             className: 'btn btn-light btn-outline-secondary btn-sm',
            //             text: '<i class="bi bi-file-earmark"></i> CSV',
            //             exportOptions: { columns: ':visible:not(:last-child)' },
            //         },
            //         {
            //             extend: 'pdf',
            //             className: 'btn btn-light btn-outline-danger btn-sm',
            //             text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
            //             exportOptions: { columns: ':visible:not(:last-child)' },
            //         },
            //         {
            //             extend: 'excel',
            //             className: 'btn btn-light btn-outline-success btn-sm',
            //             text: '<i class="bi bi-file-earmark-excel"></i> Excel',
            //             exportOptions: { columns: ':visible:not(:last-child)' },
            //         },
            //         {
            //             extend: 'print',
            //             className: 'btn btn-light btn-outline-info btn-sm',
            //             text: '<i class="bi bi-printer"></i> Print',
            //             exportOptions: { columns: ':visible:not(:last-child)' },
            //         },
            //     ],
            //     initComplete: function () {
            //         const searchBox = $('.dataTables_filter input[type="search"]');
            //         searchBox.addClass('form-control form-control-sm').attr('placeholder', 'Search...');
            //     },
            // });

            // Add buttons to DataTable DOM
            // table.buttons().container().appendTo('#attendees-datatable_wrapper .col-md-6:eq(1)');

            // $("body").on('click', 'button.edit-btn', function (e) {
            //     const rowData = table.row($(this).closest('tr')).data(),
            //         formActionUrl = "{{ url('admin/attendees') }}" + '/' + rowData.uuid;

            //     $('#edit-attendee-form').attr('action', formActionUrl);
            //     $('#title-uuid').text(rowData.uuid);
            //     $('#attendee-uuid').val(rowData.uuid);
            //     $('#attendee-title').val(rowData.title);
            //     $('#attendee-gender').val(rowData.gender);
            //     $('#attendee-first-name').val(rowData.first_name);
            //     $('#attendee-last-name').val(rowData.last_name);
            //     $('#attendee-email').val(rowData.email);
            //     $('#attendee-phone').val(rowData.phone);

            //     $('#editAttendeeModal').modal('show');

            // });

            // $("body").on('click', 'button.check-in', function (e) {
            //     const attendeeId = $(this).data('id');
            //     $.ajax({
            //         url: "{{url('admin/attendees/checkin')}}" + "/" + attendeeId,
            //         type: 'POST',
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //         },
            //         success: function (response) {
            //             alert('Attendee checked in successfully!');
            //             // Optionally, refresh the table
            //             $('#attendees-datatable').DataTable().ajax.reload();
            //         },
            //         error: function (xhr) {
            //             alert('Failed to check in attendee.');
            //         }
            //     });
            // });

            // $('#download-sample-btn, #extension-form-close-btn').on('click', function () {
            //     $('#extension-form, #extension-form-close-btn').slideToggle(500);
            // });


        });

</script>
@endsection
