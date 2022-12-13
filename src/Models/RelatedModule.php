<?php

namespace Esatic\Suitecrm\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RelatedModule
 *
 * @property string $relation_name
 * @property string $related_table
 * @property string $primary_table
 * @property string $related_field
 * @property string $filter_field
 * @property bool $cstm
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class RelatedModule extends Model
{
    use HasFactory;

    protected $primaryKey = 'relation_name';
    protected $keyType = 'string';

    protected $fillable = [
        'relation_name',
        'related_table',
        'primary_table',
        'related_field',
        'filter_field',
        'module',
        'cstm'
    ];

    protected $casts = [
        'cstm' => 'bool'
    ];
}
