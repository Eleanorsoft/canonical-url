# Canonical URL module for Magento 2
A Module for Magento 2 that adds canonical URL with different host to every page.

To keep it short: the module rewrites URL of each page to point to a different host.

## Installation
```
composer config repositories.eleanorsoft-magento2-canonical-url git "https://github.com/Eleanorsoft/magento2-canonical-url.git"
composer require eleanorsoft/magento2-canonical-url
php bin/magento s:up
php bin/magento c:f
```

## Configuration
Go to `Store > Configuration > Eleanorsoft > Canonical URL` and set base URL which will be used for canonical URL generation.