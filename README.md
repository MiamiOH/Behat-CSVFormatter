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

    ...
```

## Configuration
* `filename` - filename
* `outputDir` - dir to be created filename

(Optional Parameters)
* `columnList` - Used as the header column of CSV output if write Method is Overwrite, can also be used to limit the columns that will be displayed in the output.
    (Default: Suite,Name,Tags,StartTime,EndTime,Duration,Status,StepName,ErrorMessage)
* `writeMethod` - Append or Overwrite possible write methods (Default: Append )
* `delimiter` - delimiter used to separate the fields of Output (Default: , )
* `enclosure` - character used to denote the beginning and ending of the field (Default: ' )
