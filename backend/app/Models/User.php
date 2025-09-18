<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_likes')
                    ->withTimestamps();
    }

     public function likedArticles()
    {
        return $this->belongsToMany(Article::class, 'article_likes')
                    ->withTimestamps();
    }

    /**
     * Get events created by this user
     */
    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Get event registrations for this user
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get products if user is a partner
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'partner_id');
    }

    /**
     * Get purchases made by user
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get sales if user is a partner
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Purchase::class, 'partner_id');
    }

    /**
     * Get events this user is registered for
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'event_registrations')
            ->withPivot('status', 'registered_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Get points earned by this user
     */
    public function points()
    {
        return $this->hasMany(Point::class);
    }

    /**
     * Get points awarded by this user (as admin)
     */
    public function awardedPoints()
    {
        return $this->hasMany(Point::class, 'awarded_by');
    }

    /**
     * Get partner information for this user
     */
    public function partnerInfo()
    {
        return $this->hasOne(PartnerInfo::class);
    }

    /**
     * Check if user is a partner
     */
    public function isPartner(): bool
    {
        return $this->user_role === 'partner';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->user_role === 'admin';
    }

    /**
     * Check if user has admin privileges
     */
    public function hasAdminPrivileges(): bool
    {
        return in_array($this->user_role, ['admin', 'librarian']);
    }

}
