$(document).ready(function(){
    $(".datatable").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
        }
    }); 

    $(".datatableOrder").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
        },
        "order":[[0,"desc"]]
    }); 
});