Getting Started With ChapleanCmsBundle
=======================================

# Prerequisites

This version of the bundle requires Symfony 2.8+.

### Installation

Include ChapleanCmsBundle in `composer.json`

``` json
composer require chaplean/cms-bundle
```

Add bundle in `AppKernel.php`

```php
<?php
    //...
    public function registerBundles()
    {
        return array (
            //...
            new Chaplean\Bundle\CmsBundle\ChapleanCmsBundle(),
        );
    }
```
