KristofvcListBundle [![Build Status](https://travis-ci.org/kristofvc/KristofvcListBundle.png?branch=master)](https://travis-ci.org/kristofvc/KristofvcListBundle)
===================

This bundle is used for rendering a list of objects. After setting up a configuration for your list, you can sort columns, filter items and view paginated data.

## Install

require the bundle in your composer.json "kristofvc/kristofvc-list-bundle": "dev-master"

```php
composer update kristofvc/kristofvc-list-bundle
```
Add the following to app/AppKernel.php:

```php
new Kristofvc\ListBundle\KristofvcListBundle()
```

## Example configuration

Below is an example configuration for a list of users.


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
            $this->addColumn(new Column('Email', 'admin.list.email', true));
            $this->addColumn(new Column('Name', 'admin.list.name', true, 'lastname, i.firstname'));
            $this->addColumn(new Column('Groups', 'admin.list.groups', false));
            $this->addColumn(new Column('LastLogin', 'admin.list.lastactive', true)); 
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

## Rendering the list

You got to make a service for your configuration:

```php
    services:
        users.list.configuration:
            class: UserBundle\Helper\UserListConfiguration
```

You can then render your list by putting the following in your view:

```twig
    {{ renderList('users.list.configuration') }}
```


## TODO

- More filters
- Documentation (custom templates, configuration, ...)
- Cleanup
