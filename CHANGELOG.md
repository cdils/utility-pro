# Change Log for Utility Pro Child Theme

All notable changes to this project will be documented in this file.

## 2.0.0 - 2017-??-??
- Make PHP 7.0 the minimum supported version.
- Declare strict types, and use scalar and return type hints.
- Use config-driven approach - see `config/defaults.php`.
- Rewrite customizations logic as object-orientated code.
- Add unit tests for all the customizations.
- Update TGMPA to 2.6.1.
- Pull in TGMPA via Composer.
- Change how scripts are named and organized.
- Use Gulp WP Tookit as the build system base.
- Add Contributor Covenant Code of Conduct.
- Update `.pot` file for translations.

## 1.3.1 - 2016-04-11
- Fix incorrect script handle on backstretch arguments.

## 1.3.0 - 2016-04-6
- Add skip link footer navigation.
- Remove theme support for Genesis Drop Down Menus (conflict with Superfish).
- Improve mobile menu experience for non-visual users.
- Update backstretch script to include an alt attribute for the background image.
- Add support for retina logos.
- Update .pot file for translations.
- Reorganize Grunt tasks to group related tasks.

## 1.2.0 - 2016-02-06
- Add h1 markup to site title on a static front page.
- Add Composer support, specifically for including TGMPA.
- Add support for PHP_CodeSniffer.
- Add theme support for Genesis Accessibility (404 page, Drop Down Menus, Headings, Skip Links).
- Switch from CSSJanus to RTLCSS for style-rtl.css generation.
- Fix incorrect variable name resulting from update to TGMPA 2.5.2.
- Fix issue with homepage background image sometimes scrolling beyond footer.
- Fix issue with content following column classes not float clearing.
- Adjust search form width in the header right widget area.
- Remove sample content (utility-pro.xml) from theme and relocated to user account area.
- Remove copyright reference from footer creds.

## 1.1.1 - 2015-12-11
- Update TGMPA to 2.5.2.
- Remove a forced full-width layout for the front page.

## 1.1.0 - 2015-07-03
- Add Sass, Bourbon, and Neat.
- Change minimum WordPress version compatibility to 4.1 (to accommodate `the_posts_pagination()` ).
- Add Bulgarian translation.
- Update TGMPA to 2.5.0-RC.
- Fix the majority of WordPress Code Standards errors and warnings.
- Change CSS selector in menu to work with the WP Accessibility plugin toolbar.
- Add Grunt Clean.

## 1.0.1 - 2015-02-05

- Fix text domain loading for language files.
- Fix backstretch image overflow for RTL.
- Change search form for improved accessibility.
- Add British English translation.
- Add German translation.

## 1.0.0 - 2015-01-16

- Initial release
