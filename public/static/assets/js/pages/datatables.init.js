$(document).ready(function(){$(".datatable").DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
    }
} ),$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")});