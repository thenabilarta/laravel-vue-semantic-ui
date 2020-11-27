<?php

namespace Modules\Platform\Notifications\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Notifications\GenericNotification;
use Modules\Platform\Notifications\Entities\NotificationPlaceholder;
use Modules\Platform\User\Entities\User;

class NotificationsDemoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        $user = User::find(1);

        $user->notifications()->delete();

        $placeholder = new NotificationPlaceholder();

        $placeholder->setRecipient($user);
        $placeholder->setAuthorUser(\Auth::user());
        $placeholder->setAuthor($user->name);
        $placeholder->setColor('bg-green');
        $placeholder->setIcon('assignment');
        $placeholder->setContent(trans('notifications::notifications.new_record', ['user' => $user->name]));

        $placeholder->setUrl(route('campaigns.campaigns.show', 1));

        $user->notify(new GenericNotification($placeholder));

    }

}