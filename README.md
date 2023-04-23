# UniCrumbs plugin

Universal plugin for creating a list of breadcrumbs for October CMS.

## Plugin features

* Multi-language breadcrumbs (via [RainLab.Translate](https://octobercms.com/plugin/rainlab-translate)).
* Support for dynamic pages (CMS section).
* Support JSON-LD markup.
* Automatic receipt of the integration code.
* Additional GET requests for breadcrumbs.

# Documentation

All lists of breadcrumbs are formed in the UniCrumbs section of the site settings. To connect the list of breadcrumbs to the desired page, you need to add a component and a connection code (if necessary, set up adding dynamic data).

## Attention!

The code for connecting breadcrumbs directly depends on the parent elements.
Therefore, after changing the order of the elements, it can significantly change!

## Installation

Using the Laravel’s CLI is the fastest way to get started. Just run the following commands in a project’s root directory:

```
php artisan plugin:install Dubk0ff.UniCrumbs
```

Breadcrumbs are of three types:
* `Static` - crumb with a relative link.
* `Segment` - crumb with a link segment. The segment will be added to the link of the previous breadcrumb. If it is missing, a relative link will be created.
* `CMS` - crumb pointing to the CMS section page to get the link.

At least one template is required to display the list of breadcrumbs.

## Titles

For static headers:

```
My home page!
```

For dynamic headers:

```
My %s page!
```

The specified `%s` specifiers will be replaced when displaying breadcrumbs (the number of specifiers must match the number of parameters).
The data is indicated for a specific bread shop by its ID:

```
'titles' => [
    11 => [
        'home'
    ]
]
```

To completely replace the header, you can pass a string with the ID of the breadcrumb:

```
'titles' => [
    11 => 'Replace - My home page!'
]
```

## Links

The UniCrumbs plugin can automatically recognize dynamic pages in the CMS section and the necessary parameters for them.

Setting dynamic data to get a link is done in the `slugs` array by its ID:

```
'slugs' => [
    11 => [
        'post' => '$this->param('post_slug')'
    ]
]
```

## URL query parameters

You may need to add additional GET parameters for links in some cases:

```
// Additional GET parameters
'queries' => [
    11 => [
        'status' => 'new',
        'color' => 'red'
    ]
]
```

## Invisible

To hide one or more breadcrumbs, add the necessary IDs to the `invisible` array.

```
// IDs of crumbs to hide
'invisible' => [8, 13]
```

# Example

An example of connecting breadcrumbs to the village.

## Code

If there is no dynamic data, the connection code can be ignored.

```
function onEnd()
{
    /* UniCrumbs connection parameters */
    $this['unicrumbs_parameters'] = [
        // Dynamic titles parameters
        'titles' => [
            11 => [
                'home'
            ]
        ],
        // Dynamic slugs parameters
        'slugs' => [
            11 => [
                'post' => '$this->param('post_slug')'
            ]
        ],
        // URL query parameters
        'queries' => [
            11 => [
                'status' => 'new',
                'color' => 'red'
            ]
        ],
        // Hide IDs breadcrumbs
        'invisible' => [8, 13]
    ];
}
```

## Twig

```
[unicrumbs]
breadcrumbs = 11
template = 1
isJsonLd = 1
isCache = 1
cacheTime = 24
uuid = "01878a05-f536-70b5-9889-f02e9ec285bd"
```

Passing data to the config can be done in the `twig` template before displaying the breadcrumbs.

```
{{ unicrumbs.setParameters('titles', {11: blogPost.title}) }}

{% component "unicrumbs" %}
```

# Information

If you are interested in improving this plugin, please submit bug reports and feature requests on the plugin GitHub page.
