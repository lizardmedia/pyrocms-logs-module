<?php namespace Lizard\LogsModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class LogsModule extends Module
{

    /**
     * The navigation display flag.
     *
     * @var bool
     */
    protected $navigation = true;

    /**
     * The addon icon.
     *
     * @var string
     */
    protected $icon = 'fa fa-id-card-o';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [];
}
