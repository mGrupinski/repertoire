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
                "<div id='tabellenDiv'><table class='tabelle' id='Table_Songlist'>" .
                self::getTableContentFromDB() .
                "</table>" .
                "</div>" .
                self::getEingabeformular() .
                self::getSongtext() .
                "</body>" .
                "</html>";
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
            $utilbar = "coming soon";
            $contents = file_get_contents("html/main_table_row_template.html");
            $contents = str_replace("{id}", $id, $contents);
            $contents = str_replace("{Interpret}", $interpret, $contents);
            $contents = str_replace("{Songtitel}", $songtitel, $contents);
            $contents = str_replace("{Statusbar}", $statusbar, $contents);
            $contents = str_replace("{Utilbar}", $utilbar, $contents);

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

}
