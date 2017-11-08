# i18n YAML Sorting
i18n YAML files can get quite huge in big projects. Sometimes it's hard to have a proper overview if the content is created in an adhoc manner.

Let this handy utility sort the namespaces and entries of those files to avoid duplicate entries and improve orientation.

## Install
`composer require jzubero/silverstripe-i18n-sorter`

## Usage
* As task: `i18nYamlSortTask?module=your-module`
* Static method: `i18nYamlSorter::for_module('your-module')`

## Maintainer
- JZubero <js@lvl51.de>