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
        'parent_id',
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
        'parent_id' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get all descendants (children, grandchildren, etc.).
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors (parent, grandparent, etc.).
     */
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;
        
        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }

    /**
     * Get the products in this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all products in this category and its subcategories.
     */
    public function allProducts()
    {
        $categoryIds = $this->getAllDescendantIds();
        $categoryIds[] = $this->id;
        
        return Product::whereIn('category_id', $categoryIds);
    }

    /**
     * Get all descendant category IDs.
     */
    public function getAllDescendantIds(): array
    {
        $ids = [];
        
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }
        
        return $ids;
    }

    /**
     * Get the category's breadcrumb path.
     */
    public function getBreadcrumbsAttribute(): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Categories', 'url' => '/categories']
        ];
        
        $ancestors = $this->ancestors();
        foreach ($ancestors as $ancestor) {
            $breadcrumbs[] = [
                'name' => $ancestor->name,
                'url' => "/categories/{$ancestor->slug}"
            ];
        }
        
        $breadcrumbs[] = [
            'name' => $this->name,
            'url' => "/categories/{$this->slug}"
        ];
        
        return $breadcrumbs;
    }

    /**
     * Get the category's URL.
     */
    public function getUrlAttribute(): string
    {
        return "/categories/{$this->slug}";
    }

    /**
     * Get the category's full path (parent > child > grandchild).
     */
    public function getFullPathAttribute(): string
    {
        $ancestors = $this->ancestors();
        $path = $ancestors->pluck('name')->toArray();
        $path[] = $this->name;
        
        return implode(' > ', $path);
    }

    /**
     * Get the category's depth level (0 for root categories).
     */
    public function getDepthAttribute(): int
    {
        return $this->ancestors()->count();
    }

    /**
     * Check if the category is a root category.
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Check if the category is a leaf category (has no children).
     */
    public function isLeaf(): bool
    {
        return $this->children()->count() === 0;
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
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to only include leaf categories.
     */
    public function scopeLeaf($query)
    {
        return $query->whereDoesntHave('children');
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
        // Prevent moving to self or descendant
        if ($parentId === $this->id) {
            return false;
        }
        
        if ($parentId) {
            $parent = static::find($parentId);
            if ($parent && in_array($parentId, $this->getAllDescendantIds())) {
                return false;
            }
        }
        
        $this->parent_id = $parentId;
        return $this->save();
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
            'parent_id' => $this->parent_id,
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
            'children_count' => $this->children()->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
