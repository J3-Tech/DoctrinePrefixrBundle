<?php
namespace DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\DependencyInjection\DoctrinePrefixrExtension;

/**
 * @author Dickriven Chellemboyee <jchellem@gmail.com>
 */
class DoctrinePrefixrExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldLoadServiceDefinition()
    {
        $container = new ContainerBuilder();
        $extension = new DoctrinePrefixrExtension();
        $extension->load(array(), $container);

        $this->assertTrue($container->hasDefinition('doctrine.prefixr'));
        $this->assertArrayHasKey('prefixes',$container->getParameter('doctrine_prefixr.prefixes'));
        $this->assertEquals('DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\EventListener\TablePrefixSubscriber', $container->getParameter('doctrine_prefixr.prefixer.class'));
    }
}
