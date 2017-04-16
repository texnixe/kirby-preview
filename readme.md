## Kirby Preview field

Let's you choose a page from a select field and shows a preview of it in an iframe below the field. It is possible to define a template extension for dedicated preview options, e.g. if you want to show the raw contents of the page instead of a heavily formatted page.

**I'm creating this for my personal use in a project and it is still under development. Feel free to use it at your own risk.**


## Installation

### Download

[Download the files](https://github.com/texnixe/kirby-preview/archive/master.zip) and place them inside `site/plugins/preview`.

### Kirby CLI
Installing via Kirby's [command line interface](https://github.com/getkirby/cli):

    $ kirby plugin:install texnixe/kirby-preview

To update Preview, run:

    $ kirby plugin:update texnixe/kirby-preview

### Git Submodule
You can add the Preview plugin as a Git submodule.

    $ cd your/project/root
    $ git submodule add https://github.com/texnixe/kirby-preview.git site/plugins/preview
    $ git submodule update --init --recursive
    $ git commit -am "Add Preview plugin"

Run these commands to update the plugin:

    $ cd your/project/root
    $ git submodule foreach git checkout master
    $ git submodule foreach git pull
    $ git commit -am "Update submodules"
    $ git submodule update --init --recursive

## Usage

In your blueprint:

```
previewPage:
  label: Select a page
  type: preview
  options: query
  query:
    page: blog
    fetch: children
    value: '{{uri}}'
```

Make sure to set the value to `uri` and to only fetch pages, not files.

## Options

### preview.template.extension

You can define a template extension for dedicated preview templates, for example, if you want to remove the navigation or other unneeded stuff from the template. If a file with the given extension does not exist, the plugin falls back to the template without the extension.
```
c::set('preview.template.extension', 'raw');
```



## Credits:

@jenstornell: preview class of the [Kirby Reveal plugin](https://github.com/jenstornell/kirby-reveal)

## License

Kirby review is open-sourced software licensed under the MIT license.

Copyright © 2017 Sonja Broda info@texniq.de https://www.texniq.de
