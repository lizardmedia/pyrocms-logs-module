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
use Lizard\NewsModule\News\NewsModel;
use Lizard\PortfolioModule\Architect\ArchitectModel;
use Lizard\PortfolioModule\Developer\DeveloperModel;
use Lizard\PortfolioModule\Investor\InvestorModel;
use Lizard\PortfolioModule\Object\ObjectModel;
use Lizard\PortfolioModule\ObjectType\ObjectTypeModel;
use Lizard\PortfolioModule\StructureDeveloper\StructureDeveloperModel;
use Lizard\PortfolioModule\System\SystemModel;
use Lizard\TranslationsModule\Translation\TranslationModel;
use Lizard\TranslationsModule\Category\CategoryModel as TranslationsCategoryModel;

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
        NewsModel::class => [
            'field' => 'title',
            'url' => '/admin/news/view/{id}',
        ],
        ObjectModel::class => [
            'field' => 'name',
            'url' => '/admin/portfolio/edit/{id}',
        ],
        SystemModel::class => [
            'field' => 'name',
            'url' => '/admin/portfolio/systems/edit/{id}',
        ],
        ObjectTypeModel::class => [
            'field' => 'name',
            'url' => '/admin/portfolio/object_types/edit/{id}',
        ],
        DeveloperModel::class => [
            'field' => 'name',
            'url' => '/admin/portfolio/developers/edit/{id}',
        ],
        InvestorModel::class => [
            'field' => 'name',
            'url' => '/admin/portfolio/investors/edit/{id}',
        ],
        ArchitectModel::class => [
            'field' => 'name',
            'url' => '/admin/portfolio/architects/edit/{id}',
        ],
        StructureDeveloperModel::class => [
            'field' => 'name',
            'url' => '/admin/portfolio/structure_developers/edit/{id}',
        ],
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
        TranslationModel::class => [
            'field' => 'key',
            'url' => '/admin/translations/edit/{id}',
        ],
    ];
}
