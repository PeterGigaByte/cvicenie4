$(document).ready(function() {
    let loading = $("#loading");
    let overlay = $("#overlay");
    $('#table').DataTable( {
        columnDefs: [ {
            targets: [ 4 ],
            orderData: [4, 2 ]
        }],
        "scrollX": true,
        "paging": true,
        "searching": true,
        "bPaginate": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": true,
        pageLength: 10,
        "order": [[ 1, "asc" ]],

    } );
    $("#downloadCSV").click(function (){
        new jBox('Notice', {
            attributes: {
                x: 'right',
                y: 'bottom'
            },
            stack: false,
            animation: {
                open: 'tada',
                close: 'zoomIn'
            },
            color: "white",
            title: "Sťahovanie",
            content: "Csv súbory sa sťahujú."
        });
        loading.addClass("visible");
        overlay.addClass("visible");
        $.ajax({
            type : "GET",
            url : "cURL.php",
            success: function(result){
                new jBox('Notice', {
                    animation: 'flip',
                    color: 'green',
                    content: 'Csv súbory boli úspešne stiahnuté.',
                    delayOnHover: true,
                    showCountdown: true
                });
            },
            complete: function (){
                loading.removeClass("visible");
                overlay.removeClass("visible");
            },
            error : function(e) {
                new jBox('Notice', {
                    animation: 'flip',
                    color: 'red',
                    content: 'Pri sťahovaní nastala chyba !!',
                    delayOnHover: true,
                    showCountdown: true
                });
                console.log(e)
            }
        });
    });
    $("#refreshDBS").click(function (){
        new jBox('Notice', {
            attributes: {
                x: 'right',
                y: 'bottom'
            },
            stack: false,
            animation: {
                open: 'tada',
                close: 'zoomIn'
            },
            color: "white",
            title: "Refresh",
            content: "Refresh databázy bol zahájený."
        });
        loading.addClass("visible");
        overlay.addClass("visible");
        $.ajax({
            type : "GET",
            url : "refreshDBS.php",
            success: function(result){
                new jBox('Notice', {
                    animation: 'flip',
                    color: 'green',
                    content: 'Refresh databázy prebehol úspešne.',
                    delayOnHover: true,
                    showCountdown: true
                });
            },
            complete: function (){
                loading.removeClass("visible");
                overlay.removeClass("visible");
            },
            error : function(e) {
                new jBox('Notice', {
                    animation: 'flip',
                    color: 'red',
                    content: 'Refresh databázy bol neúspešný !!',
                    delayOnHover: true,
                    showCountdown: true
                });
                console.log(e)
            }
        });
    });
    $("#refreshTABLE").click(function (){
        location.reload()
    });
});