Custom templates
================

The templates to render a list can be overwritten. 
You can find some example templates in 'Resources/views/ListTemplates'.

When overwriting a template you need to loop over the list of your objects. This list is called 'pagination'.

```twig
<table class="table table-striped">
    <thead>
        <tr>
            <th>&nbsp;</th>
            {% for column in builder.configuration.columns %}
                {% if column.isSortable() %}
                    <th{% if pagination.isSorted('i.'~column.sortField) %} class="sorted"{% endif %}>{{ knp_pagination_sortable(pagination, column.columnHeader, 'i.'~column.sortField) }}</th>
                {% else %}
                    <th>{{ column.columnHeader }}</th>
                {% endif %}
            {% endfor %}
            <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        {% for item in pagination %}
            <tr>
                <td>{{ item.id }}</td>
                {% for column in builder.configuration.columns %}
                    <td>
                       {{ builder.renderValue(item, column) }}
                    </td>
                {% endfor %}
                <td>
                    {% for action in builder.configuration.actions %}
                        {% set routeParams = builder.getRouteParams(item, action) %}
                        {% if action.modal %}
                            <div id="actionmodal{{ item.id }}" class="modal hide fade">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h3>{{ 'Are you sure?' | trans({}, 'admin') }}</h3>
                                </div>
                                <div class="modal-body">
                                  <p>{{ 'Are you sure you want to do this?' | trans({}, 'admin') }}</p>
                                </div>
                                <div class="modal-footer">
                                  <a href="#" data-dismiss="modal" class="btn">{{ 'No' | trans({}, 'admin') }}</a>
                                  <a href="{{ path(action.route, routeParams) }}" class="btn btn-danger">{{ 'Yes' | trans({}, 'admin') }}</a>
                                </div>
                            </div>
                        {% endif %}
                        <a class="btn btn-small {% if action.btnColour is defined and action.btnColour %}btn-{{ action.btnColour }}{% endif %}" {% if action.modal %}href="#actionmodal{{item.id}}" data-toggle="modal"{% else %}href="{{ path(action.route, routeParams) }}"{% endif %} title="{{ action.name | trans({}, 'admin') }}">
                            {% if action.icon is defined and action.icon %}
                                <i class="{{ action.icon }} {% if action.iconWhite is defined and action.iconWhite %}icon-white{% endif %}"></i>
                            {% else %}
                                {{ action.name }}
                            {% endif %}
                        </a> 
                    {% endfor %}
                </td>
            </tr>
        {% endfor %}
    </tbody>
</table>
```

The above is the default template. Your columns are in builder.configuration.columns.
In every column you can ask for the columnHeader, and if the column needs to be sorted with sortField. Sorting is done with the KnpPaginatorBundle, so you can look there for more information on how to make a column sortable.

For every item in pagination you can render a value for every column.

```twig
    {{ builder.renderValue(item, column) }}
```

You can also render actions for every item. You do this by looping builder.configuration.actions.
The path that the action needs to execute can be rendered by the following

```twig
    {{ path(action.route, builder.getRouteParams(item, action)) }}
```  