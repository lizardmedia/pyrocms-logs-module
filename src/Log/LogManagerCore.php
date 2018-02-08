<?php namespace Lizard\LogsModule\Log;

use Anomaly\Streams\Platform\Entry\Event\EntryWasDeleted;
use Anomaly\Streams\Platform\Entry\Event\EntryWasUpdated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * File: LogManagerCore.php
 *
 * @author: Maciej Jeziorski <maciej.jeziorski@lizardmedia.pl>
 * @copyright: Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */
trait LogManagerCore
{
    /*
     * Save log into database
     *
     * @param $event - event object
     * @param $modelClass - full class name of model
     */
    public static function saveLog($event, $modelClass)
    {
        if (!($user = Auth::user())) {
            return;
        }
        if (self::preventSpam($user, $event, $modelClass)) {
            return;
        }

        $log = new LogModel();
        $log->user_id = $user->id;
        $log->context_id = $event->getEntry()->id;
        $log->context_type = $modelClass;
        $log->log_type = get_class($event);
        $log->name = self::getObjectName($event->getEntry(), $modelClass);

        $log->save();
    }

    /*
     * Prevent the addition of many identical logs in a short period of time
     *
     * @return (boolean)
     */
    protected static function preventSpam($user, $event, $modelClass)
    {
        $strict = isset(self::$observedModels[$modelClass]['strict_prevent_spam'])
                ? self::$observedModels[$modelClass]['strict_prevent_spam']
                : false;

        return LogModel::where(function ($query) use ($user, $event, $modelClass, $strict) {
                $query->where('user_id', $user->id);
                $query->where('context_type', $modelClass);
                $query->where('created_at', '>=', Carbon::now()->subMinute()->format('Y-m-d H:i:s'));
            if (!$strict) {
                $query->where('context_id', $event->getEntry()->id);
            }
            if (EntryWasDeleted::class == get_class($event)) {
                $query->where('log_type', get_class($event));
            }
        })->exists();
    }

    /*
     * Check if model is observed
     *
     * @param (string) $modelClass - full model class (with path)
     * @return (boolean)
     */
    public static function isObserved($modelClass)
    {
        return isset(self::$observedModels[$modelClass]);
    }

    /*
     * Check if event is allowed for current model
     *
     * @param (string) $modelClass - full model class (with path)
     * @param (string) $eventClass - full event class (with path)
     * @return (boolean)
     */
    public static function isEventAllowed($modelClass, $eventClass)
    {
        return in_array(
            $eventClass,
            self::$observedModels[$modelClass]['events'] ?? self::$defaultEvents
        );
    }

    /*
     * Find object using polymorphic relationship and return it.
     *
     * @param (int) $id - element ID (polymorphic relationship 1:N)
     * @param (string) $modelClass - full model class (with path) (polymorphic relationship 1:N)
     * @return EntryModel | null | false
     */
    public static function getContextObject($id, $modelClass)
    {
        if (class_exists($modelClass) && $model = new $modelClass()) {
            if ($object = $model->find($id)) {
                return $object; // Object was found and returned
            }

            return null; // Type was found, but object not
        }

        return false; // Type was not found
    }

    /*
     * Get name (title) for given object.
     *
     * @param EntryModel $object
     * @param $modelClass - full model class
     * @return (string) | null
     */
    public static function getObjectName($object, $modelClass)
    {
        $config = self::$observedModels[$modelClass];

        // Check if option 'field' exist
        if (isset($config['field']) && $field = $config['field']) {
            return $object->$field ?? null;
        }

        return null;
    }

    /*
     * Get URL for given object.
     *
     * @param EntryModel $object
     * @param $modelClass - full model class
     * @return (string) | null
     */
    public static function getObjectUrl($object, $modelClass)
    {
        $config = self::$observedModels[$modelClass];

        // Check if option 'field' exist
        if (isset($config['url']) && $url = $config['url']) {
            return str_replace('{id}', $object->id, $url);
        }

        return null;
    }

    /*
     * Get list of used events (log types)
     *
     * @return array [full_model_class => translation]
     */
    public static function getUsedEventsList()
    {
        $keys = array_values(self::$defaultEvents);
        foreach ((array)self::$observedModels as $config) {
            if (isset($config['events'])) {
                foreach ((array)$config['events'] as $customEvent) {
                    if (!in_array($customEvent, $keys)) {
                        $keys[] = $customEvent;
                    }
                }
            }
        }

        array_walk($keys, function ($value, $key) use (&$values) {
            $values[$key] = self::getClassTranslation($value);
        });

        return array_combine($keys, $values ?? []);
    }

    /*
     * Get raw list of used events (log types)
     *
     * @return [raw_model_class => translation]
     */
    public static function getRawUsedEventsList()
    {
        foreach ((array)self::getUsedEventsList() as $className => $translatedValue) {
            $rawUsedEventsList[self::getRawClassName($className)] = $translatedValue;
        }

        return $rawUsedEventsList ?? [];
    }

    /*
     * Get list of observed models
     *
     * @return [raw_model_class => translation]
     */
    public static function getObservedModelsList()
    {
        $keys = array_keys(self::$observedModels);

        array_walk($keys, function ($value, $key) use (&$values) {
            $values[$key] = self::getClassTranslation($value);
        });

        return array_combine($keys, $values ?? []);
    }


    /*
     * Get raw list of observed models
     *
     * @return [raw_model_class => translation]
     */
    public static function getRawObservedModelsList()
    {
        foreach ((array)self::getObservedModelsList() as $className => $translatedValue) {
            $rawObservedModelsList[self::getRawClassName($className)] = $translatedValue;
        }

        return $rawObservedModelsList ?? [];
    }

    /*
     * Get raw class name from full class name.
     *
     * @return (string)
     */
    public static function getRawClassName($className)
    {
        $explodedClassName = (array)explode('\\', $className);

        return end($explodedClassName);
    }

    /*
     * Get translated text for given full class name.
     *
     * @return (string) | null
     */
    public static function getClassTranslation($className)
    {
        $rawClassName = self::getRawClassName($className);

        return ($rawClassName)
            ? __("lizard.module.logs::message.$rawClassName")
            : null;
    }
}
