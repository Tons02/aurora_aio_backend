<?php

namespace App\Models\UserManagement;

use App\Filters\Usermanagement\UserFilter;
use App\Models\Masterlist\BusinessUnit;
use App\Models\Masterlist\Companies;
use App\Models\Masterlist\Department;
use App\Models\Masterlist\Location;
use App\Models\Masterlist\OneCharging;
use App\Models\Masterlist\SubUnit;
use App\Models\Masterlist\Unit;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_prefix',
        'id_no',
        'first_name',
        'middle_name',
        'last_name',
        'mobile_number',
        'gender',
        'one_charging_id',
        'username',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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
        return [
            'password' => 'hashed',
            'role_id' => 'integer',
        ];
    }


    protected string $default_filters = UserFilter::class;

    public function one_charging()
    {
        return $this->belongsTo(OneCharging::class, 'one_charging_id', 'sync_id')->withTrashed();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id')->withTrashed();
    }
}
