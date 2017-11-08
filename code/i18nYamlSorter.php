<?php

use Symfony\Component\Yaml\Yaml;

class i18nYamlSorter {

    /**
     * Sorts the namespaces and entries of all i18n files (lang/ folder) of the given module.
     *
     * @param string $module Module folder name.
     */
    public static function for_module($module) {
        if (!$module) {
            DB::alteration_message('Please specify the "module" parameter.');

            return;
        }

        // Check if there is a lang folder for the module
        $langDir = "../$module/lang";
        if (!file_exists($langDir)) {
            DB::alteration_message('No lang folder for this module.');

            return;
        }

        // Get language files in folder
        $i18nFiles = array_filter(scandir($langDir), function ($file) {
            return strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'yml';
        });

        // Check if there are any i18n files
        if (count($i18nFiles) === 0) {
            DB::alteration_message('There are no i18n files the lang/ folder.');

            return;
        }

        // Iterate over i18n files
        foreach ($i18nFiles as $i18nFile) {
            $path = "$langDir/$i18nFile";
            $payload = Yaml::parse($path);
            $locale = pathinfo($i18nFile, PATHINFO_FILENAME);
            $namespaces = $payload[$locale];
            $sortedPayload = array();

            // Sort the actual entries in the namespaces
            foreach ($namespaces as $namespace => $entries) {
                ksort($entries, SORT_STRING | SORT_FLAG_CASE);
                $sortedPayload[$namespace] = $entries;
            }

            // Sort the namespaces
            ksort($sortedPayload);

            // Generate formatted YAML content
            $yaml = Yaml::dump(array(
                $locale => $sortedPayload
            ), 4, 2);

            // Write back to i18n file
            file_put_contents($path, $yaml);
            DB::alteration_message("Sorted and saved locale \"$locale\".");
        }
    }
}