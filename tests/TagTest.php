<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * @author Samuel BERTIN - ASTEN Cloud - Stagiaire MCO
 * The test class for the Registry class.
 * 
 * Tests to be passed with a specific registry image
 */
final class TagTest extends TestCase {

    public function testCreateRegistryAndRepository():Repository {
        $registry = new Registry(REGISTRY_URL);
        $repository = $registry->getRepository('traefik');
        $this->assertEquals(1,1);
        return $repository;
    }

    /**
     * @depends testCreateRegistryAndRepository
     */
    public function testTagCanBeCreatedFromValidName(Repository $repository):Tag{
        $tag = $repository->getTag("2.6-10");
        $this->assertInstanceOf(Tag::Class,$tag);
        return $tag;
    }

    /**
     * @depends testCreateRegistryAndRepository
     */
    public function testTagCannotBeCreatedFromInvalidName(Repository $repository):void{
        $this->expectException(InvalidArgumentException::class);
        $tag = $repository->getTag("7.4");
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testTagGetterParentRepositoryName(Tag $tag):void{
        $this->assertEquals('traefik', $tag->getParentRepositoryName());
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testTagGetterV1ManifestIsVersion1(Tag $tag):void{
        $this->assertEquals(1, $tag->getV1Manifest()["schemaVersion"]);
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testTagGetterV2ManifestIsVersion2(Tag $tag):void{
        $this->assertEquals("2", substr($tag->getV2ManifestAsString(), 22, 1));
        $this->assertEquals(2, $tag->getV2ManifestAsArray()["schemaVersion"]);
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightV1Manifest(Tag $tag):void{
        $this->assertEquals("NFXN:ZEKM:7XJC:GEKI:SE5F:GUJ5:PNNX:YDJD:PN5J:WXRM:YXU2:INUU", $tag->getV1Manifest()['signatures'][0]['header']['jwk']['kid']);
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightV1ConfigsArrayFromManifest(Tag $tag):void{
        $this->assertEquals(4, count($tag->getV1Configs()));
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightV2Manifest(Tag $tag):void{
        $this->assertEquals(740, strlen($tag->getV2ManifestAsString()));
        $this->assertEquals("sha256:09ad5add8ccf7c94125d416c9eb0a54147125fb662bd236b396bac2b293f4d94", $tag->getV2ManifestAsArray()['config']['digest']);
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightTagDigest(Tag $tag):void{
        $this->assertEquals("sha256:c10f4f4bfacf8ab47a6408e87b9d491b3478da17c4e7842a789b83770cc68705", $tag->getTagDigest());
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightTagArchitecture(Tag $tag):void{
        $this->assertEquals(array("ppc64le"), $tag->getArchitecture());
    }

    public function testGettingTheRightTagArchitectures():void {
        $registry = new Registry(REGISTRY_URL);
        $repository = $registry->getRepository('nginx');
        $multi_arch_tag = $repository->getTag('3.16');
        $this->assertEquals(
            array("amd64", "ppc64le"),
            $multi_arch_tag->getArchitecture()
        );
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightTagLayers(Tag $tag):void{
        $this->assertEquals(
            array(
                '0'=>"sha256:a3ed95caeb02ffe68cdd9fd84406680ae93d633cb16422d00e8a7c22955b46d4",
                '1'=>"sha256:fe46d1f2bd233f7937ef29b3dd2489cc1d5d1e21d4387f4afc29fe61a5c56046",
                '2'=>"sha256:a3ed95caeb02ffe68cdd9fd84406680ae93d633cb16422d00e8a7c22955b46d4",
                '3'=>"sha256:159b5dcb1717c815c76ff5ea1db730e18e8609c9090238e43282856db9e71f47"
            ),
            $tag->getTagLayers()
        );
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightLatestDate(Tag $tag):void{
        $this->assertEquals("2022-01-26 16:17:58", $tag->getLatestDate());
    }

    /**
     * @depends testTagCanBeCreatedFromValidName
     */
    public function testGettingTheRightCmdConfigs(Tag $tag):void{
        $this->assertEquals(
            array(
                '0'=>"PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin",
                '1'=>"/bin/sh",
                '2'=>"/bin/sh -c #(nop) COPY file:898eeb74466d7887aea087d71dd9fd023c1b2c6d9019d255c0c5f3af8563ac12 in /usr/local/bin ",
                '3'=>"/bin/sh -c #(nop)  CMD [\"/bin/sh\"]",
                '4'=>"/bin/sh -c #(nop) ADD file:57115dca2eb707f46b6301e75174e6aa316fb02ac28643b91429b75be51bd8c8 in / "
            ),
            $tag->getCmdConfigs()
        );
    }
    

}

?>