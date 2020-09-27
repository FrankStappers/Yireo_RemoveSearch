# Yireo_RemoveSearch
A module that removes both MySQL and ElasticSearch from Magento. This is experimental and might not be perfect. Note that this module is supposed to *hack* things in your Magento site. If you are experiencing problems, feel free to open up an **Issue** on GitHub. But please take note that this module is something built for experienced developers, it takes a developers mind to properly troubleshoot things.

## Installation via composer
Installation of this module by copying things to `app/code` will **not** work: The composer `replace` will not be applied and the original namespaces `Magento\Search` and `Magento\CatalogSearch` will not be remapped to this extension. It does not work. Use composer instead.


Instead, first add the git repository to your composer project:

    composer config repositories.yireo-removesearch vcs git@github.com:yireo/Yireo_RemoveSearch.git 

Second, open up the `composer.json` file and add the following manually to your configuration:
        
    "replace": {
        "magento/module-advanced-search": "*",
        "magento/module-catalog-search": "*",
        "magento/module-elasticsearch": "*",
        "magento/module-elasticsearch-6": "*",
        "magento/module-elasticsearch-7": "*",
        "magento/module-inventory-catalog-search": "*",
        "magento/module-inventory-elasticsearch": "*",
        "magento/module-search": "*",
        "elasticsearch/elasticsearch": "*",
        "magento/module-elasticsearch-catalog-permissions": "*"
    }

Third, to uninstall the search related modules run:

    composer install
 
Finally, to register and install this module in your `composer.json` file, run:

    composer require yireo/magento2-remove-search:dev-master

Unfortunately, this might work or it might not. If this fails, do the following (and beware of its consequences):

    rm -r vendor/ composer.lock
    composer install
    
Please note that a simple `composer require yireo/magento2-remove-search` will not work. Please also note that removing the `vendor/` and `composer.lock` might not be best practices, but this is the only known workaround to get the composer `replace` trick working. If you don't like it, because it does not comply to standard procedures, don't use this solution.

After this, make sure to enable the module:

    bin/magento module:enable Yireo_RemoveSearch
    rm -r generated/
    bin/magento cache:flush

Make sure your cache is properly wiped. Or wipe your Magento cache folder (`rm -r var/cache`). Or wipe Redis (`redis-cli flushall`). Or something.
    
## Testing if it works
To test if things are working, make sure to play around with the following commands - they should just happen with PHP Fatal Errors:
     
    bin/magento setup:upgrade
    bin/magento setup:di:compile

Additionally:

- `composer show | grep -i search` should output some packages, but no longer the Magento 2 modules for search
