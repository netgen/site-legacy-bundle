Netgen More Legacy Bundle installation instructions
===================================================

Requirements
------------

* eZ Publish 5.4+ / eZ Publish Community Project 2014.11+

Installation steps
------------------

### Use Composer

Add the following to your composer.json and run `php composer.phar update netgen/more-legacy-bundle` to refresh dependencies:

```json
"repositories": [
    { "type": "composer", "url": "http://packagist.netgen.biz" }
],
"require": {
    "netgen/more-legacy-bundle": "~2.1.0"
}
```

### Activate the bundle

Activate the bundle in `ezpublish\EzPublishKernel.php` file.

```php
public function registerBundles()
{
   ...

    $bundles[] = new \Netgen\Bundle\MoreLegacyBundle\NetgenMoreLegacyBundle();

    return $bundles;
}
```

### Clear the caches

Clear eZ Publish 5 caches.

```bash
php ezpublish/console cache:clear
```
