<?php

namespace repertoire;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/db/Connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/php/Flag.php';

class Main {

    static $db;
    static $filter;

    static function init() {
        self::initFlagbuttons();


        $host = "localhost";
        $dbname = "repertoire";
        $username = "Stu";
        $pw = "pw";


        Main::$db = new \repertoire\db\Connection($host, $dbname, $username, $pw);
        Main::$filter = Main::$db->getFlags(0);
    }

    static function getMainContent() {
        return
                "<html>" . self::getHTMLHead() .
                "<body>" .
                self::getHeaderPicture() .
                self::getTableHeader() .
                self::getEingabeformular() .
                self::getYoutubeplayerDiv() .
                self::getTableContent() .
                self::getSongtext() .
                self::getSongtext_Eingabe() .
                "</body>" .
                "</html>";
    }

    static function getYoutubeplayerDiv() {
        return "<div id='youtubeplayerDiv' style='display:none'></div>";
    }

    static function getSongtext_Eingabe() {
        return file_get_contents("html/songtexteingabe.html");
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
        $outputFrame = file_get_contents("html/main_table_header.html");
        $outputAdded = "";
        $outputAll = "";
        $output = "";
        $all = php\Flag::getAll();
        $id = 0;
        foreach ($all as $i => $flag) {
            if (in_array($flag, Main::$filter)) {
                $outputAdded .= $flag->getButtonString($id, "filteradded");
                $outputAll .= $flag->getButtonString($id, "filterall", true);
            } else {
                $outputAll .= $flag->getButtonString($id, "filterall", true);
                $outputAdded .= $flag->getButtonString($id, "filteradded", true);
            }
        }
        $output = str_replace("{filteradded}", $outputAdded, $outputFrame);
        $output = str_replace("{filterall}", $outputAll, $output);
        $anzahl = count(\repertoire\php\Song::$songs);
        $output = str_replace("{anzahl}", "$anzahl/$anzahl", $output);
        return $output;
    }

    static function getTableContent() {
        $output = "<div id='tabellenDiv'>" .
                "<table class='tabelle' id='Table_Songlist'>" .
                "<tbody id='Table_Body'>";
        foreach (\repertoire\php\Song::getSongs() as $id => $song) {
            $interpret = $song->getInterpret();
            $songtitel = $song->getTitel();
            $statusbar = self::getStatusbar($id);
            $utilbar = self::getUtilbar($id);
            $contents = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/html/main_table_row_template.html');
            $contents = str_replace("{id}", $id, $contents);
            $contents = str_replace("{Interpret}", $interpret, $contents);
            $contents = str_replace("{Songtitel}", $songtitel, $contents);
            $contents = str_replace("{Statusbar}", $statusbar, $contents);
            $contents = str_replace("{Utilbar}", $utilbar, $contents);
            $contents = str_replace("{audioplayer}", self::getAudioplayer($id, $interpret, $songtitel), $contents);

            $output .= $contents;
        }

        $output .= "</tbody></table></div>";
        return $output;
    }

    static function getEingabeformular() {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/html/eingabe.html');
    }

    static function getSongtext($songtext = "Wähle einen Song, um den Text anzuzeigen") {
        return str_replace("{text}", $songtext, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/html/songtext.html'));
    }

    static function getUtilbar($id) {
        return str_replace("{id}", $id, file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/html/utilbar.html'));
    }

    static function getStatusbar($id) {
        $outputFrame = '<div id = "addedFlags">{added}</div><div id = "allFlags">{all}</div>';
        $outputAdded = "";
        $outputAll = "";
        $output = "";
        $active = Main::getDatenbank()->getFlags($id);
        $all = php\Flag::getAll();
        foreach ($all as $i => $flag) {
            if (in_array($flag, $active)) {
                $outputAdded .= $flag->getButtonString($id, "added");
                $outputAll .= $flag->getButtonString($id, "all", true);
            } else {
                $outputAll .= $flag->getButtonString($id, "all", true);
                $outputAdded .= $flag->getButtonString($id, "added", true);
            }
        }
        $output = str_replace("{added}", $outputAdded, $outputFrame);
        $output = str_replace("{all}", $outputAll, $output);

        return $output;
    }

    static function initFlagbuttons() {
        new php\Flag("deutsch", "deutsch", "deutsch");
        new php\Flag("englisch", "englisch", "englisch");
        new php\Flag("french", "french", "französisch");
        new php\Flag("gehtalleine", "bluesbrother", "Läuft");
        new php\Flag("gehtnicht", "blitz", "Geht noch nicht");
        new php\Flag("kannnichtsingen", "gift", "Muss jemand anders singen");
        new php\Flag("duett", "duett", "Duett");
        new php\Flag("frau", "lady", "wird von Frau gesungen");
        new php\Flag("mann", "mustache", "wird von Mann gesungen");
        new php\Flag("gitarre", "guitar", "Gitarre");
        new php\Flag("klavier", "klavier", "Klavier");
        new php\Flag("lustig", "masken", "lustig");
        new php\Flag("depri", "maske_traurig", "traurig");
        new php\Flag("kindertauglich", "kindertauglich", "kindertauglich");
        new php\Flag("liebeslied", "herz", "Liebeslied");
        new php\Flag("liebeskummerlied", "zerbrochenesherz", "Liebeskummerlied");
        new php\Flag("weihnachtslied", "kerzen", "Weihnachtslied");
        new php\Flag("alkohol", "alkohol", "Sauflied");
        new php\Flag("geburtstag", "geburtstag", "Geburtstagslied");
        new php\Flag("zelten", "zelten", "Lagerfeuerlied");
        new php\Flag("ue18", "horror", "Ü-18");
        new php\Flag("idee", "idee", "in Entwicklung");
        new php\Flag("canabis", "canabis", "Kifferlied");
    }

}
