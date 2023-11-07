# Modular Theme Setup
### Please read before installing/activating or you will probably have a subpar experience  
This theme works out-of-the-box with no build steps required.  
It is for developers, not end users - This is a dev setup for creating new themes or websites but is not a full theme itself.  

### What's included?
This theme is primarily built on Timber and ACF. If you do not want to use ACF, there are fallbacks in the theme or you can remove the function calls entirely (recommended) along with `acf-json` folder. There are also a lot of niceties and paths pre-setup. It is recommended to use [PrePros (free)](https://prepros.io/) as the preprocessor for SCSS and JS files and a config with paths/maps is already included. You can also use your own tools but you will need to set those up.  

The ACF functions included allow for blocks to be built quickly AND utilizes Timber for blocks too! Blocks are added to `custom-block-functions.php` and are rendered with Timber in the `templates/blocks/acf/` directory.  

Do not install the Timber plugin. Support is ending in favor of the composer build, which is the only way to get Version 2.  
Timber V2 is already installed which supports PHP 8.2.  

### To Install (V2)
Run: `php composer.phar install` - There is a `composer.lock` file present to make installing easy.  
After running the composer install command you can safely add the theme to WordPress and activate it.  

### Updating Composer -- Timber V2 is slated for a mid-november 2023 release.
[Timber Roadmap for V2 (Github)](https://github.com/Timber/Timber/issues/2741)  
Until Timber V2 is moved into a full release, do not run the update command in composer as this will install Timber V1 and the theme + wp admin WILL break.  
Once the full version 2 release has been pushed you can run the update command safely.  

# Can I use Timber V 1.23?
Absolutely. All code written is backwards compatible BUT uses the new standards* implemented by the Timber team.  
* *E.G. uses `{{ post.meta() }}` instead of `{{ post.get_field() }}` for ACF.  

### Using Composer (V1)
Make sure you are on PHP 7.4 (V1 does not work with PHP 8+)
- Delete `composer.json` and `composer.lock`  
- Run: `composer require timber/timber:^1.0` which will regenerate the above files for Timber V1  

### Using the plugin (V1)
While I highly recommend (as does Timber) sticking with composer for V1, you can use the plugin - keep in mind plugin support IS ending once V2 is released. V1 will still be maintained via composer only.  
Delete `composer.json` and `composer.lock`  
Open `functions.php` and
- remove lines 3-7 (keep line 10 as this tells Timber where to load twig files from)  
- On line 12 `Timber\Site` needs to be `TimberSite`. The full line will be (minus braces) `class MODSite extends TimberSite`
