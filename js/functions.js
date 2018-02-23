$(function () {
    $('#eingabe').hide();
    $('#songtext').hide();
    $('#youtubeplayerDiv').hide();
    $('#eingabe').submit(function () {
        var interpret = $("#eingabe_interpret").val();
        var titel = $("#eingabe_songtitel").val();
        if (interpret === "" && titel === "")
            return false;
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
                $("#eingabe_interpret").val("");
                $("#eingabe_songtitel").val("");

            });



        });

        return false;
    });
    $('.delbutton').on('click', function () {
        del(this);

    });
    $('#upbutton').on('click', function () {
        $('#eingabe').slideToggle(1000);
    });
    //show Songtext 
    $('.textbutton').on('click', function () {
        //zeile farbig als aktiv markieren
        mark($(this).parent().parent().parent());
        //songid holen
        var id = $(this).attr('data-id');
        //tabelle verstecken
        //$('.tablerow:not(.active)').slideToggle(1000, function () {
        $('#tabellenDiv').slideToggle(1000, function () {
            //song aus der datenbank holen
            $.post('db/getSongtext.php', "id=" + id, function (songtext) {
                if (songtext === "") {
                    var file = 'http://localhost/netbeans/repertoire/html/songtexteingabe.html';
                    $.get(file, function (data) {
                        songtext = data;
                    });
                }
                $('#songtext').hide();
                $('#songtext').html(songtext);
                $('#songtext').slideDown(1000);
                $('#upbutton').unbind('click');
                $('#upbutton').on('click', function () {
                    $('#songtext').slideUp(1000, function () {
                        $('#tabellenDiv').slideDown(1000);
                    });
                    $('#upbutton').unbind('click');
                    $('#upbutton').on('click', function () {
                        $('#eingabe').slideToggle(1000);
                    });
                });



                return false;
            });



        });

        return false;
    });
    $('.youtubebutton').on('click', function () {

        //zeile farbig als aktiv markieren
        mark($(this).parent().parent().parent());
        //songid holen
        var id = $(this).attr('data-id');
        //tabelle verstecken
        //$('.tablerow:not(.active)').slideToggle(1000, function () {
        $('#tabellenDiv').slideToggle(1000, function () {
            //link aus der datenbank holen
            $.post('http://localhost/netbeans/repertoire/db/getYoutubelink.php', "id=" + id, function (link) {
                $.get("html/youtubeplayer.html", function (youtubeplayer) {
                    youtubeplayer = youtubeplayer.replace("{youtubelink}", link);
                    $('#youtubeplayerDiv').html(youtubeplayer).fadeIn(5000);
                });
                return false;
            });
        });
        return false;
    });
    $('.tablerow').on('click', function () {
        mark(this);
    });
    $('.abspielbutton').on('click', function () {
        var id = $(this).attr('data-id');
        document.getElementById('abspielen' + id).play();
        $(this).unbind('click');
        $(this).on('click', function () {
            document.getElementById('abspielen' + id).stop();
            $(this).unbind('click');
            $(this).on('click', function () {
                document.getElementById('abspielen' + id).play();
            })
        });
        return false;
    });
    function del(delbutton) {
        var id = $(delbutton).attr('data-id');
        var rowid = delbutton.parentNode.parentNode.rowIndex;
        document.getElementById("Table_Songlist").deleteRow(rowid);

        $.post('db/del.php', "id=" + id, function (info) {
            $('#songtext').html(info);
        });


    }
    function mark(row) {
        $('.tablerow.active').removeClass('active');
        $(row).addClass('active');
    }
});

