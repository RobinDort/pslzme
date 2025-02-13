<?php
namespace RobinDort\PslzmeLinks\Interfaces;

interface CustomContentModel {
    public function findParentArticleID();
    public function selfExists();
}

?>