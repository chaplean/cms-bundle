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

### Step:

###### Add configuration in config.yml

```yaml
chaplean_cms:
    modules:
        block: boolean|array # Required, action available: ['add', 'remove']
        page: boolean|array # Required, action available: ['add', 'remove']
        post:
            category: boolean|array # Required, type available ['news', 'testimonial', 'video', 'zoom']
            action: boolean|array # Required, action available: ['add', 'duplicate', 'remove']
        media: boolean # Required
    template:
        front_layout: # Required view extended by page/post view (example: 'ChapleanCmsBundle::layout-frontoffice.html.twig')
        front_route: # Optional (default: 'app_front'), route name for return to main site
        logo_path: # Optional (default: ''), path of logo top left
        page_index: # Optional (default: 'ChapleanCmsBundle:Front/Page:index.html.twig'), Custom frontend page list
        page_view: # Optional (default: 'ChapleanCmsBundle:Front/Page:view.html.twig'), Custom frontend page
        post_index: # Optional (default: 'ChapleanCmsBundle:Front/Post:index.html.twig'), Custom frontend post list
        post_view: # Optional (default: 'ChapleanCmsBundle:Front/Post:view.html.twig'), Custom frontend post
```

[Notice]: `front_layout` must contain a block twig named `content` else see `page_index`, `page_view`, `post_index`, `post_view` if you want override default view for these modules.

###### Add ChapleanCmsBundle for doctrine
```yaml
doctrine:
    orm:
        #...
        entity_managers:
            app:
                mappings:
                    mappings:
                        #...
                        ChapleanCmsBundle: ~
```

###### Add ChapleanCmsBundle for assetic
```yaml
assetic:
    #...
    bundles: ['ChapleanCmsBundle']
```

###### Add route in routing.yml
```yaml
chaplean_cms:
    resource: "@ChapleanCmsBundle/Resources/config/routing.yml"

chaplean_cms_rest:
    type: rest
    resource: "@ChapleanCmsBundle/Resources/config/routing_rest.yml"
    prefix:   /rest/
```

##### Add migration
```php
<?php

// Add this in migration

/** @var Kernel $kernel */
$kernel = $this->container->get('kernel');
$application = new Application($kernel);
$application->setAutoExit(false);

$options = array('command' => 'doctrine:fixtures:load', '--fixtures' => 'vendor/chaplean/cms-bundle/Chaplean/Bundle/CmsBundle/DataFixtures/ORM', '--append' => true);
$application->run(new ArrayInput($options));

```

##### Build translations
```shell
php bin/console bazinga:js-translation:dump
```