<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Lab;

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
        'name',
        'nama_lengkap',
        'kode_aslab',
        'email',
        'username',
        'id_lab',
        'jurusan',
        'role',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation to Lab (laboratorium) - for single lab if needed
     */
    public function laboratorium()
    {
        return $this->belongsTo(Lab::class, 'id_lab');
    }

    /**
     * Many-to-many relation to Labs via user_lab pivot
     */
    public function labs()
    {
        return $this->belongsToMany(Lab::class, 'user_lab');
    }
}
