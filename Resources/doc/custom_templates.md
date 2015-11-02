Custom templates
================

The templates to render a list can be overwritten. 
You can find some example templates in `Resources/views/ListTemplates`.

When overwriting a template you need to loop over the list of your objects. This list is called `pagination`.

```twig
<div class="panel panel-default">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                {% for column in builder.configuration.columns %}
                    {% if column.isSortable() %}
                        <th{% if pagination.isSorted(column.sortField) %} class="sorted"{% endif %}>{{ knp_pagination_sortable(pagination, column.columnHeader, column.sortField) }}</th>
                    {% else %}
                        <th>{{ column.columnHeader }}</th>
                    {% endif %}
                {% endfor %}
                {% if builder.configuration.actions|length > 0 %}
                    <th>&nbsp;</th>
                {% endif %}
            </tr>
        </thead>

        <tbody>
            {% for item in pagination %}
                <tr>
                    {% for column in builder.configuration.columns %}
                        <td {% if column.isBoolean() %}class="center"{% endif %}>
                            {% if column.route is defined and column.route %}
                                <a href="{{ path(column.route, helper.getRouteParams(item, column.routeParams)) }}">
                            {% endif %}

                            {% if column.isBoolean() %}
                                {% if column.booleanValue[helper.renderValue(item, column.name, column.emptyValue, column.parentField)] is defined %}
                                    {{ column.prefix }}{{ column.booleanValue[helper.renderValue(item, column.name, column.emptyValue, column.parentField)] }}{{ column.suffix }}
                                {% else %}
                                    {{ column.prefix }}{{ column.booleanValue[false] }}{{ column.suffix }}
                                {% endif %}
                            {% else %}
                                {{ column.prefix }}{{ helper.renderValue(item, column.name, column.emptyValue, column.parentField) }}{{ column.suffix }}
                            {% endif %}

                            {% if column.route is defined and column.route %}
                                </a>
                            {% endif %}
                        </td>
                    {% endfor %}
                    {% if builder.configuration.actions|length > 0 %}
                    <td>
                        {% for action in builder.configuration.actions %}
                            {% set routeParams = helper.getRouteParams(item, action.routeParams) %}
                            {% if action.modal %}
                                <div class="modal fade" id="actionmodal{{ item.id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">{{ 'Are you sure?' | trans({}, 'admin') }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ 'Are you sure you want to do this?' | trans({}, 'admin') }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <a href="{{ path(action.route, routeParams) }}" class="btn btn-danger">{{ 'Yes' | trans({}, 'admin') }}</a>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            {% endif %}
                            <a class="btn btn-default btn-xs {% if action.btnColour is defined and action.btnColour %}btn-{{ action.btnColour }}{% endif %}" {% if action.modal %}href="#actionmodal{{item.id}}" data-toggle="modal"{% else %}href="{{ path(action.route, routeParams) }}"{% endif %} title="{{ action.name | trans({}, 'admin') }}">
                                {% if action.icon is defined and action.icon %}
                                    <i class="{{ action.icon }}"></i>
                                {% else %}
                                    {{ action.name }}
                                {% endif %}
                            </a>
                        {% endfor %}
                    </td>
                    {% endif %}
                </tr>
            {% else %}
                <tr>
                    <td colspan="{% if builder.configuration.actions|length > 0 %}{{ (builder.configuration.columns|length) + 1 }}{% else %}{{ builder.configuration.columns|length }}{% endif %}">No data yet.</td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
```

The above is the default template. Your columns are in ```builder.configuration.columns```.
In every column you can request the columnHeader, and whether or not the column needs to be sorted (by using ```column.isSortable```). Sorting is done using the KnpPaginatorBundle, so you can look there for more information on how to make a column sortable.
Field to be sorted on can be fetched with `column.sortField`.

For every item in pagination you can render a value for every column.

```twig
    {{ builder.renderValue(item, column) }}
```

You can also render actions for every item. You do this by looping ```builder.configuration.actions```.
The path that the action needs to execute can be rendered by the following

```twig
    {{ path(action.route, builder.getRouteParams(item, action)) }}
``` 
