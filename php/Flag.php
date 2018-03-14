<?php

namespace repertoire\php;

class Flag {

    static $all;

    function __construct($type, $file, $title) {
        $this->type = $type;
        $this->filename = $file;
        $this->title = $title;
        self::$all[] = $this;
    }

    /**
     *
     * src/$filename.png
     * ohne pfad und endung
     * @var type 
     */
    public $filename;
    
    public $type;

    public $title;

    static function getAll() {
        return self::$all;
    }

    static function byType($type) {
        foreach (self::getAll() as $i => $flag) {
            if ($flag->type == $type) {
                return $flag;
            }
        }
    }

    
    function getButtonString($id, $addedall, $hidden = false) {
        $h = $hidden ? "style='display:none' ":"";
        $output = "<input "
                . "class='imagebutton statusbutton ".$this->type." ".$this->type."button$id' "
                . $h
                . "type='image' src='src/$this->filename.png' "
                . "title='$this->title' "
                . "data-id=$id data-type='$this->type' data-a='$addedall'/>";
        return $output;
    }
}
