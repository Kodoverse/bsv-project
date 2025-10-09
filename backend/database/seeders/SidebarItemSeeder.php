<?php

namespace Database\Seeders;

use App\Models\SidebarItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SidebarItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sidebar_items = config('bsvdb.sidebar_items');
        foreach ($sidebar_items as $sidebar_item) {
            $newSidebarItem = new SidebarItem();
            $newSidebarItem->label = $sidebar_item['label'];
            $newSidebarItem->route = $sidebar_item['route'];
            $newSidebarItem->icon = $sidebar_item['icon'];
            $newSidebarItem->parent_id = $sidebar_item['parent_id'];
            $newSidebarItem->roles = $sidebar_item['roles'];
            $newSidebarItem->is_enabled = $sidebar_item['is_enabled'];
            $newSidebarItem->order = $sidebar_item['order'];
            $newSidebarItem->save();
        }
    }
}
