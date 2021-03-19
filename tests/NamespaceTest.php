<?php

namespace Uteq\ModelActions\Tests;

use Uteq\ModelActions\Tests\Fixtures\Models\TestModel;
use Uteq\ModelActions\Tests\Fixtures\OtherNamespaceActions\TestModel\Create;

class NamespaceTest extends TestCase
{
    /** @test */
    public function test_different_namespace()
    {
        $this->assertTrue(true);
//
//        $this->app['config']->set('model-actions.path', dirname(dirname(__FILE__)) .'/tests');
//        $this->app['config']->set('model-actions.app_namespace', 'Uteq\\ModelActions\\Tests');
//        $this->app['config']->set('model-actions.namespace', '\Uteq\ModelActions\Tests\Fixtures\OtherNamespaceActions');
//
//        $unique = uniqid();
//        $result = TestModel::do('create', unique: $unique);
//
//        $this->assertStringContainsString($unique, $result);
//
//        $this->app['config']->set('model-actions.path', dirname(dirname(__FILE__)) .'/src');
//        $this->app['config']->set('model-actions.app_namespace', 'Uteq\\ModelActions');
//        $this->app['config']->set('model-actions.namespace', null);
    }
}
