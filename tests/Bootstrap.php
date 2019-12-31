<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

/*
 * Set error reporting to the level to which Laminas code must comply.
 */
error_reporting( E_ALL | E_STRICT );

$phpUnitVersion = PHPUnit_Runner_Version::id();
if ('@package_version@' !== $phpUnitVersion && version_compare($phpUnitVersion, '3.5.0', '<')) {
    echo 'This version of PHPUnit (' . PHPUnit_Runner_Version::id() . ') is not supported in Laminas.x unit tests.' . PHP_EOL;
    exit(1);
}
unset($phpUnitVersion);

/*
 * Determine the root, library, and tests directories of the framework
 * distribution.
 */
$laminasRoot        = realpath(dirname(__DIR__));
$laminasCoreLibrary = "$laminasRoot/library";
$laminasCoreTests   = "$laminasRoot/tests";

/*
 * Prepend the Laminas library/ and tests/ directories to the
 * include_path. This allows the tests to run out of the box and helps prevent
 * loading other copies of the framework code and tests that would supersede
 * this copy.
 */
$path = array(
    $laminasCoreLibrary,
    $laminasCoreTests,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

/**
 * Setup autoloading
 */
include __DIR__ . '/_autoload.php';

/*
 * Load the user-defined test configuration file, if it exists; otherwise, load
 * the default configuration.
 */
if (is_readable($laminasCoreTests . DIRECTORY_SEPARATOR . 'TestConfiguration.php')) {
    require_once $laminasCoreTests . DIRECTORY_SEPARATOR . 'TestConfiguration.php';
} else {
    require_once $laminasCoreTests . DIRECTORY_SEPARATOR . 'TestConfiguration.php.dist';
}

if (defined('TESTS_GENERATE_REPORT') && TESTS_GENERATE_REPORT === true) {
    $codeCoverageFilter = PHP_CodeCoverage_Filter::getInstance();

    $lastArg = end($_SERVER['argv']);
    if (is_dir($laminasCoreTests . '/' . $lastArg)) {
        $codeCoverageFilter->addDirectoryToWhitelist($laminasCoreLibrary . '/' . $lastArg);
    } else if (is_file($laminasCoreTests . '/' . $lastArg)) {
        $codeCoverageFilter->addDirectoryToWhitelist(dirname($laminasCoreLibrary . '/' . $lastArg));
    } else {
        $codeCoverageFilter->addDirectoryToWhitelist($laminasCoreLibrary);
    }

    /*
     * Omit from code coverage reports the contents of the tests directory
     */
    $codeCoverageFilter->addDirectoryToBlacklist($laminasCoreTests, '');
    $codeCoverageFilter->addDirectoryToBlacklist(PEAR_INSTALL_DIR, '');
    $codeCoverageFilter->addDirectoryToBlacklist(PHP_LIBDIR, '');

    unset($codeCoverageFilter);
}


/**
 * Start output buffering, if enabled
 */
if (defined('TESTS_LAMINAS_OB_ENABLED') && constant('TESTS_LAMINAS_OB_ENABLED')) {
    ob_start();
}

/*
 * Unset global variables that are no longer needed.
 */
unset($laminasRoot, $laminasCoreLibrary, $laminasCoreTests, $path);
