<?php

namespace repertoire\db;

require_once $_SERVER['DOCUMENT_ROOT'].'/netbeans/repertoire/utils/AbstractConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/netbeans/repertoire/php/Song.php';

use repertoire\php\Song;

class Connection extends AbstractConnection {

    public function init() {
        $rs = $this->pdo->query("SELECT * FROM repertoire ORDER BY interpret, titel");
        foreach ($rs as $a) {
            $id = $a ['id'];
            $interpret = $a ["interpret"];
            $titel = $a ["titel"];
            $flag_status = $a ["flag_status"];
            $songtext = $a ["songtext"];
            $noten = $a ["noten"];
            $mp3 = $a ["mp3"];
            $youtubelink = $a ["youtubelink"];
            $flag_gitarre = $a ["flag_gitarre"];
            $flag_text = $a ["flag_text"];
            $flag_gesang = $a ["flag_gesang"];
            $flag_klavier = $a ["flag_klavier"];
            $flag_allein = $a ["flag_allein"];
            $flag_zwei = $a ["flag_zwei"];
            $flag_alle = $a ["flag_alle"];
            new Song($interpret, $titel, $id, $flag_status, $songtext, $noten, $mp3, $youtubelink, $flag_gitarre, $flag_text, $flag_gesang, $flag_klavier, $flag_allein, $flag_zwei, $flag_alle);
        }
    }

    public function createTables() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS repertoire (
            id INT AUTO_INCREMENT PRIMARY KEY,
            interpret VARCHAR(255) NOT NULL,
            titel VARCHAR(255) NOT NULL,
            songtext LONGTEXT,
            noten LONGTEXT,
            mp3 LONGTEXT,
            youtubelink VARCHAR(255),
            flag_status TINYINT(1) DEFAULT 0,
            flag_gitarre  TINYINT(1) DEFAULT 0,
            flag_text TINYINT(1) DEFAULT 0,
            flag_gesang TINYINT(1) DEFAULT 0,
            flag_klavier TINYINT(1) DEFAULT 0,
            flag_allein TINYINT(1) DEFAULT 0,
            flag_zwei TINYINT(1) DEFAULT 0,
            flag_alle TINYINT(1) DEFAULT 0
				
        )");
    }

    public function addSong($interpret, $titel) {
        try {
            $this->pdo->exec("INSERT INTO repertoire (interpret, titel) VALUES ('$interpret', '$titel')");
            $id = $this->pdo->lastInsertId();
            Song::$songs [$id] = new Song($interpret, $titel, $id);
            return $id;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function delSong($id) {
        try {
            $this->pdo->exec("DELETE FROM repertoire WHERE id=$id");
            unset(Song::$songs[$id]);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

}
