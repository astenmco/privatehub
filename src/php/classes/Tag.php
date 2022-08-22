<?php

declare(strict_types=1);

/* include_once 'Repository.php';
include_once 'Labels.php'; */


/**
 * @author Samuel BERTIN - Asten CLOUD - Stagiaire MCO
 * 
 * Constants created within the /src/php/config.php file
 * Please modify the config file to change the registry's endpoint
 *  
 */
final class Tag {
    
    private $tag_name; //  @var string Identifier for the image version/revision
    private $parent_repository_name; // @var string Name of the parent repository
    private $tag_digest; // @var string Unique image identifier (digest)
    private $architecture; //  @var string|array Architecture(s) for the image version/revision
    private $layers; // @var array Array of the layer's identifiers for the image version/revision
    private $labels; // @var array Labels from the image version/revision

    /**
     * Instatiates a Tag object from the specified config
     */
    public function __construct($tag_name, $repository_name){
        $this->tag_name = $tag_name;
        $this->parent_repository_name = $repository_name;
        $this->setTagDigest();
        $this->setArchitecture();
        $this->setTagLayers();
        $this->setLabels();
    }

    /**
     * Gets the name of the tag
     * 
     * @return string Name of the tag
     */
    public function getName():string{
        return $this->tag_name;
    }

    /**
     * Gets the name of the parent repository
     * 
     * @return string Name of the tag's parent repository
     */
    public function getParentRepositoryName():string{
        return $this->parent_repository_name;
    }

    /**
     * Gathers JSON V1 Manifest data from Docker Registry API V2 into a single array.
     * 
     * This function returns an array containting all the informations gathered from the docker image manifest (Schama 2, V1) of a specific tag.
     * 
     * @return array Array containing all the data from the manifestt.
     */
    public function getV1Manifest():array{
        $url = REGISTRY_URL."/v2/".$this->getParentRepositoryName()."/manifests/".$this->getName();
        $data = Utils::getDataFromUrl($url);
        return $data;
    }

    /**
     * Gets the configs array from a specified image.
     * 
     * This function returns an array containing all the V1Comptability array values from the Schema 2 V1 from Docker.
     * 
     * @return array Array containing the configs from the image.  
     */
    public function getV1Configs():array{
        
        $histories = $this->getV1Manifest()["history"];
        $configs_array = Utils::accessSubJSONAsArray($histories);
        return $configs_array;
    }

     /**
     * Gathers JSON V2 Manifest data from Docker Registry API V2 into a single string
     * 
     * This function returns an array containting all the informations gathered from the docker image manifest (Schama 2, V2) of a specific tag.
     * 
     * @return array Array containing all the data from the manifestt.
     */
    public function getV2ManifestAsString():string{
        $url = REGISTRY_URL."/v2/".$this->getParentRepositoryName()."/manifests/".$this->getName();
        $data = Utils::getHeadDataV2($url);
        return $data;
    }

    /**
     * Gathers data from the V2 Manifest and its data in a single array.
     * 
     * This function returns an array containting all the informations gathered from the docker image manifest (Schama 2, V2) of a specific tag.
     * 
     * @return array Array containing all the data from the manifestt.
     */
    function getV2ManifestAsArray():array{
        $data = json_decode($this->getV2ManifestAsString(), true);
        return $data;
    }

    /**
     * Sets up the corresponding digest for a single or a multi-arch tag
     */
    public function setTagDigest():void{
        $test = $this->getV2ManifestAsArray();
        if (isset($test['manifests'])) {
            $this->tag_digest = substr($this->getV2ManifestAsString(), 249, 71);
        } else {
            $this->tag_digest = $this->getDockerContentDigestFromHTTPHeader();
        }
    }

    /**
     * Returns HTTP headers data as an array
     * 
     * The function trims the http header string and explodes it into a single array.
     * 
     * @return array $headers HTTP Headers separated by index.
     */
    public function getHTTPHeadersAsArray():array{
        $url = REGISTRY_URL."/v2/".$this->getParentRepositoryName()."/manifests/".$this->getName();
        $headers = [];
        $output = rtrim(Utils::headDataFromUrl($url));
        $data = explode("\n",$output);
        $headers['status'] = $data[0];
        array_shift($data);
        foreach($data as $part){

            //some headers will contain ":" character (Location for example), and the part after ":" will be lost, Thanks to @Emanuele
            $middle = explode(":",$part,2);

            //Supress warning message if $middle[1] does not exist, Thanks to @crayons
            if ( !isset($middle[1]) ) { $middle[1] = null; }

            $headers[trim($middle[0])] = trim($middle[1]);
        }  return $headers;
    }

