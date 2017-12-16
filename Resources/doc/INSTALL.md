Netgen More Legacy Bundle installation instructions
===================================================

Requirements
------------

* eZ Platform 2.0+

Installation steps
------------------

### Use Composer

Add the following to your `composer.json` and run `composer update netgen/more-legacy-bundle` to refresh dependencies:

```json
"repositories": [
    { "type": "composer", "url": "https://packagist.netgen.biz" }
],
"require": {
    "netgen/more-legacy-bundle": "~4.0.0"
}
```

### Activate the bundle

Activate the bundle in `app/AppKernel.php` file.

```php
public function registerBundles()
{
   ...

    $bundles[] = new Netgen\Bundle\MoreLegacyBundle\NetgenMoreLegacyBundle();

    return $bundles;
}
```

### Clear the caches

Clear eZ Platform caches.

```bash
php bin/console cache:clear
```
