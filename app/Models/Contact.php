<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'assigned_user_id',
        'category_id',
    ];

    // 担当者とのリレーション
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    // カテゴリーとのリレーション
            public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // メモとのリレーション
    public function memos()
{
    return $this->hasMany(Memo::class);
}

}
