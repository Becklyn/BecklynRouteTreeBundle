BecklynRouteTreeBundle
======================

Adds a simple implementation for an automatic generation of a route tree to build a menu.



Installation
------------

Install the bundle via [packagist](https://packagist.org/packages/becklyn/route-tree-bundle):

```javascript
    // ...
    require: {
        // ...
        "becklyn/route-tree-bundle": "^2.0"
    },
    // ...
```

Load the bundle in your `app/AppKernel.php`:

```php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new \Becklyn\RouteTreeBundle\BecklynRouteTreeBundle(),
        );
        // ...
    }
```



Defining The Route Tree Nodes
-----------------------------
You add elements to the tree by setting the options of the routes:

```yaml
homepage:
    path: /

my_route:
    path: /my_route
    options:
        tree:
            parent: homepage
            title:  "My Route"
```



Path Options
------------

```yaml
route:
    # ...
    options:
        tree:
            parent:     homepage       # the name of the parent node
            priority:   0              # (optional) the 
            title:      "abc"          # (optional) title of the node
            parameters: {}             # (optional) the default values for the parameters
            security:   ~              # (optional) the security expression
```

`parent` must be set. Also all referenced `parent`-routes need to exist.


### Priority
All child nodes of all nodes are sorted by descending priority.


### Hidden
All items are automatically hidden, if they have no title set (or if the security expression evaluates to false).


### Parameters
The parameters can define default values for parameters:

```yml
page_listing:
    path: /listing/{page}
    options:
        tree:
            parameters:
                page: 1
```

**If you do not define a value, the parameter is looked up in the request attributes of the current request. If it doesn't find anything there, `1` is used.**


### Security
Every node can have a custom security expression, that is evaluated when printing the tree.
All nodes where the security expression evaluates to `false` are automatically hidden (including all their child nodes).

If no explicit security expression is given, the builder tries to infer the expression from the linked controller by combining `@IsGranted()`
and `@Security()` annotations from the action method and the controller class.
If `@IsGranted()` is used with the `subject` attribute, nothing is infered.


### Extra Parameters
You can define additional parameters, that can be used in the menu template.
All path options that are not recognized (see "Path Options") are automatically added as extra parameters.

```yaml
route:
    options:
        tree:
            parent: homepage
            title: Pages
            icon: pages
```

These extra parameters are available in the template under the `extra` property:

```twig
{{ item.extra("icon") }}
```


### Error Cases
If the page tree is invalid a `InvalidRouteTreeException` is thrown, on the first construction of the page tree.



Short Syntax
------------

In simple cases, the config can be simplified to:


```yaml
route:   
    options:
        tree: "parent"
        
# ... means the same as ...

route:   
    options:
        tree: 
            parent: "parent"
```



Rendering the Route Tree
------------------------

There is an automatic menu builder, that you can just use in the templates:

```twig
{{- route_tree_render("my_route", {...}) -}}
```

The first parameter is the parent node of which the menu should be used. The second (optional) argument are the [KnpMenu render options].


Getting The Route Tree
----------------------
You can inject the service `Becklyn\RouteTreeBundle\Tree\RouteTree` and use it to retrieve a node:

```php
    // get a node with a specific route. With this node you can traverse the route tree.
    $treeUnderMyRoute = $routeTree->getNode("my_route");
```

The return value is a `Becklyn\RouteTreeBundle\Node\Node`.


[KnpMenu render options]: https://github.com/KnpLabs/KnpMenu/blob/master/doc/01-Basic-Menus.markdown#other-rendering-options
