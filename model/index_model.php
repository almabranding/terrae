<?php

class Index_Model extends Model {

    public function __construct() {
        parent::__construct();
    }
    public function getSectionsImg(){
        foreach($this->getSections() as $section){
            $sectionsImg[$section['id']]=$this->getImageById($section['photo_id']);
        }
        return $sectionsImg;
    }
    public function getDescrption($lang = LANG) {
        foreach($this->getSections() as $section){
            $description[$section['id']]=$this->db->selectOne("SELECT * FROM home_sections_description WHERE home_sections_id=" . $section['id'] . ' AND language_id="' . $lang . '"');
        }
        return $description;
    }
    

}