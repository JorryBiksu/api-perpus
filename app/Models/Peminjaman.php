<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model{
    protected $table = "peminjaman";

    // public $timestamps = false;

    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
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