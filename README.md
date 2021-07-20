# Kirby3 Fragments

Kirby3 Fragments is a small string/translation helper. You can use fragments in your code 'laravel/blade' style and optionally translate them on site or page level. Additionaly you can pass placeholders to the fragment.

A perfect solution for translation of static labels etc... But can also be used to make other 'static' content manageable via the CMS.

## Syntax

`__(string $fragment, array $placeholders = [])`

* $fragment : Can be any string or label, you can either choose to use 'Firstname' or rather work with 'label.firstname'. Whichever you prefer.

* $placeholders : Kirby style placeholders (See [Str::template()](https://getkirby.com/docs/reference/objects/toolkit/str/template) for more information)

### Usage

* Add Fragment blueprint to site and/or page to blueprint

```yaml
tabs:
  fragments: tabs/fragments
```

* Use k3-fragments string helper in code

```php
<h1><?= $page->title(); ?></h1>

<p><?= __('Welcome to my site'); ?></p>
<p><?= __('label.name'); ?></p>
<p><?= __('Copyright {{year}}', ['year' => date('Y')]); ?></p>
```

* Translate or change content via panel

* If both Site and Page translations exist k3-fragments will give priority to the page translation (this way you can overwrite site fragments on a page level) Although it's not required that fragments exist on both levels.

![](https://static.gnx.cloud/genx/kirby/k3-fragments.jpg)

## Plugin installation

### Download

Download and copy this repository to `/site/plugins/k3-fragments`.

### Git submodule

```
git submodule add https://github.com/genxbe/k3-fragments.git site/plugins/k3-fragments
```

### Composer

```
composer require genxbe/k3-fragments
```

## License

MIT

## Credits

- [Sam Serrien](https://twitter.com/samzzi) @ [GeNx](https://genx.be)
