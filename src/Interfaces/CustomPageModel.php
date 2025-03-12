<?php
namespace RobinDort\PslzmeLinks\Interfaces;

interface CustomPageModel {

    public function selfExists();
    public function selectActivePageRootID();
    public function findMostUsedLayoutID();
    public function findLatestSorting($pid);
    public function setParentPageID($parentPageID);
    public function setSorting($sorting);
    public function getTitle();
    public function getID();
}

?>