<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model{
    protected $table = "ulasan";

    // public $timestamps = false;

    protected $fillable = [
        'user_id',
        'book_id',
        'ulasan',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Books::class, 'book_id');
    }
}