<?php 

declare(strict_types=1);
//include_once 'Repository.php';

/**
 * @author Samuel BERTIN - Asten CLOUD - Stagiaire MCO
 * 
 * Constants created within the /src/php/config.php file
 * Please modify the config file to change the registry's endpoint
 * The Registry class allows the instantiation of a valid endpoint that is implementing the Docker Registry V2
 *  
 * @param $repositories A list of repository names nested within the registry
 * @param $registry_url The public or private adress and port of the registy
 */
final class Registry{

    private $repositories; // @var array Array of repository names 
    private $registry_url; // @var string URL to the running registry container
    
    /**
     * Instantiates a Registry object from the specicified config
     */
    public function __construct(string $registry_url) {
        $this->ensureRegistryIsValid($registry_url);
        $this->registry_url = $registry_url;
        $this->setRepositories();
    }

    /**
     * Throws an InvalidArgumentException if the registry doesn't implement Docker Registry API V2
     * 
     * @param $registry The URL from the registry to validate
     */
    public function ensureRegistryIsValid($registry):void {
        $url = $registry."/v2/";
        $resp =  Utils::getHeadDataV2($url);
        if (!$resp){
            throw new InvalidArgumentException(sprintf("%s is not a valid endpoint for the API Registry V2 from docker according to its documentation.",$registry));
        }
    }

    /**
     * Sets the repository names list for the registry
     */
    public function setRepositories():void {
        $url = $this->registry_url."/v2/_catalog";
        $data = Utils::getDataFromUrl($url);
        $this->repositories = $data['repositories'];
    }

    /**
     * Gets the repository names list for the registry
     * 
     * @return array Array of repository names
     */
    public function getRepositories():array {
        return $this->repositories;
    }

    /**
     * Gets the count of repositories nested within the registry
     * 
     * @return int Count of repositories
     */
    public function getRepositoriesCount():int{
        return count($this->repositories);
    }

    /**
     * Creates a new Repository object from its name. The namme must exist within the repository names list $repositories.
     * 
     * @param string $repository_name Name of the repository to create.
     */
    public function getRepository(string $repository_name): Repository {
        if (!in_array($repository_name, $this->repositories)) {
            throw new InvalidArgumentException("Repository not found within the registry");
        } return new Repository($repository_name);
    }
   

}

?>