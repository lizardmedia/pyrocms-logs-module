<?php namespace Lizard\LogsModule\Log\Form;

/**
 * File: LogFormBuilder.php
 *
 * @author: Maciej Jeziorski <maciej.jeziorski@lizardmedia.pl>
 * @copyright: Copyright (C) 2017 Lizard Media (http://lizardmedia.pl)
 */
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class LogFormBuilder extends FormBuilder
{

    /**
     * The form fields.
     *
     * @var array|string
     */
    protected $fields = [];

    /**
     * Additional validation rules.
     *
     * @var array|string
     */
    protected $rules = [];

    /**
     * Fields to skip.
     *
     * @var array|string
     */
    protected $skips = [];

    /**
     * The form actions.
     *
     * @var array|string
     */
    protected $actions = [];

    /**
     * The form buttons.
     *
     * @var array|string
     */
    protected $buttons = [];

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The form sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * The form assets.
     *
     * @var array
     */
    protected $assets = [];
}
