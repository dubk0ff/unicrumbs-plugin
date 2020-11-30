# UniCrumbs plugin

Universal plugin for creating a list of breadcrumbs for October CMS.

## Benefits

* Multi-language crumbs (via [RainLab.Translate](https://octobercms.com/plugin/rainlab-translate)).
* Multi-language links (via [RainLab.Translate](https://octobercms.com/plugin/rainlab-translate)).
* Support for static pages (via [RainLab.StaticPages](https://octobercms.com/plugin/rainlab-pages)).
* Support for dynamic pages (CMS section).
* Support JsonLd markup.
* Automatic receipt of the integration code.
* Additional GET requests for crumbs.
* Full title replacement or partial substitutions.

# Documentation

All lists of crumbs are formed in the UniCrumbs section of the site settings. To connect the list of crumbs to the desired page, you need to add the component and the code for connecting the crumbs to the `Code` section (if necessary, configure the addition of dynamic data).

## Attention!

The code for connecting breadcrumbs directly depends on the parent elements.
Therefore, after changing the order of the elements, it can significantly change!

## Installation

Using the Laravel’s CLI is the fastest way to get started. Just run the following commands in a project’s root directory:

```
php artisan plugin:install Dubk0ff.UniCrumbs
```

Adding crumbs is done 1 time automatically (if there are no crumbs), or manually through the add form.

There are three types of crumbs:
* `Статические` - crumbs with a static title and a relative link.
* `Статические +` - crumbs with a static title and link segment. The segment will be added to the link of the previous crumb; if it is absent, a relative link will be created.
* `CMS` - crumbs for which the page from the CMS section is set (to get the crumb title and link).

At least one template is required to render the list of crumbs.

> To use multi-language, you need to install the plugin [RainLab.Translate](https://octobercms.com/plugin/rainlab-translate)

## Titles

In the CMS page section, it is recommended to fill in the `Сrumb title` field before importing pages.

> This action is optional, since the crumb title can be filled (overridden) dynamically in the `Code` section

For static pages:

```
My most optimized crumb title!
```

For dynamic pages:

```
My %s dynamic crumb title - %s
```

The specified `%s` specifiers will not be replaced when rendering the crumb (the number of specifiers must match the number of parameters). The replacement is indicated for a specific crumb in the `titles` data array by its ID:

```
'titles' => [
    30 => [
        'param_title',
        'param_title'
    ]
]
```

Any crumb title can be replaced in the `Code` section:

```
'titles' => [
    31 => 'My NEW crumb title!'
]
```

## Links

UniCrumbs plugin can automatically recognize dynamic pages in the CMS section and the necessary parameters for them.

Therefore, to get a link, you must specify them in the data array `slugs` by its ID:

```
'slugs' => [
    30 => [
        'post' => 'your_url_slug',
        // Additional GET parameters
        'queries' => []
    ]
]
```

For each crumb there is a `queries` parameter in which you can specify additional GET parameters:

```
// Additional GET parameters
'queries' => [
    'date' => '25012020',
    'status' => 'new',
    'category' => 'top-news'
]
```

## Invisible

Perhaps in some cases you will need to hide one or several crumbs from the list. To do this, you need to add the ID of these crumbs to the `invisible` array:

```
// IDs of crumbs to hide
'invisible' => [30, 32]
```

## Example

`Crumb ID` - this is the final crumb from which the list of child crumb will be obtained.

```
function onEnd()
{
    /* Array of UniCrumbs parameters */
    $this['unicrumbs_parameters'] = [
        // Crumb ID
        'id' => 31,
        // Dynamic titles and parameters of cms pages
        'titles' => [
            30 => [
                'param_title',
                'param_title',
            ],
            31 => 'My NEW crumb title!'
        ],
        // Dynamic slugs and GET queries of cms pages
        'slugs' => [
            30 => [
                'post' => 'your_url_slug',
                // Additional GET parameters
                'queries' => [
                    'date' => '25012020',
                    'status' => 'new',
                    'category' => 'top-news'
                ]
            ],
        ],
        // IDs of crumbs to hide
        'invisible' => [29, 32]
    ];
}
```

For all the crumbs involved in the example (29, 30, 31, 32), you can apply the settings above.

## Information

If you are interested in improving this plugin, please submit bug reports and feature requests on the plugin GitHub page.