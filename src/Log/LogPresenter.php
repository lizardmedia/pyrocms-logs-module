<?php namespace Lizard\LogsModule\Log;

use Anomaly\UsersModule\User\UserModel;
use Lizard\LogsModule\Log\LogManager;
use Anomaly\Streams\Platform\Entry\EntryPresenter;

class LogPresenter extends EntryPresenter
{


    public function id()
    {
        $id = $this->getObject()->id;

        return "<span class='text-muted'><i class='fa fa-key'></i> $id</span>";
    }

    public function userProfile()
    {
        $user = $this->getObject()->user;
        $userId = $this->getObject()->user_id;

        $displayName = ($user)
            ? $user->display_name
            : __('lizard.module.logs::message.user_removed');

        $profileUrl = ($user)
            ? route('anomaly.module.users::users.view', ['username' => $user->username])
            : null;

        return ($user)
            ? "<a href='$profileUrl'>$displayName</a>"
            : "<span class='text-danger'>$displayName</span> <small class='text-muted'><i class='fa fa-question-circle' title='ID: $userId'></i></small>";
    }

    public function context()
    {
        $id     = $this->getObject()->context_id;
        $type   = $this->getObject()->context_type;
        $object = LogManager::getContextObject($id, $type);

        if ($object || null === $object) {
            $typeName   = LogManager::getClassTranslation($type);
            $objectName = $this->getObject()->name ?: '';
            $objectUrl  = ($object) ? (LogManager::getObjectUrl($object, $type) ?: 'javascript:;') : 'javascript:;';
            $color      = (! $object) ? 'text-danger' : '';

            return "<a href='$objectUrl'><strong>$typeName</strong> <span class='$color'>$objectName</span></a> " .
                (!$object ? "<small class='text-muted'><i class='fa fa-question-circle' title='ID: $id'></i></small>" : '');
        } elseif (false === $object) {
            $typeName = __('lizard.module.logs::message.type_invalid');

            return "<strong class='text-danger'>$typeName</strong> <small class='text-muted'><i class='fa fa-question-circle' title='$type (ID: $id)'></i></small>";
        }
    }

    public function actionType()
    {
        $logType = $this->getObject()->log_type;
        $invalidLogType = __('lizard.module.logs::message.logtype_invalid');

        return LogManager::getClassTranslation($logType)
            ?: "<span class='text-danger'>$invalidLogType</span>";
    }

    public function date()
    {
        $date = $this->getObject()->created_at->format('d-m-Y');
        $time = $this->getObject()->created_at->format('H:i');

        return "$date <small class='text-muted'>$time</small>";
    }
}
