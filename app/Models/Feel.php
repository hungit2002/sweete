<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feel extends Model
{
    use Authenticatable, HasFactory;

    const TABLE       = 'feels';
    const _ID         = 'id';
    const _KEY    = 'key';
    const _NAME     = 'name';
    const _EMOJI = 'emoji';

    const _CREATED_AT = 'created_at';
    const _UPDATED_AT = 'updated_at';
    const _DELETED_AT = 'deleted_at';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::_ID,
        self::_KEY,
        self::_NAME,
        self::_EMOJI,
        self::_CREATED_AT,
        self::_UPDATED_AT,
        self::_DELETED_AT,
    ];
}
