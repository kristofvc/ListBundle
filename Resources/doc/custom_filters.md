Custom filters
==============

Let's make a DateFilter (which already exists).

## The class

```php
  <?php

  namespace Kristofvc\ListBundle\Model\Filters;

  use Doctrine\ORM\QueryBuilder;
  use Kristofvc\ListBundle\Model\ORMFilter;

  class DateORMFilter extends ORMFilter
  {
      const COMP_BEFORE = 'before';
      const COMP_AFTER = 'after';

      public function addFilter(QueryBuilder &$qb, $id, $data)
      {
          switch ($data['comparator']) {
              case self::COMP_BEFORE:
                  $qb->andWhere($qb->expr()->lte($this->identifier . '.' . $this->field, ':var_' . $id))
                     ->setParameter('var_' . $id, $data['value']);
                  break;
              case self::COMP_AFTER:
                  $qb->andWhere($qb->expr()->gte($this->identifier . '.' . $this->field, ':var_' . $id))
                     ->setParameter('var_' . $id, $data['value']);
                  break;
          }
      }

      public function getTemplate()
      {
          return 'KristofvcListBundle:Filters:dateFilter.html.twig';
      }

      public function getDataFields()
      {
          return array('value', 'comparator');
      }
  }
```

We have the getDataFields method. In this method you can define the names of the fields that have to be filled in to make the filter work.
In this example, for this filter, we have a comparator-field and a value-field. 
You filter class also needs to have a template, returned by the getTemplate method. 

In the addFilter method you define which clauses needs to be added to the querybuilder when a user wants to filter.
For a datefilter we have two states, date is before the given date or date is after the given date.

## The template

```twig
    <label class="control-label">{{ filter.name }}</label>
    <div class="controls">
        <select name="{{filter.field}}comparator{% if index is defined and index %}{{index}}{% else %}__index__{% endif %}">
            <option value="{{ constant("Kristofvc\\ListBundle\\Model\\Filters\\DateFilter::COMP_BEFORE") }}" {% if data.comparator is defined and data.comparator == constant("Kristofvc\\ListBundle\\Model\\Filters\\DateFilter::COMP_BEFORE") %} selected="selected" {% endif %} >
                {{ "before" | trans }}
            </option>
            <option value="{{ constant("Kristofvc\\ListBundle\\Model\\Filters\\DateFilter::COMP_AFTER") }}" {% if data.comparator is defined and data.comparator == constant("Kristofvc\\ListBundle\\Model\\Filters\\DateFilter::COMP_AFTER") %} selected="selected" {% endif %} >
                {{ "after" | trans }}
            </option>
        </select>
        <div class="input-append">
            <input type="text" class="datepicker datepicker{% if index is defined and index %}{{index}}{% else %}__index__{% endif %}" name="{{filter.field}}value{% if index is defined and index %}{{index}}{% else %}__index__{% endif %}" placeholder="{{ "date" | trans }}" {% if data.value is defined %}value="{{data.value}}"{% endif %} />
            <span class="add-on datepickerbtn"><a href="#" class=" datepickerbtn{% if index is defined and index %}{{index}}{% else %}__index__{% endif %}"><i class="icon-calendar"></i></a></span>
        </div>    
        <a class="btn btn-danger btn-mini action-remove" href="#"><i class="icon-minus icon-white"></i></a>
    </div> 
```

In the template we define the form-field needed to filter. We always work in the same pattern. For every field you defined in the getDataFields method in your filter-class, you add a formfield to your template.
The name of this field needs to be preceded by the filter name and after the fieldname you put the index of the searchfield. This is {{ index }} when index is defined and __index__ otherwise.

```twig
    {{filter.field}}comparator{% if index is defined and index %}{{index}}{% else %}__index__{% endif %}
```

Apart from that you can do what you want in this template. 

## Contribute

If you made a cool filter you want to share, don't hesitate to fork the project and send us a pull request!
