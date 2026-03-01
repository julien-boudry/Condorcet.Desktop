<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Disable Vite asset injection during tests to avoid requiring a built
     * manifest. All HTTP-level feature tests render the full layout (which
     * calls @vite), so without this every such test would fail with a
     * ViteManifestNotFoundException.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}
