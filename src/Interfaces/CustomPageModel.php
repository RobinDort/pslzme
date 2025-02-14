<?php
namespace RobinDort\PslzmeLinks\Interfaces;

interface CustomPageModel {

    public function selfExists();
    public function selectActivePageRootID();
    public function findMostUsedLayout();
    public function setParentPageID($parentPageID);
    public function getTitle();
    public function getID();
}

?>