    /**
     * Gets the Docker Content Digest from HTTP Headers sent to verify the tags digest.
     */
    public function getDockerContentDigestFromHTTPHeader():string {
        $headers = $this->getHTTPHeadersAsArray();
        //var_dump($headers);
        return $headers['Docker-Content-Digest'];
    }

    /**
     * Gets the single arch tag's unique identifier (digest) f
     */
    public function getTagDigest():string{
        return $this->tag_digest;
    }

    /**
     * Sets the architecture from the right manifest.
     */
    public function setArchitecture():void{
        $architectures = array();
        $manifest = $this->getV2ManifestAsArray();
        if (array_key_exists("manifests", $manifest)) {
            $manifests = $manifest["manifests"];
            foreach( $manifests as $key => $value) {
                $arch = $value['platform']['architecture'];
                if (!in_array($arch, $architectures, true)) {
                    array_push($architectures, $arch);
                }     
            }
        } else {
            array_push($architectures, $this->getV1Manifest()['architecture']);
        } $this->architecture = $architectures; 
    }

    /**
     * Gets the architecture for a specific tag of an image.
     * 
     * This function returns a string indicating the system architecture that the image passed in paramaters can run onto.
     * The image is identified by registry, repository name and tag.

     * @return array Architecture(s) of the image 
     */
    public function getArchitecture():array{
        return $this->architecture;
    }

    /**
     * Sets the $layers attribute with every tag's layer digests.
     * 
     * Layers gathered from the tag's V1Manifest
     */
    public function setTagLayers():void{
        $manifest = $this->getV1Manifest();
        $layers = array();
        foreach($manifest['fsLayers'] as $key=>$value){
            foreach($value as $index=>$data){
                array_push($layers, $data);
            }   
        }
        $this->layers = $layers;
    }

    /**
     * Gets data from the fsLayers section of the V1 Manifest for a specific image.
     * 
     * This function returns an array with the layers data corresponding to the image passed in parameters.
     * The image is identified by registry, repository name and tag.
     * 
     * @return array Array containing all the layers data. 
     */
    public function getTagLayers():array{
        return $this->layers;
    }

    /**
     * Instantiate a layer oject if its reference exist within the $layers array attribute
     * 
     * @throws InvalidArgumentException Layer Digest must exist inside the layers attribute.
     */
    public function getLayer($layer_digest):Layer{
        if (!in_array($layer_digest,$this->layers)) {
            throw new InvalidArgumentException("Layer not found wihtin the tag");
        } return new Layer($layer_digest, $this->tag_name);
    }

    /**
     * Gets the data corresponding to the last edit made on the container image.
     * 
     * This function returns an array with the the data corresponding to the last edit made on the container sourcing 
     * the image within the history section of the V1 Manifest for a specific image passed in parameters.
     * The image is identified by registry, repository name and tag.
     * 
     * @return array Array containing all the data from the last edit made.
     */
    public function getLastEditData():array{
        $manifest = $this->getV1Manifest();
        $lastEdit = json_decode($manifest['history'][0]['v1Compatibility'], true);
        return $lastEdit;
    }

    /**
     * Gets the creation date from the latest configuration data of the image.
     * 
     * Gets the date from the lastest edit data and checks its format before returning it's value.
     * 
     * @return string $date The latest creation date referenced inside the image's data
     */
    public function getLatestDate():string{
        $date_no_format = $this->getLastEditData()['created'];
        $date = date("Y-m-d H:i:s", strtotime(substr($date_no_format,0,19)));
        if (!$date) {
            throw new InvalidArgumentException('Invalid date format');
        } return $date;
    }

    /**
     * Gives the time difference in days between now and the latest creation date referenced inside the image's data.
     * 
     * Uses DateTime object methods to compare the time difference.
     * 
     * @return string Number of days since the last edit
     */
    public function getDateTimeDiffAsDays():string{
        $date = $this->getDateTime();
        $now = new DateTime("now");
        $interval = $date->diff($now);
        return $interval->format('%a days');
    }

