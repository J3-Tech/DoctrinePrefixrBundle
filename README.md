DoctrinePrefixrBundle
=====================

[![Build Status](https://travis-ci.org/labzone/DoctrinePrefixrBundle.svg?branch=master)](https://travis-ci.org/labzone/DoctrinePrefixrBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chellem/DoctrinePrefixrBundle/badges/quality-score.png?s=548f05c416af4f98cd95dfc62990394745be0e43)](https://scrutinizer-ci.com/g/chellem/DoctrinePrefixrBundle/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/15656e81-c087-43a0-869c-dcbed55abb1f/mini.png)](https://insight.sensiolabs.com/projects/15656e81-c087-43a0-869c-dcbed55abb1f)

## What is does ?

This bundle add "prefix" to table, configured from the Bundle the entities is found.

For example, entities in AcmeDemo can have the prefix acme_demo and AcmeLogin might have acme_login

## Installation

using [Composer](https://getcomposer.org):

```json
{
    "require": {
        "chellem/doctine-prefixr-bundle": "dev-master"
    }
}
```

## CONFIGURATION
Register the bundle:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\DoctrinePrefixrBundle(),
    );
    // ...
}
```

Configuration in your config.yml:

```yaml
# app/config/config.yml
doctrine_prefixr:
    prefixes:
        # no need to add 'Bundle' to the Bundle name
        AcmeDemo: acme_demo
        AcmeLogin: acme_login
        MyCustom: my_custom
```
