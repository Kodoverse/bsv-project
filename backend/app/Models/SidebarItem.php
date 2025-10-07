<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SidebarItem extends Model
{
    protected $fillable = [
        'label',
        'route',
        'parent_id',
        'roles',
        'is_enabled',
        'order',
    ];


    protected $casts = [
        'roles' => 'array',
        'is_enabled' => 'boolean'
    ];

    //sottovoci sidebar 
    public function children()
    {
        return $this->hasMany(SidebarItem::class, 'parent_id', 'id')
            ->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(SidebarItem::class, 'parent_id', 'id');
    }

    //filtro voci in base al ruolo utente
    public function scopeForRole($query, $role)
    {
        return $query->where('is_enabled', true)
            ->where(function ($q) use ($role) {
                $q->whereJsonContains('roles', $role)
                    ->orWhereNull('roles');
            });
    }

    //funzione ricorsiva per mostrare le sottovoci
    public function visibleChildren($role)
    {
        return $this->children()->forRole($role)->get()->map(function ($child) use ($role) {
            $child->children = $child->visibleChildren($role);
            return $child;
        });
    }
}
