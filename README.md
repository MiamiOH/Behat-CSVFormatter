## Installation

### Prerequisites

This extension requires:

* PHP 7.0 or higher
* Behat 3.x or higher

#### Install with composer:

```bash
$ composer require miamioh/behat-CSVFormatter
```

## Basic usage

Activate the extension by specifying its class in your `behat.yml`:

```json
# behat.yml
default:
    suites:
    ...

    extensions:
        miamioh\behat-CSVFormatter:
            filename: report.csv
            outputDir: %paths.base%/build/tests
            delimiter: ,
            enclosure: '
            writeMethod: Append
            
    ...
```

## Configuration
* `filename` - filename
* `outputDir` - dir to be created filename
