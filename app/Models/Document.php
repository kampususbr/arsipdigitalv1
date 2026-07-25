<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'work_unit_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'document_number',
        'document_date',
        'created_by',
        'updated_by',
        'visibility',
    ];

    protected $casts = [
        'document_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(DocumentCategory::class);
    }

    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function accessRecords()
    {
        return $this->hasMany(DocumentAccess::class);
    }

    public function accessibleByUsers()
    {
        return $this->belongsToMany(User::class, 'document_access', 'document_id', 'user_id');
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeRestricted($query)
    {
        return $query->where('visibility', 'restricted');
    }

    public function scopePrivate($query)
    {
        return $query->where('visibility', 'private');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByWorkUnit($query, $workUnitId)
    {
        return $query->where('work_unit_id', $workUnitId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    // Methods
    public function isAccessibleBy($user)
    {
        if ($this->visibility === 'public') {
            return true;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($this->created_by === $user->id) {
            return true;
        }

        return $this->accessRecords()->where('user_id', $user->id)->exists();
    }

    public function getFileSizeFormatted()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
