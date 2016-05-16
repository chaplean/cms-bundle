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

### Configuration:

1. config.yml
```yaml
chaplean_cms:
    modules:
        block: boolean|array # Required, action available: ['add', 'remove']
        page: boolean|array # Required, action available: ['add', 'remove']
        post:
            category: boolean|array # Required, type available ['news', 'testimonial', 'video', 'zoom']
            action: boolean|array # Required, action available: ['add', 'duplicate', 'remove']
        media: boolean|array # Required, array containing extension file authorized (example: ['pdf', 'png']) ?????
    template:
        front_layout: # Required, view frontend for modules page, post. (example: )
        front_route: # Optional (default: 'app_front'), route name for return to main site
        logo_path: # Optional (default: ''), path of logo top left
        page_index: # Optional (default: 'ChapleanCmsBundle:Front/Page:index.html.twig'), Custom frontend page list
        page_view: # Optional (default: 'ChapleanCmsBundle:Front/Page:view.html.twig'), Custom frontend page
        post_index: # Optional (default: 'ChapleanCmsBundle:Front/Post:index.html.twig'), Custom frontend post list
        post_view: # Optional (default: 'ChapleanCmsBundle:Front/Post:view.html.twig'), Custom frontend post
```

2. routing.yml
```yaml
chaplean_cms_bundle:
    resource: '@ChapleanCmsBundle/Resources/config/routing.yml'
```

