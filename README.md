# Sitegeist.ScentMark

Mark and Sniff on Neos via CLI. This can help to optimize cache flushing in Cluster Environments with a green / blue 
caching or publishing setup where certain tasks like cache flushing or publishing of static resources shall only be
excuted on the first container of a newly deployed app version. 

## Usage

The package contains two cli commands:

- `./flow scentmark:mark __mark__` Store the given scent

- `./flow scentmark:sniff __mark__` Compare the cached scent with the stored value and return an error code if both do not match.

- `./flow scentmark:cleanup --keep 10` Remove old scents but keep the specified number of newest scents.

### Example  

1. Adjust the container spinup script

start.sh:   
```bash
./flow scentmark:sniff $APP_VERSION

// tasks to run on the first pod/container of a release
if [ $? -ne 0 ]; then
    // mark the cluster with the new release 
    ./flow scentmark:mark $APP_VERSION

    // flush caches ... ensure they are configured with green / blue backends
    ./flow flow:cache:flushone Neos_Fusion_Content
    ./flow flow:cache:flushone Flow_Mvc_Routing_Route
    ./flow flow:cache:flushone Flow_Mvc_Routing_Resolve
    ./flow flow:cache:flushone Flowpack_FullPageCache_Entries
fi
```

2. Configure flow to switch with every cache between Green / Blue caching environment
3. Ensure the current APP_VERSION is available in the containers

### Authors & Sponsors

* Martin Ficzel - ficzel@sitegeist.de
* Melanie Wüst - wuest@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

## Installation

Sitegeist.ScentMark is available via packagist. Run `composer require sitegeist/scentmark` to require this package.

We use semantic-versioning so every breaking change will increase the major-version number.

## Contribution

We will gladly accept contributions. Please send us pull requests.
