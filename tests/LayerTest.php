<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * The test class for the Registry class.
 * 
 * Tests to be passed with a specific registry image
 */
final class LayerTest extends TestCase {

    public function testCreateRegistryRepositoryAndTag():Tag{
        $registry = new Registry(REGISTRY_URL);
        $repository = $registry->getRepository('traefik');
        $tag = $repository->getTag('2.6-10');
        $this->assertEquals(1,1);
        return $tag;
    }

    /**
     * @depends testCreateRegistryRepositoryAndTag
     */
    public function testLayerCanBeCreatedFromValidDigest(Tag $tag):Layer{
        $layer = $tag->getLayer("sha256:a3ed95caeb02ffe68cdd9fd84406680ae93d633cb16422d00e8a7c22955b46d4");
        $this->assertInstanceOf(Layer::class, $layer);
        return $layer;
    }

    /**
     * @depends testCreateRegistryRepositoryAndTag
     */
    public function testLayerCannotBeCreatedFromInvalidDigest(Tag $tag):void{
        $this->expectException(InvalidArgumentException::class);
        $layer = $tag->getLayer("sha256:a3ed95caeb02ffe68cdd9fd84406680ae93d633cb16422d00e8a7c22955b46e6");
    }

    /**
     * @depends testLayerCanBeCreatedFromValidDigest
     */
    public function testGetterParentTagName(Layer $layer):void{
        $this->assertEquals('2.6-10', $layer->getParentTag());
    }

    /**
     * @depends testLayerCanBeCreatedFromValidDigest
     */
    public function testGetterLayerDigest(Layer $layer):void{
        $this->assertEquals('sha256:a3ed95caeb02ffe68cdd9fd84406680ae93d633cb16422d00e8a7c22955b46d4', $layer->getLayerDigest());
    }

}

?>