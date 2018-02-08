<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class LizardModuleLogsCreateLogsStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'translatable' => false,
        'trashable' => false,
        'searchable' => false,
        'sortable' => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'user' => [
            'required' => false,
        ],
        'context_id' => [
            'required' => true,
        ],
        'context_type' => [
            'required' => true,
        ],
        'log_type' => [
            'required' => true,
        ],
        'name' => [
            'required' => false,
        ],
    ];
}
