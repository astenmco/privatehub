<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * @author Samuel BERTIN - ASTEN Cloud - Stagiaire MCO
 * The test class for the Registry class.
 * 
 * Tests to be passed with a specific registry image
 */
final class LabelsTest extends TestCase {

    public function testCreateRegistryRepositoryAndUnlabbeledTag():Tag{
        $registry = new Registry(REGISTRY_URL);
        $repository = $registry->getRepository('traefik');
        $tag = $repository->getTag('2.6-10');
        $this->assertEquals(1,1);
        return $tag;
    }

    public function testCreateRegistryRepositoryAndLabbeledTag():Tag{
        $registry = new Registry(REGISTRY_URL);
        $repository = $registry->getRepository('mariadb');
        $tag = $repository->getTag('10.6-amd64');
        $this->assertEquals(1,1);
        return $tag;
    }

    /**
     * @depends testCreateRegistryRepositoryAndUnlabbeledTag
     */
    public function testLabelsCanBeCreatedFromUnlabelledImageTag(Tag $tag):Labels{
        $labels =  $tag->getLabels();
        $this->assertInstanceOf(Labels::class, $labels);
        return $labels;
    }

    /**
     * @depends testCreateRegistryRepositoryAndLabbeledTag
     */
    public function testLabelsCanBeCreatedFromLabelledImageTag(Tag $tag):Labels{
        $labels =  $tag->getLabels();
        $this->assertInstanceOf(Labels::class, $labels);
        return $labels;
    }

    /**
     * @depends testLabelsCanBeCreatedFromUnlabelledImageTag
     */
    public function testUnlabelledImageGetters(Labels $labels):void{
        $this->assertEquals("2.6-10", $labels->getParentTag());
        $this->assertEquals("Unknown", $labels->getAuthors());
        $this->assertEquals("", $labels->getCreationDate());
        $this->assertEquals("Description not found.", $labels->getDescription());
        $this->assertEquals("", $labels->getDocumentation());
        $this->assertEquals("", $labels->getLicenses());
        $this->assertEquals("", $labels->getReferenceName());
        $this->assertEquals("", $labels->getRevision());
        $this->assertEquals("", $labels->getSource());
        $this->assertEquals("", $labels->getTitle());
        $this->assertEquals("", $labels->getURL());
        $this->assertEquals("Asten Cloud", $labels->getVendor());
        $this->assertEquals("", $labels->getVersion());
    } 

    /**
     * @depends testLabelsCanBeCreatedFromLabelledImageTag
     */
    public function testLabelledImageGetters(Labels $labels):void{
        $this->assertEquals("10.6-amd64", $labels->getParentTag());
        $this->assertEquals("Guillaume BITON &lt;guillaume.biton@groupe-asten.fr", $labels->getAuthors());
        $this->assertEquals("2022-05-10 15:29:20+00:00", $labels->getCreationDate());
        $this->assertEquals("A MariaDB container designed to fit asten-clouds's needs.", $labels->getDescription());
        $this->assertEquals("https://gitea.easylinux.fr/asten-oc-common/mariadb/src/branch/main/README.md", $labels->getDocumentation());
        $this->assertEquals("", $labels->getLicenses());
        $this->assertEquals("common/mariadb", $labels->getReferenceName());
        $this->assertEquals("10.6-030", $labels->getRevision());
        $this->assertEquals("https://gitea.easylinux.fr/asten-oc-common/mariadb/src/branch/main", $labels->getSource());
        $this->assertEquals("MariaDB", $labels->getTitle());
        $this->assertEquals("https://gitea.easylinux.fr/asten-oc-common/mariadb", $labels->getURL());
        $this->assertEquals("Asten Cloud", $labels->getVendor());
        $this->assertEquals("10.6", $labels->getVersion());
    } 

}

?>