<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UsersInfo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'user_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['display_name', 'initials'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function info()
    {
        return $this->hasOne(UsersInfo::class);
    }

    public function flagged_comments()
    {
        return $this->hasMany(FlaggedComment::class);
    }

    public function getDisplayNameAttribute(): string
    {
        if (!$this->info) {
            return $this->email;
        }

        return trim($this->info->firstname . ' ' . $this->info->lastname);

    }

    public function getInitialsAttribute(): string
    {
        if (!$this->info || (!$this->info->firstname && !$this->info->lastname)) {
            return '';
        }

        $first = $this->info->firstname ? substr($this->info->firstname, 0, 1) : '';
        $last = $this->info->lastname ? substr($this->info->lastname, 0, 1) : '';

        return strtoupper($first . $last);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
