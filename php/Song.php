<?php

namespace repertoire\php;

class Song {

    /**
     *
     * @var array(Song)
     */
    static $songs = array();
    var $id, $interpret, $titel, $status, $songtext, $noten, $mp3, $youtubelink, $flag_gitarre, $flag_text, $flag_gesang, $flag_klavier, $flag_allein, $flag_zwei, $flag_alle;

    function __construct($interpret, $titel, $id = -1, $status = 0, $songtext = "", $noten = "", $mp3 = "", $youtubelink = "", $flag_gitarre = FALSE, $flag_text = FALSE, $flag_gesang = FALSE, $flag_klavier = FALSE, $flag_allein = FALSE, $flag_zwei = false, $flag_alle = FALSE) {
        $this->id = $id;
        $this->interpret = $interpret;
        $this->titel = $titel;
        $this->status = $status;
        $this->songtext = $songtext;
        $this->noten = $noten;
        $this->mp3 = $mp3;
        $this->youtubelink = $youtubelink;
        $this->flag_gitarre = $flag_gitarre;
        $this->flag_text = $flag_text;
        $this->flag_gesang = $flag_gesang;
        $this->flag_allein = $flag_allein;
        $this->flag_zwei = $flag_zwei;
        $this->flag_alle = $flag_alle;

        Song::$songs [$id] = $this;
    }

    public static function getSongs() {
        return self::$songs;
    }

    public static function getNewId() {
        $i = 0;
        for (; isset(self::$songs [$i]); $i ++)
            ;
        return $i;
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
    public function getStatus() {
        return $this->status;
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
    public function getMp3() {
        return $this->mp3;
    }

    /**
     *
     * @return mixed
     */
    public function getYoutubelink() {
        return $this->youtubelink;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_gitarre() {
        return $this->flag_gitarre;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_text() {
        return $this->flag_text;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_gesang() {
        return $this->flag_gesang;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_klavier() {
        return $this->flag_klavier;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_status() {
        return $this->flag_status;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_allein() {
        return $this->flag_allein;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_zwei() {
        return $this->flag_zwei;
    }

    /**
     *
     * @return mixed
     */
    public function getFlag_alle() {
        return $this->flag_alle;
    }

    /**
     *
     * @param mixed $id
     */
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
     * @param mixed $status
     */
    public function setStatus($status) {
        $this->status = $status;
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
     * @param mixed $mp3
     */
    public function setMp3($mp3) {
        $this->mp3 = $mp3;
    }

    /**
     *
     * @param mixed $youtubelink
     */
    public function setYoutubelink($youtubelink) {
        $this->youtubelink = $youtubelink;
    }

    /**
     *
     * @param mixed $flag_gitarre
     */
    public function setFlag_gitarre($flag_gitarre) {
        $this->flag_gitarre = $flag_gitarre;
    }

    /**
     *
     * @param mixed $flag_text
     */
    public function setFlag_text($flag_text) {
        $this->flag_text = $flag_text;
    }

    /**
     *
     * @param mixed $flag_gesang
     */
    public function setFlag_gesang($flag_gesang) {
        $this->flag_gesang = $flag_gesang;
    }

    /**
     *
     * @param mixed $flag_klavier
     */
    public function setFlag_klavier($flag_klavier) {
        $this->flag_klavier = $flag_klavier;
    }

    /**
     *
     * @param mixed $flag_status
     */
    public function setFlag_status($flag_status) {
        $this->flag_status = $flag_status;
    }

    /**
     *
     * @param mixed $flag_allein
     */
    public function setFlag_allein($flag_allein) {
        $this->flag_allein = $flag_allein;
    }

    /**
     *
     * @param mixed $flag_zwei
     */
    public function setFlag_zwei($flag_zwei) {
        $this->flag_zwei = $flag_zwei;
    }

    /**
     *
     * @param mixed $flag_alle
     */
    public function setFlag_alle($flag_alle) {
        $this->flag_alle = $flag_alle;
    }

}
