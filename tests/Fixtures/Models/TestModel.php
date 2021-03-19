<?php

namespace Uteq\ModelActions\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Uteq\ModelActions\Concerns\WithActions;

class TestModel extends Model
{
    use WithActions;
}
