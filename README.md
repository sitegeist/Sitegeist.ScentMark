# Sitegeist.ScentMark

Mark and Bark on Neos via CLI. This can help to orchestrate tasks in Cluster Environments where certain tasks like cache flushing or publishing of static resources shall only be
executed on the first container of a newly deployed app version or on only one of many containers.

NOTE: This goes well together with the sitegeist/treasuremap package that implements green/blue caching but can be used for other purposes as well.

## Usage

The package contains three cli commands:

### `./flow  scentmark:mark`

```
Mark the current deployment with the pack scent.

COMMAND:
  sitegeist.scentmark:scentmark:mark

USAGE:
  ./flow scentmark:mark <pack scent>

ARGUMENTS:
  --pack-scent         

DESCRIPTION:
  Returns status code 0 if the pack was new and successfully marked
  Returns status code 1 if the pack was already known beforehand
```

### `./flow  scentmark:bark`

```
Select pack leader by passing packScent and leaderScent. If no leader is currently elected the first one asking

COMMAND:
  sitegeist.scentmark:scentmark:bark

USAGE:
  ./flow scentmark:bark <pack scent> <leader scent>

ARGUMENTS:
  --pack-scent         
  --leader-scent       

DESCRIPTION:
  for the role is granted leader status for one hour
  
  Returns status code 0 if the $packScent and $leaderScent match and the current pod is considered leader for a time
  Returns status code 1 if the current pod is not the leader for now

```

### `./flow  scentmark:cleanup`

```
Remove the oldest packs but keep a specified number of items

COMMAND:
  sitegeist.scentmark:scentmark:cleanup

USAGE:
  ./flow scentmark:cleanup <keep>

ARGUMENTS:
  --keep        
```

## Examples

### Run jobs on the first container of a new release

start.sh:

```bash

// check wether a release (pack) with the given scent is already known
./flow scentmark:mark $APP_VERSION

// tasks to run on the first pod/container of a release (pack)
if [ $? -eq 0 ]; then
    // flush caches ... ensure they are configured with green / blue backends
fi
```
### Run jobs on only one container (pack leader) of a release

cron.sh:

```bash

// check wether the current pod is pack leader or can be promoted to lead status
./flow scentmark:bark $APP_VERSION $POD_ID

// tasks to run on eacatly one container only
if [ $? -eq 0 ]; then
    // flush caches ... ensure they are configured with green / blue backends
fi
```

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
