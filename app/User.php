<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow','user_id','follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    //フォロー、アンフォローのメソッド
    
    public function follow($userId)
    {
        //すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        //自分自身ではないかの確認
        $its_me = $this->id == $userId;
        
        if ($exist || $its_me) {
            return false;
        } else {
            //未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        //すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        //自分自身ではないかの確認
        $its_me = $this->id == $userId;
        
        if ($exist && !$its_me ) {
            $this->followings()->detach($userId);
            return true;
        } else {
            //未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId) {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function feed_microposts() 
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
    //$userのmicropostsお気に入り取り出し
    public function favorite()
    {
        return $this->belongsToMany(Micropost::class, 'user_favorites', 'user_id', 'micropost_id')->withTimestamps();
    }
    
    //----お気に入り-----
    //お気に入り追加
    public function addFav($micropostId)
    {
        $exist = $this->is_favorite($micropostId);

        if ( $exist ){
            return false;
        } else {
            $this->favorite()->attach($micropostId);
            return true;
        }
    }
    //お気に入り削除
    public function delFav($micropostId)
    {
        $exist = $this->is_favorite($micropostId);

        if ( $exist ) {
            $this->favorite()->detach($micropostId);
            return true;
        } else {
            return false;
        }
    }
    
    //現在お気に入り中かの確認
    public function is_favorite($micropostId)
    {
        return $this->favorite()->where('micropost_id', $micropostId)->exists();
    }
}
