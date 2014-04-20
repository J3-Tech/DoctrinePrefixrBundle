<?php

namespace DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\Model;

/**
 * @author Dickriven Chellemboyee <jchellem@gmail.com>
 */
class TablePrefix
{
    protected $name;
    protected $namespace;

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Sets the value of namespace.
     *
     * @param string $namespace the namespace
     *
     * @return self
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }
}
