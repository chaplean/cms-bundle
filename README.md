ChapleanCmsBundle
=================

### Configuration:
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

