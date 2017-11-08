<?php

class i18nYamlSortTask extends BuildTask {

    protected $title = 'i18n YAML-file sort task';

    protected $description = 'Sorts the namespaces and entries of all i18n files (lang/ folder) of the given module.';

    public function run($request) {
        i18nYamlSorter::for_module($request->getVar('module'));
    }
}