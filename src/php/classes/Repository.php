<?php

declare(strict_types=1);
//include_once 'Tag.php';

/**
 * @author Samuel BERTIN - Asten CLOUD - Stagiaire MCO
 * 
 * Constants created within the /src/php/config.php file
 * Please modify the config file to change the registry's endpoint
 * The Repository class allows the instantiation of a valid endpoint that is existing within a Registry
 *  
 * @param $repository_name Name of the repository
 * @param $tags The tags name list within the repository
 */
final class Repository {

    private $repository_name; // @var string Name of the repository
    private $tags; // @var array Array of tag names nested within the repository

    /**
     * Instantiates a Repository object from the specicified config
     */
    public function __construct(string $name) {
        $this->setName($name);
        $this->setTags();
    }
    
    /**
     * Sets the $repository_name attribute for the repository
     * 
     * @param string $name Name of the repository
     */
    public function setName(string $name):void {
        $this->repository_name = $name;
    }

    /**
     * Gets the $repository_name attribute for the repository
     * 
     * @return string $name Name of the repository
     */
    public function getName():string{
        return $this->repository_name;
    }

    /**
     * Sets the $tags attribute for the repository
     * 
     */
    public function setTags(): void {
        $url = REGISTRY_URL."/v2/".$this->repository_name."/tags/list";
        $data = Utils::getDataFromUrl($url);
        $arr = array();
        $tagList = $data['tags']; 
        array_push($arr, $tagList);
        $this->tags = $tagList;
    }

    /**
     * Gets the $tags attribute as an array
     * 
     * @return array Array of tag names contained within the repository
     */
    public function getTags(): array {
        if (!is_null($this->tags)) {
            return $this->tags;
        } return array();
        
    } 

    /**
     * Gets the tag count for the repository
     * 
     * @return int Tag count for the repository
     */
    public function getTagsCount(): int {
        if (!is_null($this->tags)) {
            return count($this->tags);
        } return 0;
        
    }

    /**
     * Creates a new Tag object or throws an error
     * 
     * Creates a new Tag object  if the $tag_name exists wihtin the array of tag names $tags
     * Throws an error if the $tag_name does not exist
     * @throws InvalidArgumentException
     */
    public function getTag($tag_name):Tag{
        if (!in_array($tag_name, $this->tags)) {
            throw new InvalidArgumentException("Repository not found within the registry");
        } return new Tag($tag_name, $this->repository_name);
    }

}

?>