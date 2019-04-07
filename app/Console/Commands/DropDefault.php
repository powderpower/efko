<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Role;
use App\UserRole;

class DropDefault extends Command
{
    protected $signature = 'drop:default';

    protected $description = 'Drop database to default value';

    public function handle()
    {
        User::truncate();
        Role::truncate();
        UserRole::truncate();

        $roles = ['Менеджер', 'Руководитель'];
        $users = ['Иван Сидоров', ['Юлия Петрова', 'W'], 'Иван Иванов', ['Настя Астапова', 'W'], 'Славик Петров'];

        foreach($roles as $role):
            Role::create(['name' => $role]);
        endforeach;

        foreach($users as $user):
            $splitedName = explode(' ', (is_array($user) ? $user[0] : $user));
            $content = [
                'first_name' => $splitedName[0],
                'last_name' => $splitedName[1],
            ];
            (is_array($user))&&($content['sex'] = $user[1]);
            User::create($content);
        endforeach;

        foreach(User::all() as $user):
            UserRole::create(['user_id' => $user->id]);
        endforeach;

        UserRole::orderBy('id', 'desc')->first()->update(['role_id' => 2]);

        $this->info('Completed');
    }
}
