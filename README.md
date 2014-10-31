# Lone Star PHP 2015

Welcome to the Lone Star PHP 2015 website, based on [Sculpin](http://sculpin.io/)! Definitely check up on the Sculpin
documentation to learn more about working with Sculpin

## Getting Started

To edit/parse the CSS

1. Run `gem install sass`
2. Run `npm install`
3. Run `gulp`
4. Now when you save any SCSS file, it will automatically parse and minify it to CSS

To get started developing on the website:

1. Run `composer install`
2. Run `vendor/bin/sculpin generate --watch --server`
3. Open [http://localhost:8000/](http://localhost:8000/) in your browser, et voila!

For deployments you will need the capistrano gem installed

1. Run `gem install capistrano`
2. To deploy to production `cap production deploy`

Optionally you can:

1. Run `pip install fabric`
2. Run `composer install`
3. Run `fab develop`
4. Open [http://localhost:8000/](http://localhost:8000/) in your browser, et voila!

## License

This project is licensed under the MIT license. However, we respectfully ask a few things if you use our site as a base:

1. Let us know what project you're using it for *(We're curious is all)*
2. Do not re-use our stylesheets *(This one should be obvious)*