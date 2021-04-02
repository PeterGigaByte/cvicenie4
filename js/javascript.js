$(document).ready(function() {
    $('#table').DataTable( {
        "paging": true,
        "searching": true,
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": true,
        pageLength: 15,
        "order": [[ 0, "desc" ]]

    } );
    $("#downloadCSV").click(function (){
        $.get("cURL.php", function(data, status){
            new jBox('Notice', {
                animation: 'flip',
                color: 'green',
                content: 'Csv súbory boli úspešne stiahnuté',
                delayOnHover: true,
                showCountdown: true
            });
        });
    });
});