Getting Started With The KristofvcListBundle
============================================

## Prerequisites

This version of the bundle requires Symfony 2.2+.

## Installation

Installation is a quick process:

1. Download KristofvcListBundle using composer
2. Enable the Bundle
3. Create your list's configuration
4. Add the configuration as a service
5. Render the list

### Step 1: Download KristofvcListBundle using composer

Add KristofvcListBundle in your composer.json:

```js
{
    "require": {
        "kristofvc/kristofvc-list-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update kristofvc/kristofvc-list-bundle
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

To render a list of certain object you got to make a simple service telling this bundle how to render your list. To start this configuration, you need to extend the 'Kristofvc\ListBundle\Configuration\AbstractListConfiguration'-class.
The following example is for a list of users.

```php
    <?php

    namespace UserBundle\Helper;

    use Kristofvc\ListBundle\Model\Column;
    use Kristofvc\ListBundle\Model\Action;
    use Kristofvc\ListBundle\Configuration\AbstractListConfiguration;
    use Kristofvc\ListBundle\Model\Filters\StringFilter;
    use Kristofvc\ListBundle\Model\Filters\DateFilter;

    class UserListConfiguration extends AbstractListConfiguration
    {
        public function buildColumns(){
            $this->addColumn(new Column('Email', 'E-mail', true));
            $this->addColumn(new Column('Name', 'Name', true, 'lastname, i.firstname'));
            $this->addColumn(new Column('Groups', 'Groups', false));
            $this->addColumn(new Column('LastLogin', 'Last logged in at', true)); 
        }

        public function buildActions(){
            $this->addAction(new Action('edit', 'admin_user_edit', array('Id'), 'icon-edit'));
            $this->addAction(new Action('edit', 'admin_user_deleteuser', array('Id'), 'icon-trash', true, 'danger', true));
        }

        public function buildFilters(){
            $this->addFilter(new StringFilter('E-mail', 'email'));
            $this->addFilter(new StringFilter('Firstname', 'firstname'));
            $this->addFilter(new StringFilter('Lastname', 'lastname'));
            $this->addFilter(new DateFilter('Last login', 'lastLogin'));
        }

        public function getRepository(){
            return "AcmeDemoBundle:User";
        }

        public function buildQuery(&$qb){
            $qb->andWhere('i.deletedAt is null');
        }
    }
```

As you can see, when you extend the AbstractListConfiguration, you need to implement some methods. 
First one is a method to build the columns of your list. You first need to specify a name for each column. This name is also used for rendering the value for each object. So every column-name you defined needs a get-, has- or is-method in your object's class.
Next is the header for the column. After that you can optionally set or the column needs sorting functionality and which fields you want to sort on (if no fields are defined, it takes the column-name).

Then you can add some actions to your list. In the example we have two actions, an edit action, and a delete action. An action takes a name, a route and routeparameters. Optionally you can define an icon, if the action needs confirmation with a dialog and which colour the button has.

You can also define on which fields you want filtering. For each field you can choose different sorts of filters.

- StringFilter
- DateFilter
- ...
- [You can also define your own filters. Look here for more information.] (https://github.com/kristofvc/KristofvcListBundle/blob/master/Resources/doc/custom_filters.md) 

Next you define which entity you want to build your list with and you optionally define some extra parameters for your query.

### Step 4: Add the configuration as a service

For render the list you need to add it as a service.

```yml
    services:
        users.list.configuration:
            class: UserBundle\Helper\UserListConfiguration
```

### Step 5: Render the list

Next render the list in you twig-file.

```twig
    {{ renderList('users.list.configuration') }}
```
 
