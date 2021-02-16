# Sitegeist.ScentMark

Mark and Sniff on Neos via CLI. This can help to optimize cache flushing in Cluster Environments with a green / blue cache setup
where only a single cache-flush should be run for the first container spinning up for a newly deployed version. 

This is useful when multiple containers share the same cache and switch via green / blue deployment between cache hosts or databases.  

## Usage
 
start.sh:   
```bash
./flow scentmark:sniff $APP_VERSION
RESULT=$?
if [ $RESULT -ne 0 ]; then
    ./flow flow:cache:flush
    ./flow scentmark:mark $APP_VERSION
fi
```

Prerequisites:
- Green / Blue shared caching environment is configured for the cluster 
- Sitegeist_ScentMark_ScentCache is configured for the shared caches
- The current APP_VERSION is exported as Environment Variable 

### Authors & Sponsors

* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

## Installation

Sitegeist.ScentMark is available via packagist. Run `composer require sitegeist/scentmark` to require this package.

We use semantic-versioning so every breaking change will increase the major-version number.

## Contribution

We will gladly accept contributions. Please send us pull requests.
