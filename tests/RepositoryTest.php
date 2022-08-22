<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * @author Samuel BERTIN - ASTEN Cloud - Stagiaire MCO
 * The test class for the Registry class.
 * 
 * Tests to be passed with a specific registry image
 */
final class RepositoryTest extends TestCase {

    public function testCreateRegistry():Registry {
        $registry = new Registry(REGISTRY_URL);
        $this->assertEquals(1,1);
        return $registry;
    }

    /**
     * @depends testCreateRegistry
     */
    public function testRepositoryCanBeCreatedFromValidName(Registry $registry):Repository {   
        $repository = $registry->getRepository("traefik");
        $this->assertInstanceOf(Repository::class, $repository);
        return $repository;
    }

    /**
     * @depends testCreateRegistry
     */
    public function testRepositoryCannotBeCreatedFromInvalidName(Registry $registry):void {
        $this->expectException(InvalidArgumentException::Class);
        $registry->getRepository("trafik");
    }

    /**
     * @depends testRepositoryCanBeCreatedFromValidName
     */
    public function testRepositoryGetterForName(Repository $repository):void {
        $this->assertEquals("traefik", $repository->getName());
    }

    /**
     * @depends testRepositoryCanBeCreatedFromValidName
     */
    public function testRepositoryGetterForTags(Repository $repository):void {
        $this->assertEquals(
            $repository->getTags(),
            array("2.6-10")
        );
    }

    /**
     * @depends testRepositoryCanBeCreatedFromValidName
     */
    public function testRepositoryGetterForTagsCount(Repository $repository):void {
        $this->assertEquals($repository->getTagsCount(),1);
    }
    
}

?>