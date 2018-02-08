<?php namespace Lizard\LogsModule\Log\Table;

/**
 * File: LogTableBuilder.php
 *
 * @author: Maciej Jeziorski <maciej.jeziorski@lizardmedia.pl>
 * @copyright: Copyright (C) 2017 Lizard Media (http://lizardmedia.pl)
 */
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Lizard\LogsModule\Log\LogManager;
use Lizard\LogsModule\Log\Table\Filter\LogTypeFilterQuery;
use Lizard\LogsModule\Log\Table\Filter\ContextTypeFilterQuery;

class LogTableBuilder extends TableBuilder
{

    /**
     * The table views.
     *
     * @var array|string
     */
    protected $views = [];

    /**
     * The table filters.
     *
     * @var array|string
     */
    protected $filters = [
        'user',
        'context_type' => [
            'filter' => 'select',
            'query'   => ContextTypeFilterQuery::class,
            'options' => [],
        ],
        'log_type' => [
            'filter' => 'select',
            'query'   => LogTypeFilterQuery::class,
            'options' => [],
        ],
    ];

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'id' => [
            'value' => 'entry.id'
        ],
        'user' => [
            'value' => 'entry.user_profile',
            'sort_column' => 'user',
        ],
        'context' => [
            'value' => 'entry.context',
            'sort_column' => 'context_type',
        ],
        'log_type' => [
            'value' => 'entry.action_type',
            'sort_column' => 'log_type',
        ],
        'date' => [
            'value' => 'entry.date',
            'sort_column' => 'created_at',

        ],
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [];

    /**
     * The table actions.
     *
     * @var array|string
     */
    protected $actions = [];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'order_by' => [
            'id' => 'DESC',
        ],
    ];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

    public function __construct(Table $table)
    {
        $this->filters['context_type']['options'] = LogManager::getRawObservedModelsList();
        $this->filters['log_type']['options'] = LogManager::getRawUsedEventsList();

        parent::__construct($table);
    }
}
