<?php

declare(strict_types=1);

/**
 * @author Samuel BERTIN - ASTEN Cloud - Stagiaire MCO
 * 
 * This class gives all methods to set up and get the LABEL command data from the image's tag dockerfile / configuration.
 * Default labels are given if they do not exist within the image's tag configuration.
 */
final class Labels {

    private $parent_tag; // @var string the name of the parent tag
    private $authors; // @var string the author of the image dockerfile
    private $creation_date; // @var string the creation of the image 
    private $description; // @var string description of the image
    private $documentation; // @var string documentation link 
    private $commit_digest; // @var string digest from the latest commit 
    private $licenses; // @var string 
    private $reference_name; // @var string The reference name of the image
    private $revision; // @var string the revision number of the image
    private $source; // @var string the source repository of the image
    private $title; // @var string the image reference title
    private $url; // @var string the url to the image repository
    private $vendor; // @var string vendor of the image
    private $version; // @var stringthe version id of the image

    public function __construct(array $labels, string $tag_name){
        $this->parent_tag = $tag_name;
        $this->setAllLabels($labels);
    }

    public function setAuthors(array $labels):void{
        $this->authors = $labels['org.opencontainers.image.authors'];
    }

    public function setCreationDate(array $labels):void{
        $this->creation_date = $labels['org.opencontainers.image.created'];
    }

    public function setDescription(array $labels):void{
        $this->description = $labels['org.opencontainers.image.description'];
    }

    public function setDocumentation(array $labels):void{
        $this->documentation = $labels['org.opencontainers.image.documentation'];
    }

    public function setLicenses(array $labels):void{
        $this->licenses = $labels['org.opencontainers.image.licenses'];
    }
    
    public function setReferenceName(array $labels):void{
        $this->reference_name = $labels['org.opencontainers.image.ref.name'];
    }

    public function setRevision(array $labels):void{
        $this->revision = $labels['org.opencontainers.image.revision'];
    }

    public function setSource(array $labels):void{
        $this->source = $labels['org.opencontainers.image.source'];
    }

    public function setTitle(array $labels):void{
        $this->title = $labels['org.opencontainers.image.title'];
    }

    public function setURL(array $labels):void{
        $this->url = $labels['org.opencontainers.image.url'];
    }

    public function setVendor(array $labels):void{
        $this->vendor = $labels['org.opencontainers.image.vendor'];
    }

    public function setVersion(array $labels):void{
        $this->version = $labels['org.opencontainers.image.version'];
    }

    public function setCommitDigest(array $labels):void{
        $this->commit_digest = $labels['fr.groupe-asten.image.commit'];
    }

    public function setAllLabels(array $labels):void{
        $this->setAuthors($labels);
        $this->setCreationDate($labels);
        $this->setDescription($labels);
        $this->setDocumentation($labels);
        $this->setLicenses($labels);
        $this->setReferenceName($labels);
        $this->setRevision($labels);
        $this->setSource($labels);
        $this->setTitle($labels);
        $this->setURL($labels);
        $this->setVendor($labels);
        $this->setVersion($labels);
        $this->setCommitDigest($labels);
    }

    public function getParentTag():String{
        return $this->parent_tag;
    }

    public function getAuthors():String{
        return htmlspecialchars($this->authors);
    }

    public function getCreationDate():String{
        return $this->creation_date;
    }

    public function getDescription():String{
        return $this->description;
    }

    public function getDocumentation():String{
        return $this->documentation;
    }

    public function getLicenses():String{
        return $this->licenses;
    }
    
    public function getReferenceName():String{
        return $this->reference_name;
    }

    public function getRevision():String{
        return $this->revision;
    }

    public function getSource():String{
        return $this->source;
    }

    public function getTitle():String{
        return $this->title;
    }

    public function getURL():String{
        return $this->url;
    }

    public function getVendor():String{
        return $this->vendor;
    }

    public function getVersion():String{
        return $this->version;
    }

    public function getCommitDigest():String{
        return $this->commit_digest;
    }

}

?>