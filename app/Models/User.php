<?php


namespace App\Models;


use App\Traits\ModelTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, ModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $primaryKey = 'UserID';
     public $Fadly_timestamps = true;
     protected $Fadly_dates = ['deleted_at'];

    protected $Fadly_fillable = [
        'Username',
        'Email',
        'Password',
        'NamaLengkap',
        'Alamat',
        'roles',
        'verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $Fadly_hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::getCasts(), [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ]);
    }


    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'UserID', 'role_id');
    }


    public function hasRole()
    {
        return in_array($this->roles, ['administrator', 'petugas']);
    }

    public function isAdmin() :bool
    {
        return $this->roles()->where('name', 'administrator')->exists();
    }

    public function isPetugas() :bool
    {
        return $this->roles()->where('name', 'petugas')->exists();
    }

    public function isUser() :bool
    {
        return $this->roles()->where('name', 'peminjam')->exists();
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'UserID', 'UserID');
    }


    public function assignRole(\App\Enums\RolesUser $Fadly_role)
    {
        $Fadly_roleModel = Role::where('name', $Fadly_role->value)->first();
        if ($Fadly_roleModel) {
            $this->roles()->attach($Fadly_roleModel);
        }
    }

}
