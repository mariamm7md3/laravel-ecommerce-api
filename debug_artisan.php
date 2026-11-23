<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Pest\TestSuite;
use Pest\Exceptions\InvalidPestCommand;

// Monkey-patch: override Exception to capture stack trace
class DebugInvalidPestCommand extends InvalidPestCommand {
    public function __construct() {
        parent::__construct();
        echo "\n=== InvalidPestCommand thrown! ===\n";
        echo $this->getTraceAsString() . "\n";
    }
}

// Temporarily override TestSuite::getInstance to detect the call
// We'll do this via a Closure hack  - actually let's just check if it's called
register_shutdown_function(function() {
    echo "Script ended normally\n";
});

$app = require_once __DIR__.'/bootstrap/app.php';

echo "App bootstrapped OK\n";

$status = $app->handleCommand(new ArgvInput);

exit($status);
