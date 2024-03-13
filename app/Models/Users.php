<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model{
    protected $table = "users";

    // protected $fillable = [];

    // public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama','username','password','telp','alamat','role'
   ];

   /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
   protected $hidden = [
       'password',
   ];
}