    /**
     * Gets the date corresponding to the latest edit on the image configuration and returns it as a DateTime object.
     * 
     * @return DateTime The DateTime object corresponding to the latest edit of the image's configuration.
     */
    public function getDateTime():DateTime{
        return new DateTime(substr($this->getLastEditData()['created'],0,10));
    }
    
    /**
     * Gathers all the container configuration (CMD / ENV / VOLUMES ) data for the actual tag
     * 
     * Container images gives data on how the container has been set up.
     * This functions helps gathering the configuration command lines into an array.
     * 
     * @return array $commands Array of strings from the command line configuration of the image's container
     */
    public function getCmdConfigs():array{

        $configs = $this->getV1Configs();
        $commands = array();
        $globalConfig = $configs[0];
        $options = array('Env','Cmd');

        foreach( $options as $index=>$option) {
            $config = $globalConfig['config'];
            if (isset($config[$option]) && !empty($config[$option])) {
                $test = $globalConfig['config'][$option];
                if  (isset($test) && !empty($test)){
                    if (is_array($test)) {
                        $values = $test;
                        foreach($values as $key=>$value) {
                            if (!in_array($value,$commands)) {
                                array_push($commands, $value);
                            }
                        }
                    }
                }
            }
            
        }

        for ($i = 1; $i<count($configs); $i++) {
            foreach( $options as $index=>$option) {
                if ($configs[$i]['container_config']['Cmd'] !== null) {
                    $test = $configs[$i]['container_config']['Cmd'];
                } 
                if  (isset($test) && !empty($test)){
                    if (is_array($test)) {
                        $values = $test;
                        foreach($values as $key=>$value) {
                            if (!in_array($value,$commands)) {
                                array_push($commands, $value);
                            }
                        }
                    }
                }
            }
        } return $commands;
    }

    /**
     * Sets the tag labels used to describe an image at Asten MCO.
     * 
     * This function sets up an array containing existing data from the labels section of the V1 Manifest from the image passed in parameters.
     * This data is specified within the LABELS section of the dockerfile.
     * 
     * Allows the maintainer label to be set up as authors label for convenience.
     */
    public function setLabels():void{

        $lastEdit = $this->getLastEditData();
        $default_labels =  array(
            'fr.groupe-asten.image.commit' => '',
            'org.opencontainers.image.authors' => 'Unknown',
            'org.opencontainers.image.created' => '',
            'org.opencontainers.image.description' => 'Description not found.',
            'org.opencontainers.image.documentation' => '',
            'org.opencontainers.image.licenses' => '',
            'org.opencontainers.image.ref.name' => '',
            'org.opencontainers.image.revision' => '',
            'org.opencontainers.image.source' => '',
            'org.opencontainers.image.title' => '',
            'org.opencontainers.image.url' => '',
            'org.opencontainers.image.vendor' => 'Asten Cloud',
            'org.opencontainers.image.version' => ''
        );
        $index_values = array_keys($default_labels);

        foreach($index_values as $index_key=>$index_value) {
            $config = $lastEdit['config'];
            if (array_key_exists("Labels", $config)) {
                if(!is_null(['Labels'])) {
                    $test = $lastEdit['config']['Labels'];
                    if (isset($test[$index_value]) && !is_null($test[$index_value])) {
                        $default_labels[$index_value] = $lastEdit['config']['Labels'][$index_value];
                    }
                }
            }  
        }
        if (isset($test['maintainer']) && !is_null($test['maintainer'])) {
            $default_labels['org.opencontainers.image.authors'] = $lastEdit['config']['Labels']['maintainer'];
        }
        $this->labels = $default_labels;

    }

    /**
     * Creates a Labels object from the tag's data.
     */
    public function getLabels():Labels{
        return new Labels($this->labels, $this->tag_name);
    }

    public function deleteTag():mixed{
        $headers = [
            'Accept:application/vnd.docker.distribution.manifest.v2+json'
        ];

        $url = REGISTRY_URL."/v2/".$this->parent_repository_name."/manifests/".$this->tag_digest;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        //curl_setopt($curl, CURLOPT_HEADER, true);
        
        //curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        return $resp;
    }
}