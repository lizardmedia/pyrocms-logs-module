<?php namespace Lizard\LogsModule\Log\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query\GenericFilterQuery;
use Illuminate\Database\Eloquent\Builder;
use Lizard\LogsModule\Log\LogManager;

/**
 * File: LogTypeFilterQuery.php
 *
 * @author: Maciej Jeziorski <maciej.jeziorski@lizardmedia.pl>
 * @copyright: Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */
class LogTypeFilterQuery extends GenericFilterQuery
{

    /**
     * Handle the filter query.
     *
     * @param Builder         $query
     * @param FilterInterface $filter
     */
    public function handle(Builder $query, FilterInterface $filter)
    {
        foreach ((array)LogManager::getUsedEventsList() as $className => $translatedName) {
            if ($filter->getValue() == LogManager::getRawClassName($className)) {
                $query->where('log_type', $className);
                break;
            }
        }
    }
}
