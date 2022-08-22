<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require __DIR__."/../src/php/config.php";
require __DIR__."/../src/php/classes/Registry.php";
require __DIR__."/../src/php/classes/Repository.php";
require __DIR__."/../src/php/classes/Tag.php";
require __DIR__."/../src/php/classes/Layer.php";
require __DIR__."/../src/php/classes/Labels.php";
require __DIR__."/../src/php/classes/Utils.php";

/**
 * @author Samuel BERTIN - ASTEN Cloud - Stagiaire MCO
 * The test class for the Registry class.
 * 
 * Tests to be passed with a specific registry image
 */
final class RegistryTest extends TestCase {

    public function testRegistryCanBeCreatedFromValidConfig():Registry {
        $registry = new Registry(REGISTRY_URL);
        $this->assertInstanceOf(Registry::class, $registry);
        return $registry;
    }

    public function testRegistryCannotBeCreatedFromInvalidConfig() {
        $this->expectException(InvalidArgumentException::class);
        $registry = new Registry(HOST."/".PORT);
    }

    public function testRegistryCannotBeCreatedFromInvalidType() {
        $this->expectException(TypeError::class);
        $registry = new Registry(50000);
    }

     /**
     * @depends testRegistryCanBeCreatedFromValidConfig
     */
    public function testGettingTheRepositoriesAsAnArray(Registry $registry):void{
        $this->assertTrue(
            is_array($registry->getRepositories())
        );
    }

    /**
     * @depends testRegistryCanBeCreatedFromValidConfig
     */
    public function testGettingTheRightRepositories(Registry $registry):void{
        $this->assertEquals(
            $registry->getRepositories(),
            array("mariadb", "nginx", "traefik")
        );
    }

    /**
     * @depends testRegistryCanBeCreatedFromValidConfig
     */
    public function testGettingTheRightRepositoriesCount(Registry $registry):void{
        $this->assertEquals($registry->getRepositoriesCount(),3);
    }

    

}