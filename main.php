<?php

namespace repertoire;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/db/Connection.php';

class Main {

    static $db;

    static function init() {
        $host = "localhost";
        $dbname = "repertoire";
        $username = "Stu";
        $pw = "pw";

        Main::$db = new \repertoire\db\Connection($host, $dbname, $username, $pw);
    }

    static function getMainContent() {
        return
                "<html>" . self::getHTMLHead() .
                "<body>" . self::getHeaderPicture() .
                self::getTableHeader() .
                self::getEingabeformular() .
                "<div id='youtubeplayerDiv'></div>" .
                "<div id='tabellenDiv'>" .
                "<table class='tabelle' id='Table_Songlist'>" .
                self::getTableContentFromDB() .
                "</table>" .
                "</div>" .
                self::getSongtext() .
                "</body>" .
                "</html>";
    }

    static function getYoutubeplayer($link) {
        $contents = str_replace("{youtubelink}", $link, file_get_contents("html/youtubeplayer.html"));
        $contents = str_replace("watch?v=", "embed/", $contents);
        return $contents;
    }

    static function getAudioplayer($id, $interpret, $songtitel) {
        if (!file_exists("src/mp3/$interpret - $songtitel.mp3")) {
            return "";
        }
        $contents = file_get_contents("html/audioplayer.html");
        $contents = str_replace("{id}", $id, $contents);
        $contents = str_replace("{interpret}", $interpret, $contents);
        $contents = str_replace("{songtitel}", $songtitel, $contents);

        return $contents;
    }

    static function getDatenbank() {
        if (Main::$db == null) {
            Main::init();
        }
        return Main::$db;
    }

    static function getHTMLHead() {
        return file_get_contents("html/main_HTMLheader.html");
    }

    static function getHeaderPicture() {
        return file_get_contents("html/main_header_picture.html");
    }

    static function getTableHeader() {
        return file_get_contents("html/main_table_header.html");
    }

    static function getTableContentFromDB() {
        $output = "<tbody id='Table_Body'>";

        foreach (\repertoire\php\Song::getSongs() as $id => $song) {
            $interpret = $song->getInterpret();
            $songtitel = $song->getTitel();
            $statusbar = "coming soon";
            $utilbar = self::getUtilbar($id);
            $contents = file_get_contents("html/main_table_row_template.html");
            $contents = str_replace("{id}", $id, $contents);
            $contents = str_replace("{Interpret}", $interpret, $contents);
            $contents = str_replace("{Songtitel}", $songtitel, $contents);
            $contents = str_replace("{Statusbar}", $statusbar, $contents);
            $contents = str_replace("{Utilbar}", $utilbar, $contents);
            $contents = str_replace("{audioplayer}", self::getAudioplayer($id, $interpret, $songtitel), $contents);

            $output .= $contents;
        }
        $output .= "</tbody>";
        return $output;
    }

    static function getEingabeformular() {
        return file_get_contents("html/eingabe.html");
    }

    static function getSongtext($songtext = "Wähle einen Song, um den Text anzuzeigen") {
        return str_replace("{text}", $songtext, file_get_contents("html/songtext.html"));
    }

    static function getUtilbar($id) {
        return str_replace("{id}", $id, file_get_contents("html/utilbar.html"));
    }

}
