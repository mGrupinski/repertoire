$(function () {
    initFlagsettingButton();
    initFlagtoggle();
    initFlagButtons();
    initFilterButton();
    initFiltersettingButton();
    initNewSongSubmit();
    bindUpbuttonToNewSong();
    initDelButtons();
    initTextButtons();
    initYoutubeButtons();
    initTablerowMark();
    initPlayButtons();
    initLinkSubmit();

});
function initFlagButtons() {
    $(".statusbutton[data-a='added']").on('click', function () {

    });
}
function initTextButtons() {
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
                renameHeader(id);
                if (!songtext) {
                    $('#Songtext_Eingabe').slideDown(1000);
                    bindUpbuttonToReturnToSonglist('Songtext_Eingabe', function () {
                        songtext = $('#Eingabe_Songtext').val();
                        $.post("db/setSongtext.php", {"text": songtext, "id": id}, function (data) {
                            $('#Eingabe_Songtext').val("");
                        });
                    });
                    return false;
                }
                $('#songtext').hide();
                $('#songtext').html(songtext);
                $('#songtext').slideDown(1000);
                bindUpbuttonToReturnToSonglist('songtext', function () {});
                return false;
            });
        });
        return false;
    });

}
function initYoutubeButtons() {
    $('.youtubebutton').on('click', function () {
//zeile farbig als aktiv markieren
        mark($(this).parent().parent().parent());
        //songid holen
        var id = $(this).attr('data-id');
        $.post('http://localhost/netbeans/repertoire/db/getYoutubelink.php', "id=" + id, function (link) {
            if (!link) {
                $('#eingabe_linkDiv' + id).slideToggle();
                return false;
            }
            $('#tabellenDiv').slideToggle(1000, function () {
                $.get("html/youtubeplayer.html", function (youtubeplayer) {
                    renameHeader(id);
                    youtubeplayer = youtubeplayer.replace("{youtubelink}", link);
                    $('#youtubeplayerDiv').html(youtubeplayer).fadeIn();
                    bindUpbuttonToReturnToSonglist('youtubeplayerDiv', function () {});
                });
                return false;
            });
        });
        return false;
    });
}
function initLinkSubmit() {
    $('.eingabe_link').keyup(function (e) {
        if (e.keyCode == 13) {
            var id = $(this).attr('data-id');
            var link = $(this).val();
            $.post("db/setYoutubelink.php", {"link": link, "id": id}, function (data) {
                return false;
            });
            $(this).hide();
            return false;
        }
    });
}
function initTablerowMark() {
    $('.tablerow').on('click', function () {
        mark(this);
    });
}
function initPlayButtons() {
    $('.abspielbutton').on('click', function () {
        //zeile farbig als aktiv markieren
        mark($(this).parent().parent().parent());
        var id = $(this).attr('data-id');
        if ($('#abspielen' + id).get(0).paused) {
            $('#abspielen' + id).get(0).play();
        } else {
            $('#abspielen' + id).get(0).pause();
        }
    });

}

function initDelButtons() {
    $('.delbutton').on('click', function () {
        del(this);
    });

}
function initFlagtoggle() {
    $(".statusbutton[data-a='all']").on('click', function () {
        var type = $(this).attr('data-type');
        var id = $(this).attr('data-id');
        $.post('db/toggleFlag.php', {"type": type, "id": id}, function () {
            $('.' + type + "button" + id + "[data-a='added']").toggle();
        });
    });
}
function initFlagsettingButton() {
    $('.statussettings').on('click', function () {
        var id = $(this).attr('data-id');
        $(".statusbutton[data-id=" + id + "][data-a='all']").toggle();
    });
}
function initNewSongSubmit() {
    $('#eingabe').submit(function () {
        var interpret = $("#eingabe_interpret").val();
        var titel = $("#eingabe_songtitel").val();
        if (!titel.trim()) {
            return false;
        }
        var data = $('#eingabe :input').serializeArray();
        $.post($('#eingabe').attr('action'), data, function (info) {
            $('#songtext').html(info);
            var id = info.substring(0, info.length - 25);
            var file = 'http://localhost/netbeans/repertoire/html/main_table_row_template.html';
            $.get(file, function (data) {
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

}
function bindUpbuttonToReturnToSonglist(divToHide, callback) {
    $('#eingabe').hide();
    $('#upbutton').unbind('click');
    $('#upbutton').on('click', function () {
        $('#' + divToHide).slideUp(1000, function () {
            $('#tabellenDiv').slideDown(1000);
            renameHeader();
            callback();
            bindUpbuttonToNewSong();
        });

    });
}
function bindUpbuttonToNewSong() {
    $('#upbutton').unbind('click');
    $('#upbutton').on('click', function () {
        $('#eingabe').slideToggle(1000);
    });

}
function del(delbutton) {
    var id = $(delbutton).attr('data-id');
    var rowid = delbutton.parentNode.parentNode.rowIndex;
    document.getElementById("Table_Songlist").deleteRow(rowid);
    $.post('db/del.php', "id=" + id, function (info) {
        $('#songtext').html(info);
    });
}
function renameHeader(id = - 1) {
    if (id == -1) {
        $('#songtitel').html("Songtitel");
        $('#interpret').html("Interpret");
        return;
    }
    $.post('db/getSongtitel.php', "id=" + id, function (info) {
        $('#songtitel').html(info.split(" - ")[1]);
        $('#interpret').html(info.split(" - ")[0]);

    });
}
function mark(row) {
    $('.tablerow.active').removeClass('active');
    $(row).addClass('active');
}
function initFiltersettingButton() {
    $(".filterbutton").on('click', function () {
        $(".statusbutton[data-a='filterall']").toggle();
    });

}
function initFilterButton() {
    $(".statusbutton[data-a='filterall']").on('click', function () {
        var type = $(this).attr('data-type');
        $.post('db/toggleFlag.php', {"type": type, "id": 0}, function () {
            $('.' + type + "button0[data-a='filteradded']").toggle();
            filter();

        });
    });

}

function filter() {
    $("#Table_Songlist tr").hide();
    $.get('db/getAllFlags.php', function (output) {
        var allflags = JSON.parse(output);
        if (!allflags[0]) {
            $("#Table_Songlist tr").show();
            $("#statistik").html($("#Table_Songlist tr").length);
            return;
        }
        var iA = 0;
        var iF = 0;    
        var filter = JSON.parse(allflags[0]);
        for (var id in allflags) {
            if (id == 0) {
                continue;
            }
            var flagarray = JSON.parse(allflags[id]);
            var show = true;
            for (var index in filter) {
                if ($.inArray(filter[index], flagarray) <= -1) {
                    show = false;
                }

            }
            if (show) {
                $("tr").filter(function () {
                    return $(this).attr('data-id') == id;
                }).show();
                iF++;
            }
            iA++;
        }
        $('#statistik').html(iF+"/"+iA);
    });

}

