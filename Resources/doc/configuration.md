Configuration
=============

## Global configuration

You can overwrite the default configuration by adding the following in app/config/config.yml

```yml
    kristofvc_list:
        items_per_page: 15 # how many rows does your list render per page
        page_parameter_name: page # the url-parametername to switch between pages in your list
        list_template: KristofvcListBundle:ListTemplates:default_list.html.twig # the template for rendering you list.
```

Above we've added the config with the default values. All options in the configuration are optional. 

## Custom configuration

The above configuration is global, for every list you define, though you can also pass a custom configuration per list.
You can do this by adding a list of parameters in the renderList-function.

```twig
    {{ renderList('users.list.configuration', { 'list_template': 'AcmeDemoBundle:User:userfancylist.html.twig', 'page_parameter_name': 'userpage', 'items_per_page': 10 }) }}          
```

