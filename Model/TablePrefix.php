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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
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
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Sets the value of namespace.
     *
     * @param mixed $namespace the namespace
     *
     * @return self
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }
}
