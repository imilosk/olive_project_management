# Olive project management
## Libraries used
* Routes library: [Flight php](http://flightphp.com/learn/)
* Template Engine: [Blade standalone](https://github.com/jenssegers/blade), [Documentation](https://laravel.com/docs/5.7/blade)
* Auth: [PHP-Auth](https://github.com/delight-im/PHP-Auth#creating-a-new-instance)

## Folder structure
* cache - compiled files created by Blade template engine
* controllers - app logic
* models - database models and queries
* public - index.php file with a few requires and .htaccess file for Apache2 web server
* routes - web.php for pages routing and api.php for REST api
* settings - settings, database connectors, component initializations
* vendor - composer dependencies
* views - Blade template engine templates for dynamic frontend
