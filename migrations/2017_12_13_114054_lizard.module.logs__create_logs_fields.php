<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class LizardModuleLogsCreateLogsFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'user' => [
            "type" => "anomaly.field_type.relationship",
            "config" => [
                "related" => "\Anomaly\UsersModule\User\UserModel",
                "mode" => "dropdown",
                "handler" => "\Anomaly\RelationshipFieldType\Handler\Related@handle",
            ],
        ],
        'context_id' => "anomaly.field_type.integer",
        'context_type' => 'anomaly.field_type.text',
        'log_type' => 'anomaly.field_type.text',
        'name' => 'anomaly.field_type.text'
    ];
}
