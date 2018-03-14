<?php

namespace repertoire\php;

class Song {

    /**
     *
     * @var array(Song)
     */
    static $songs = array();
    var $id, $interpret, $titel, $songtext, $noten, $youtubelink, $flags;

    function __construct($interpret, $titel, $id = -1, $songtext = "", $noten = "", $youtubelink = "", $flags) {
        $this->id = $id;
        $this->interpret = $interpret;
        $this->titel = $titel;
        $this->songtext = $songtext;
        $this->noten = $noten;
        $this->youtubelink = $youtubelink;
        $this->flags = $flags;

        Song::$songs [$id] = $this;
    }

    public static function getSongs() {
        return self::$songs;
    }


    /**
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @return mixed
     */
    public function getInterpret() {
        return $this->interpret;
    }

    /**
     *
     * @return mixed
     */
    public function getTitel() {
        return $this->titel;
    }

   

    /**
     *
     * @return mixed
     */
    public function getSongtext() {
        return $this->songtext;
    }

    /**
     *
     * @return mixed
     */
    public function getNoten() {
        return $this->noten;
    }

   
   

    /**
     *
     * @return mixed
     */
    public function getYoutubelink() {
        return $this->youtubelink;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     *
     * @param mixed $interpret
     */
    public function setInterpret($interpret) {
        $this->interpret = $interpret;
    }

    /**
     *
     * @param mixed $titel
     */
    public function setTitel($titel) {
        $this->titel = $titel;
    }

   
    /**
     *
     * @param mixed $songtext
     */
    public function setSongtext($songtext) {
        $this->songtext = $songtext;
    }

    /**
     *
     * @param mixed $noten
     */
    public function setNoten($noten) {
        $this->noten = $noten;
    }

    

    /**
     *
     * @param mixed $youtubelink
     */
    public function setYoutubelink($youtubelink) {
        $this->youtubelink = $youtubelink;
    }

    public function getFlags() {
        return $this->flags;
    }
    public function addFlag($flag) {
        $this->flags[] = $flag;
    }
    

}
