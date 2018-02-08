<?php

namespace Lizard\LogsModule\Log;

use Anomaly\FilesModule\File\FileModel;
use Anomaly\FilesModule\Folder\FolderModel;
use Anomaly\NavigationModule\Menu\MenuModel;
use Anomaly\PageLinkTypeExtension\PageLinkTypeModel;
use Anomaly\PagesModule\Page\PageModel;
use Anomaly\RedirectsModule\Redirect\RedirectModel;
use Anomaly\SettingsModule\Setting\SettingModel;
use Anomaly\Streams\Platform\Entry\Event\EntryWasCreated;
use Anomaly\Streams\Platform\Entry\Event\EntryWasDeleted;
use Anomaly\Streams\Platform\Entry\Event\EntryWasRestored;
use Anomaly\Streams\Platform\Entry\Event\EntryWasUpdated;
use Anomaly\UrlLinkTypeExtension\UrlLinkTypeModel;
use Illuminate\Support\Facades\Auth;

/**
 * File: LogManager.php
 *
 * @author: Maciej Jeziorski <maciej.jeziorski@lizardmedia.pl>
 * @copyright: Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */
class LogManager
{
    use LogManagerCore;

    protected static $defaultEvents = [
        EntryWasCreated::class,
        EntryWasUpdated::class,
        EntryWasDeleted::class,
    ];

    protected static $observedModels = [
        FileModel::class => [
            'field' => 'name',
            'url' => '/admin/files/edit/{id}',
        ],
        FolderModel::class => [
            'field' => 'name',
            'url' => '/admin/files/folders/edit/{id}',
        ],
        RedirectModel::class => [
            'field' => 'to',
            'url' => '/admin/redirects/edit/{id}',
        ],
        SettingModel::class => [
            'strict_prevent_spam' => true,
            'url' => '/admin/settings',
            'events' => [
                EntryWasUpdated::class,
            ]
        ],
    ];
}
