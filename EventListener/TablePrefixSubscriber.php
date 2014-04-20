<?php
namespace DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;
use DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\Model\TablePrefix;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @author Dickriven Chellemboyee <jchellem@gmail.com>
 */
class TablePrefixSubscriber implements EventSubscriber
{
    protected $prefixes=array();

    public function __construct(array $bundles,array $prefixes)
    {
        foreach ($prefixes as $name=>$prefix) {
            $bundleName="{$name}Bundle";
            if (array_key_exists($bundleName,$bundles)) {
                $namespace=str_replace($bundleName,null,$bundles[$bundleName]);
                $tablePrefix=new TablePrefix();
                $tablePrefix->setName($prefix.'_')
                            ->setNamespace("{$namespace}Entity");
                $this->prefixes[]=$tablePrefix;
            }
        }
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $classMetadata = $args->getClassMetadata();
        if($classMetadata instanceof(ClassMetadata)){
            $prefix=null;
            foreach ($this->prefixes as $tablePrefix) {
                if (strstr($classMetadata->namespace,$tablePrefix->getNamespace())) {
                    $prefix=strtolower($tablePrefix->getName());
                    break;
                }
            }
            if (!$prefix || $classMetadata->isInheritanceTypeSingleTable() && !$classMetadata->isRootEntity()) {
                return;
            }
            $classMetadata->setTableName($prefix.strtolower($classMetadata->getTableName()));
            foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
                if ($mapping['type'] == ClassMetadata::MANY_TO_MANY) {
                    $mappedTableName = strtolower($classMetadata->associationMappings[$fieldName]['joinTable']['name']);
                    if (false === stripos($mappedTableName, $prefix)) {
                        $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $prefix.$mappedTableName;
                    }
                }
            }
        }
    }

    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

}
