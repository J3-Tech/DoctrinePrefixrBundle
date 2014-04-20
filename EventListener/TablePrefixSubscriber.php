<?php
namespace DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;
use DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\Model\TablePrefix;

/**
 * @author Dickriven Chellemboyee <jchellem@gmail.com>
 */
class TablePrefixSubscriber implements EventSubscriber
{
    protected $prefixes=array();

    public function __construct($container,array $prefixes)
    {
        $bundles=$container->getParameter('kernel.bundles');
        foreach ($prefixes as $name=>$prefix) {
            $bundleName="{$name}Bundle";
            if(array_key_exists($bundleName,$bundles)){
                $namespace=str_replace($bundleName,null,$bundles[$bundleName]);
                $tablePrefix=new TablePrefix();
                $tablePrefix->setName($prefix.'_')
                            ->setNamespace("{$namespace}Entity");
                $this->prefixes[]=$tablePrefix;
            }
        }
    }

    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $classMetadata = $args->getClassMetadata();
        $prefix=null;
        foreach ($this->prefixes as $tablePrefix) {
            if(strstr($classMetadata->namespace,$tablePrefix->getNamespace())){
                $prefix=$tablePrefix->getName();
            }
        }
        if(!$prefix){
            return;
        }
        if ($classMetadata->isInheritanceTypeSingleTable() && !$classMetadata->isRootEntity()) {
            return;
        }
        $classMetadata->setTableName($prefix . strtolower($classMetadata->getTableName()));
        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY) {
                $mappedTableName = strtolower($classMetadata->associationMappings[$fieldName]['joinTable']['name']);
                if(false === stripos($mappedTableName, $this->prefix)){
                    $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
                }
            }
        }
    }

}
