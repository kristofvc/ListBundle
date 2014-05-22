Configuration
=============

## Global configuration

You can overwrite the default configuration by adding the following in app/config/config.yml

```yml
    kristofvc_list:
        items_per_page: 15 # how many rows does your list render per page
        page_parameter_name: page # the url-parametername to switch between pages in your list
        list_template: KristofvcListBundle:ListTemplates:default_list.html.twig # the template for rendering you list.
        column_empty_value:
```

Above we've added the config with the default values. All options in the configuration are optional. 

## Custom configuration

### List-configuration

You can add a method with parameters to your list-configuration.

```php
    ...
    public function getDefaultParams()
    {
        return array(
            'items_per_page' => 20
            'column_empty_value' => 'N/A'
        );
    }
```

### Twig

The above configuration is global, for every list you define, though you can also pass a custom configuration per list.
You can do this by adding a list of parameters in the renderList-function.

```twig
    {{ renderList(listConfiguration, { 'list_template': 'AcmeDemoBundle:User:userfancylist.html.twig', 'page_parameter_name': 'userpage', 'items_per_page': 10 }) }}
```

### Extra parameters

If you define a custom template, you maybe want to add some parameters to pass to this template. 
In the renderList function in twig and the getDefaultParams function in your list-configuration you can add the parameters you want.
In your custom template you can use all parameters calling `params`.

## Loading the parameters

Parameters will be loaded the way they are described above. First the global configuration will be loaded. These parameters will be overwritten by the parameters in your list-configuration. After that the parameters are overwritten by the ones given in the renderList method in twig.

So TL;DR, global configuration < list-configuration < twig
