<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test\Hook;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeTestHook;

class BypassFinalHook implements BeforeTestHook
{
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
