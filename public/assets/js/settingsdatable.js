$('#tableui').DataTable({
    // 'ajax': '../assets/data/datatable-arrays.txt',
    language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
        select: true
    }


});
$(document).ready(function() {
    $('tableui').DataTable();
});