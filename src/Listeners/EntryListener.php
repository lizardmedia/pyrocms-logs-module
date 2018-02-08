<?php namespace Lizard\LogsModule\Listeners;

use Lizard\LogsModule\Log\LogManager;

/**
 * File: Event.php
 *
 * @author: Maciej Jeziorski <maciej.jeziorski@lizardmedia.pl>
 * @copyright: Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */
class EntryListener
{
    public function handle($event)
    {
        $eventClass = get_class($event);
        $entryClass = get_class($event->getEntry());

        if (LogManager::isObserved($entryClass) && LogManager::isEventAllowed($entryClass, $eventClass)) {
            LogManager::saveLog($event, $entryClass);
        }
    }
}
