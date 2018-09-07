Netgen Site Legacy Bundle installation instructions
===================================================

Requirements
------------

* eZ Platform 2.0+

Installation steps
------------------

### Use Composer

Run the following to install the bundle:

```bash
composer require netgen/site-legacy-bundle
```

### Activate the bundle

Activate the bundle and all dependencies in `app/AppKernel.php` file.

```php
public function registerBundles()
{
   ...

    $bundles[] = new eZ\Bundle\EzPublishLegacyBundle\EzPublishLegacyBundle($this);
    $bundles[] = new Netgen\Bundle\RichTextDataTypeBundle\NetgenRichTextDataTypeBundle();
    $bundles[] = new Netgen\Bundle\SiteLegacyBundle\NetgenSiteLegacyBundle();

    return $bundles;
}
```

### Activate the legacy extensions

Activate the following legacy extensions:

```ini
[ExtensionSettings]
ActiveExtensions[]=ngsymfonytools
ActiveExtensions[]=ngclasslist
ActiveExtensions[]=enhancedselection2
ActiveExtensions[]=ezplatformsearch
ActiveExtensions[]=eztags
ActiveExtensions[]=ezrichtext
ActiveExtensions[]=birthday
ActiveExtensions[]=hideuntildate
ActiveExtensions[]=ezclasslists
ActiveExtensions[]=ezchangeclass
ActiveExtensions[]=xrowmetadata
```


### Clear the caches

Clear eZ Platform caches.

```bash
php bin/console cache:clear
```
