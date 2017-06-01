# Wordpress Starter Theme
[![Packagist](https://img.shields.io/packagist/v/circul8/wordpress-starter-theme.svg?style=flat-square)](https://packagist.org/packages/circul8/wordpress-starter-theme)

## Installation

1. `git clone git@bitbucket.org:circul8_communicate/wcc-website.git .`
1. `composer install`
1. Go to `/web/app/themes/wcc-theme/` and `composer install` again.

## Technologies

- [Composer](https://getcomposer.org)
- [Timber](https://github.com/timber/timber) + [Twig](https://twig.sensiolabs.org/doc/2.x/)

## Templating system

Templating is done by [Timber plugin](https://github.com/timber/timber) which uses [Twig](https://twig.sensiolabs.org/doc/2.x/) as a templating system.

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

| Plugin | Description |
|-|-|
| `timber-library` | The core plugin to create custom theme. |
| `custom-field-suite` | To manage custom fields. |
| `wp-tracy` | Debugging, adds debug panel. |
| `disable-comments` | To disable comments. |
| `tinymce-advanced` | Advanced WYSIWYG. |
