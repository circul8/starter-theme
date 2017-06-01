# Wordpress Starter Theme
[![Packagist](https://img.shields.io/packagist/v/circul8/wordpress-starter-theme.svg?style=flat-square)](https://packagist.org/packages/circul8/wordpress-starter-theme)

Starter theme based on [Timber's Starter Theme](https://github.com/timber/starter-theme). It is already part of [Circul8 Wordpress Stack](https://github.com/circul8/wordpress), can be also used with [Root's Bedrock](https://roots.io/bedrock/) or normal Wordpress installation.

## Installation

1. Using [Circul8 Wordpress Stack](https://github.com/circul8/wordpress)
	1. `composer create-project circul8/wordpress new-project`
1. Using Bedrock or normal Wordpress installation
	1. Navigate to `/web/app/themes/` or `/wp-content/themes/`
	1. Run `git clone git@github.com:circul8/wordpress-starter-theme.git`
	1. Run `composer install`

## Dependencies

- [Composer](https://getcomposer.org)
- [Timber](https://github.com/timber/timber) + [Twig](https://twig.sensiolabs.org/doc/2.x/)

## Templating system

Templating is done by [Timber plugin](https://github.com/timber/timber) which uses [Twig](https://twig.sensiolabs.org/doc/2.x/).

#### Custom filters

| Filter | Description |
|--------|-------------|
| `dump` | Dumps the variable to the Tracy's debug panel. |
| `cfs($post_id = NULL, $options = [])` | Returns `CFS()->get($field_name, $post_id, $options)` as descibred [here](http://customfieldsuite.com/api/get.html) where `$field_name` is filtered value. |
| `post` | Returns `new Timber\Post($id)` where `$id` is filtered value. |
| `image` | Returns `new Timber\Image($id)` where `$id` is filtered value. |
| `target` | Returns `_blank` or `_self`, expects *Hyperlink Array* from *CFS*. |
| `webalize` | Webalize string: "Hello, my friend!" -> "hello-my-friend" |

## Plugins

Those 👇 are Must-Use plugins installed into `mu-plugins` folder. If you install this theme from project's root using `composer require`, those plugins may be installed into `plugins` folder instead.

| Plugin | Description |
|-|-|
| `timber-library` | The core plugin to create custom theme. |
| `custom-field-suite` | To manage custom fields. |
| `wp-tracy` | Debugging, adds debug panel. |
| `disable-comments` | To disable comments. |
| `tinymce-advanced` | Advanced WYSIWYG. |

## Directory structure

```
├─ assets			← Static files - images, CSS, LESS, gulp, JS, ...
├─ defaults			← Timber's starter theme twig files for fallback.
├─ pages			← Custom Wordpress template pages (.php)
├─ templates			← Custom twig templates.
│   └─ partials			← Components & other partials such as HTML header, footer, GA, ...
├─ admin.CSS			← Custom CSS sheet for administration.
└─ functions.php		← Theme boostrap
```
