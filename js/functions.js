$(function () {
    $('#eingabe').submit(function () {
        var interpret = $("#eingabe_interpret").val();
        var titel = $("#eingabe_songtitel").val();
        if (interpret === "" && titel === "")
            return;
        var data = $('#eingabe :input').serializeArray();
        $.post($('#eingabe').attr('action'), data, function (info) {

            $('#songtext').html(info);
            var id = info.substring(0, info.length - 25);
            var file = 'http://localhost/netbeans/repertoire/html/main_table_row_template.html';
            $.get(file, function (data) {
                data = data.replace('{id}', id);
                data = data.replace('{id}', id);
                data = data.replace('{id}', id);
                data = data.replace('{Interpret}', interpret);
                data = data.replace('{Songtitel}', titel);
                data = data.replace('{Statusbar}', 'coming soon');
                data = data.replace('{Utilbar}', 'coming soon');

                $("tbody").last().append(data);
                $(".delbutton").last().on('click', function () {
                    del(this);

                });

            });



        });

        return false;
    });
    $('.delbutton').on('click', function () {
        del(this);

    });
    $('#upbutton').on('click', function() {
       $('#tabellenDiv').slideToggle(1000); 
    });
    function del(delbutton) {
        var id = $(delbutton).attr('data-id');
        var rowid = delbutton.parentNode.parentNode.rowIndex;
        document.getElementById("Table_Songlist").deleteRow(rowid);

        $.post('db/del.php', "id=" + id, function (info) {
            $('#songtext').html(info);
        });


    }
});

