<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menu')->delete();

        $menu_items = array(
            array(
                'id' => 2,
                'parent_id' => 0,
                'order' => 6,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 3,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 4,
                'parent_id' => 2,
                'order' => 8,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 5,
                'parent_id' => 2,
                'order' => 9,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 6,
                'parent_id' => 2,
                'order' => 10,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 7,
                'parent_id' => 2,
                'order' => 11,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 8,
                'parent_id' => 9,
                'order' => 2,
                'title' => 'Offers',
                'icon' => 'fa-car',
                'uri' => 'offers',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 9,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Manager',
                'icon' => 'fa-dashboard',
                'uri' => '',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 10,
                'parent_id' => 9,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'users',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 11,
                'parent_id' => 9,
                'order' => 4,
                'title' => 'Languages',
                'icon' => 'fa-globe',
                'uri' => 'languages',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 12,
                'parent_id' => 9,
                'order' => 5,
                'title' => 'Translations',
                'icon' => 'fa-file-text',
                'uri' => 'translations',
                'permission' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        );

        DB::table('admin_menu')->insert($menu_items);
    }
}
