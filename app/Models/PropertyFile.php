<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PropertyFile extends Model
{
    protected $fillable = ['property_id', 'uploaded_by', 'category', 'path', 'original_name', 'mime_type', 'size'];
    protected $appends = ['url', 'is_image'];

    public function property() { return $this->belongsTo(Property::class); }
    public function getUrlAttribute(): string { return Storage::disk('public')->url($this->path); }
    public function getIsImageAttribute(): bool { return str_starts_with($this->mime_type, 'image/'); }
}
