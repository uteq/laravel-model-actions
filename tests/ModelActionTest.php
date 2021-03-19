<?php

namespace Uteq\ModelActions\Tests;

use Uteq\ModelActions\Tests\Fixtures\Actions\TestModel\Create;
use Uteq\ModelActions\Tests\Fixtures\Actions\TestModel\DoThis;
use Uteq\ModelActions\Tests\Fixtures\Actions\TestModel\Update;
use Uteq\ModelActions\Tests\Fixtures\Models\OtherTestModel;
use Uteq\ModelActions\Tests\Fixtures\Models\TestModel;

class ModelActionTest extends TestCase
{
    /** @test */
    public function can_perform_action_on_new_model()
    {
        $result = TestModel::do(Create::class, name: 'hi');

        $this->assertStringContainsString($result, 'hi');

        $result = TestModel::do('create', name: 'hi');

        $this->assertStringContainsString($result, 'hi');

        $result = TestModel::do()->create(name: 'hi');

        $this->assertStringContainsString($result, 'hi');
    }

    /** @test */
    public function can_perform_action_on_existing_model()
    {
        $testModel = new TestModel();
        $testModel->id = 1;

        $result = $testModel->action(Update::class, test: 'hi');

        $this->assertStringContainsString($result::class, TestModel::class);
        $this->assertStringContainsString((string) $result->id, (string) $testModel->id);

        $result = $testModel->action('update', test: 'hi');

        $this->assertStringContainsString($result::class, TestModel::class);
        $this->assertStringContainsString((string) $result->id, (string) $testModel->id);

        $result = $testModel->action('update', test: 'hi');

        $this->assertStringContainsString($result::class, TestModel::class);
        $this->assertStringContainsString((string) $result->id, (string) $testModel->id);

        $result = $testModel->action()->update(test: 'hi');

        $this->assertStringContainsString($result::class, TestModel::class);
        $this->assertStringContainsString((string) $result->id, (string) $testModel->id);
    }

    /** @test */
    public function can_use_another_name_for_the_model_variable()
    {
        $testModel = new TestModel();
        $testModel->id = 1;

        $result = $testModel->action('doThat');

        $this->assertStringContainsString($result::class, TestModel::class);
        $this->assertStringContainsString((string) $result->id, (string) $testModel->id);
    }

    /** @test */
    public function action_on_model_with_other_model()
    {
        $otherTestModel = new OtherTestModel();
        $otherTestModel->id = 1;

        $result = TestModel::do(DoThis::class, $otherTestModel, input: ['hi']);

        $this->assertStringContainsString($result::class, OtherTestModel::class);
        $this->assertStringContainsString((string) $result->id, (string) $otherTestModel->id);
    }
}
