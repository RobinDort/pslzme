<?php
namespace RobinDort\PslzmeLinks\EventListener\contao;

class ReplaceInsertTags {
    public function replacePslzmeInsertTags($tag) {
        \System::log("Tag content: " . $tag,__METHOD__,"TL_ERROR");
        throw new \Exception("Tag Debug");
    }
}

?>