<?php

namespace repertoire\db;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/utils/AbstractConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/php/Song.php';

use repertoire\php\Song;

class Connection extends AbstractConnection {

    public function init() {
        $rs = $this->pdo->query("SELECT * FROM repertoire ORDER BY interpret, titel");
        foreach ($rs as $a) {
            $id = $a ['id'];
            $interpret = $a ["interpret"];
            $titel = $a ["titel"];
            $songtext = $a ["songtext"];
            $noten = $a ["noten"];
            $youtubelink = $a ["youtubelink"];
            $flags = $this->getFlags($id);
            $flag_geloescht = $a ["flag_geloescht"];
            if (!$flag_geloescht)
                new Song($interpret, $titel, $id, $songtext, $noten, $youtubelink, $flags);
        }
    }

    public function createTables() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS repertoire (
            id INT AUTO_INCREMENT PRIMARY KEY,
            interpret VARCHAR(255) NOT NULL,
            titel VARCHAR(255) NOT NULL,
            songtext TEXT,
            noten TEXT,
            youtubelink VARCHAR(255),
            flag_geloescht TINYINT(1) DEFAULT 0
				
        );");
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS songhatflag (
            id INT,
            flag VARCHAR(60),
            PRIMARY KEY(id, flag)
				
        );");
    }

    public function addSong($interpret, $titel) {
        try {
            //wenns das lied schonmal gab, ist vielleicht schon ein link oder ein text gespeichert
            $rs = $this->pdo->query("SELECT * FROM repertoire WHERE interpret='$interpret' AND titel='$titel'");
            foreach ($rs as $row) {
                $this->pdo->exec("UPDATE repertoire SET flag_geloescht=0 WHERE interpret='$interpret' AND titel='$titel'");
                Song::$songs [$id] = new Song($interpret, $titel, $row['id']);
                return $id;
            }
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
            $this->pdo->exec("UPDATE repertoire SET flag_geloescht=1 WHERE id=$id");
            unset(Song::$songs[$id]);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getSongtext($id) {
        try {
            $rs = $this->pdo->query("SELECT songtext FROM repertoire WHERE id=$id");
            foreach ($rs as $row)
                return $row['songtext'];
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function setSongtext($id, $text) {
        try {
            $stmt = $this->pdo->prepare("UPDATE repertoire SET songtext=? WHERE id=?");
            $stmt->bindParam(1, $text);
            $stmt->bindParam(2, $id);
            $stmt->execute();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getInterpret($id) {
        try {
            $rs = $this->pdo->query("SELECT interpret FROM repertoire WHERE id=$id");
            foreach ($rs as $row)
                return $row['interpret'];
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function getSongtitel($id) {
        try {
            $rs = $this->pdo->query("SELECT titel FROM repertoire WHERE id=$id");
            foreach ($rs as $row)
                return $row['titel'];
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function getYoutubelink($id) {
        try {
            $rs = $this->pdo->query("SELECT youtubelink FROM repertoire WHERE id=$id");
            foreach ($rs as $row)
                return $row['youtubelink'];
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function setYoutubelink($id, $link) {
        try {
            $this->pdo->exec("UPDATE repertoire SET youtubelink='$link' WHERE id=$id");
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getFlags($id) {
        try {
            $a = array();
            $rs = $this->pdo->query("SELECT * FROM songhatflag WHERE id=$id");
            foreach ($rs as $row) {
                $a[] = \repertoire\php\Flag::byType($row['flag']);
            }
            return $a;
        } catch (\Exception $exc) {
            die($exc->getMessage());
        }
    }

    public function toggleFlag($id, $flag) {
        try {
            $rs = $this->pdo->query("SELECT * FROM songhatflag WHERE id=$id AND flag='$flag'");
            if ($rs->rowCount() > 0) {
                $this->pdo->exec("DELETE FROM songhatflag WHERE id=$id AND flag='$flag'");
            } else {
                $this->pdo->exec("INSERT INTO songhatflag (id, flag) VALUES($id, '$flag')");
            }
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function getAllFlags() {
        try {
            $a = array();
            $rs = $this->pdo->query("SELECT * FROM songhatflag ORDER BY id");
            foreach ($rs as $row) {
                $a[$row['id']][] = $row['flag'];
            }
            return $a;
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

}
