<?php

declare(strict_types=1);

/**
 * @author Samuel BERTIN - Asten CLOUD - Stagiaire MCO
 * 
 * Constants created within the /src/php/config.php file
 * Please modify the config file to change the registry's endpoint
 *  
 */
final class Layer {

    private $layer_digest; // @var string Layer's unique identifier
    private $parent_tag; // @var string Name of parent tag

    public function __construct($layer_digest, $parent_tag){
        $this->setLayerDigest($layer_digest);
        $this->setParentTag($parent_tag);
    }

    public function setLayerDigest(string $layer_digest):void{
        $this->layer_digest = $layer_digest;
    }

    public function setParentTag(string $parent_tag):void{
        $this->parent_tag = $parent_tag;
    }

    public function getLayerDigest():String {
        return $this->layer_digest;
    }

    public function getParentTag():String {
        return $this->parent_tag;
    }

}

?>