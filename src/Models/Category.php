<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'sort_order',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the products in this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the category's breadcrumb path.
     */
    public function getBreadcrumbsAttribute(): array
    {
        return [
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Categories', 'url' => '/categories'],
            ['name' => $this->name, 'url' => "/category/{$this->slug}"]
        ];
    }

    /**
     * Get the category's URL.
     */
    public function getUrlAttribute(): string
    {
        return "/category/{$this->slug}";
    }

    /**
     * Get the category's full path.
     */
    public function getFullPathAttribute(): string
    {
        return $this->name;
    }

    /**
     * Get the category's depth level.
     */
    public function getDepthAttribute(): int
    {
        return 0;
    }

    /**
     * Check if the category is a root category.
     */
    public function isRoot(): bool
    {
        return true;
    }

    /**
     * Check if the category is a leaf category.
     */
    public function isLeaf(): bool
    {
        return true;
    }

    /**
     * Generate a unique slug from the category name.
     */
    public static function generateSlug(string $name): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $slug = trim($slug, '-');
        
        $originalSlug = $slug;
        $counter = 1;
        
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured categories.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include root categories.
     */
    public function scopeRoot($query)
    {
        return $query;
    }

    /**
     * Scope a query to only include leaf categories.
     */
    public function scopeLeaf($query)
    {
        return $query;
    }

    /**
     * Scope a query to order categories by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope a query to search categories by name or description.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Find category by slug.
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Get root categories.
     */
    public static function getRootCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return static::root()->active()->ordered()->get();
    }

    /**
     * Get featured categories.
     */
    public static function getFeaturedCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return static::featured()->active()->ordered()->get();
    }

    /**
     * Create a new category with generated slug.
     */
    public static function createCategory(array $data): self
    {
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = static::generateSlug($data['name']);
        }

        return static::create($data);
    }

    /**
     * Move category to a new parent.
     */
    public function moveToParent(?int $parentId): bool
    {
        // No parent relationships, always return true
        return true;
    }

    /**
     * Convert the model to an array for API responses.
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'icon' => $this->icon,
            'parent_id' => null,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'url' => $this->url,
            'full_path' => $this->full_path,
            'depth' => $this->depth,
            'is_root' => $this->isRoot(),
            'is_leaf' => $this->isLeaf(),
            'products_count' => $this->products()->count(),
            'children_count' => 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
