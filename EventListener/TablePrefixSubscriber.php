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
        if ($classMetadata instanceof ClassMetadata) {
            $prefix=$this->getPrefix($classMetadata->namespace);
            if ($prefix && $this->isValid($classMetadata)) {
                $classMetadata->table['name']=$prefix.strtolower($classMetadata->getTableName());
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
    }

    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

    private function isValid(ClassMetadata $classMetadata)
    {
        return !$classMetadata->isInheritanceTypeSingleTable() && $classMetadata->isRootEntity();
    }

    private function getPrefix($namespace)
    {
        foreach ($this->prefixes as $tablePrefix) {
            if (strstr($namespace,$tablePrefix->getNamespace())) {
                return strtolower($tablePrefix->getName());
            }
        }

        return null;
    }
}
