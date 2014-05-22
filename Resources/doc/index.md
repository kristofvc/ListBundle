Getting Started With The ListBundle
============================================

## Prerequisites

This version of the bundle requires Symfony 2.2+.

## Installation

Installation is a quick process:

1. Download ListBundle using composer
2. Enable the Bundle
3. Create your list's configuration
4. Initialize your configuration
5. Render the list

### Step 1: Download ListBundle using composer

Add KristofvcListBundle in your composer.json:

```js
{
    "require": {
        "kristofvc/list-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update kristofvc/list-bundle
```

Composer will install the bundle to your project's `vendor/kristofvc` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Kristofvc\ListBundle\KristofvcListBundle(),
    );
}
```

### Step 3: Create your list's configuration

To render a list of certain object you got to make a simple service telling this bundle how to render your list. To start this configuration, you need to extend the 'Kristofvc\ListBundle\Configuration\AbstractListORMConfiguration'-class.
The following example is for a list of users.

```php
    <?php

    namespace UserBundle\Helper;

    use Kristofvc\ListBundle\Model\Column;
    use Kristofvc\ListBundle\Model\Action;
    use Kristofvc\ListBundle\Configuration\AbstractListConfiguration;
    use Kristofvc\ListBundle\Model\Filters\StringFilter;
    use Kristofvc\ListBundle\Model\Filters\DateFilter;

    class UserListConfiguration extends AbstractListORMConfiguration
    {
        public function buildColumns(){
            $this->addColumn(new Column('Email', 'E-mail', array('sortable' => true)));
            $this->addColumn(new Column('Name', 'Name', array('sortable' => true, 'sortField' => 'lastname, i.firstname', 'route' => 'admin_user_edit', 'routeParams' => array('Id'))));
            $this->addColumn(new Column('Groups', 'Groups');
            $this->addColumn(new Column('LastLogin', 'Last logged in at', array('sortable' => true));
        }

        public function buildActions(){
            $this->addAction(new Action('edit', 'admin_user_edit', array('Id'), array('icon' => 'icon-edit'));
            $this->addAction(new Action('edit', 'admin_user_deleteuser', array('Id'), array('icon' => 'icon-trash', 'iconWhite'=> true, 'btnColour' => 'danger', 'modal' => true));
        }

        public function buildFilters(){
            $this->addFilter(new StringORMFilter('E-mail', 'email'));
            $this->addFilter(new StringORMFilter('Firstname', 'firstname'));
            $this->addFilter(new StringORMFilter('Lastname', 'lastname'));
            $this->addFilter(new DateORMFilter('Last login', 'lastLogin'));
        }

        public function getRepository(){
            return "AcmeDemoBundle:User";
        }

        public function buildQuery(QueryBuilder &$qb){
            $qb->andWhere('i.deletedAt is null');
        }
    }
```

As you can see, when you extend the AbstractListORMConfiguration, you need to implement some methods.
First one is a method to build the columns of your list. You first need to specify a name for each column. This name is also used for rendering the value for each object. So every column-name you defined needs a get-, has- or is-method in your object's class.
Next is the header for the column. After that you can optionally set or the column needs sorting functionality and which fields you want to sort on (if no fields are defined, it takes the column-name).
You can then also add a route en route-parameters to link values in the column to (see column 'name').

Then you can add some actions to your list. In the example we have two actions, an edit action, and a delete action. An action takes a name, a route and routeparameters. Optionally you can define an icon, if the action needs confirmation with a dialog and which colour the button has.

You can also define on which fields you want filtering. For each field you can choose different sorts of filters.

- StringORMFilter
- DateORMFilter
- ...
- [You can also define your own filters. Look here for more information.] (https://github.com/kristofvc/ListBundle/blob/master/Resources/doc/custom_filters.md) 

Next you define which entity you want to build your list with and you optionally define some extra parameters for your query.

### Step 4: Initialize your configuration

To render the list you need to initialitize the list in your controller or add it as a service and fetch it in the controller.

```php
  return array(..., 'listConfiguration' => new , ...)
```

### Step 5: Render the list

Next render the list in you twig-file.

```twig
    {{ renderList(listConfiguration) }}
```
 
## Read more 
- [configuration](https://github.com/kristofvc/ListBundle/blob/master/Resources/doc/configuration.md)
- [custom filters](https://github.com/kristofvc/ListBundle/blob/master/Resources/doc/custom_filters.md)
- [custom templates](https://github.com/kristofvc/ListBundle/blob/master/Resources/doc/custom_templates.md)
