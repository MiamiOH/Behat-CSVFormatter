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

```text
# behat.yml
default:
    suites:
    ...

    extensions:
        miamioh\behat-CSVFormatter:
            filename: report.csv
            outputDir: %paths.base%/build/tests
            writeMethod: Append
            columnList: scenario.name,scenario.tags,scenarioRun.startTime,scenarioRun.endTime,scenarioRun.duration,scenarioRun.status,scenarioRun.StepName,scenarioRun.errorMessage
            
    ...
```

## Configuration
* `filename` - filename
* `outputDir` - dir to be created filename
* `writeMethod` - Append or Overwrite possible write methods
* `columnList` - Currently used as the header column of CSV output
(Optional Parameters) 
* `delimiter` - delimiter used to separate the fields of Output (Default: , )
* `enclosure` - character used to denote the beginning and ending of the field (Default: ' ) 
