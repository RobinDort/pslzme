<?php
namespace RobinDort\PslzmeLinks\Interfaces;

interface CustomArticleModel {
    public function selfExists();
    public function findParentPageID();
    public function findAuthorID();
}
?>