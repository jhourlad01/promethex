<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'manage_stock',
        'in_stock',
        'status',
        'featured',
        'images',
        'attributes',
        'weight',
        'length',
        'width',
        'height',
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
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'featured' => 'boolean',
        'images' => 'array',
        'attributes' => 'array',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product's display price (sale price if available, otherwise regular price).
     */
    public function getDisplayPriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get the product's discount percentage.
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->sale_price || $this->sale_price >= $this->price) {
            return null;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * Get the product's primary image.
     */
    public function getPrimaryImageAttribute(): ?string
    {
        if (empty($this->images) || !is_array($this->images)) {
            return null;
        }

        return $this->images[0] ?? null;
    }

    /**
     * Get the product's formatted dimensions.
     */
    public function getFormattedDimensionsAttribute(): ?string
    {
        if (!$this->length || !$this->width || !$this->height) {
            return null;
        }

        return "{$this->length} × {$this->width} × {$this->height} cm";
    }

    /**
     * Get the product's formatted weight.
     */
    public function getFormattedWeightAttribute(): ?string
    {
        if (!$this->weight) {
            return null;
        }

        return $this->weight . ' kg';
    }

    /**
     * Check if the product is on sale.
     */
    public function isOnSale(): bool
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    /**
     * Check if the product is available for purchase.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'active' && $this->in_stock;
    }

    /**
     * Check if the product is low in stock.
     */
    public function isLowStock(int $threshold = 10): bool
    {
        return $this->manage_stock && $this->stock_quantity <= $threshold;
    }

    /**
     * Check if the product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->manage_stock && $this->stock_quantity <= 0;
    }

    /**
     * Get a specific attribute value.
     */
    public function getAttribute(string $key): mixed
    {
        if (is_array($this->attributes) && isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return parent::getAttribute($key);
    }

    /**
     * Set a specific attribute value.
     */
    public function setAttribute(string $key, mixed $value): void
    {
        if (is_array($this->attributes)) {
            $this->attributes[$key] = $value;
        } else {
            parent::setAttribute($key, $value);
        }
    }

    /**
     * Generate a unique slug from the product name.
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
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    /**
     * Scope a query to only include products on sale.
     */
    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')
                    ->whereColumn('sale_price', '<', 'price');
    }

    /**
     * Scope a query to only include products within a price range.
     */
    public function scopePriceRange($query, float $minPrice, float $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Scope a query to search products by name or description.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to order products by price.
     */
    public function scopeOrderByPrice($query, string $direction = 'asc')
    {
        return $query->orderBy('price', $direction);
    }

    /**
     * Scope a query to order products by newest first.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to order products by popularity (featured first).
     */
    public function scopePopular($query)
    {
        return $query->orderBy('featured', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Find product by slug.
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Find product by SKU.
     */
    public static function findBySku(string $sku): ?self
    {
        return static::where('sku', $sku)->first();
    }

    /**
     * Get products with low stock.
     */
    public static function getLowStock(int $threshold = 10): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('manage_stock', true)
                    ->where('stock_quantity', '<=', $threshold)
                    ->where('stock_quantity', '>', 0)
                    ->get();
    }

    /**
     * Get out of stock products.
     */
    public static function getOutOfStock(): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('manage_stock', true)
                    ->where('stock_quantity', '<=', 0)
                    ->get();
    }

    /**
     * Update stock quantity.
     */
    public function updateStock(int $quantity): bool
    {
        if (!$this->manage_stock) {
            return false;
        }

        $this->stock_quantity = max(0, $quantity);
        $this->in_stock = $this->stock_quantity > 0;
        
        return $this->save();
    }

    /**
     * Decrease stock quantity.
     */
    public function decreaseStock(int $quantity = 1): bool
    {
        return $this->updateStock($this->stock_quantity - $quantity);
    }

    /**
     * Increase stock quantity.
     */
    public function increaseStock(int $quantity = 1): bool
    {
        return $this->updateStock($this->stock_quantity + $quantity);
    }

    /**
     * Create a new product with generated slug.
     */
    public static function createProduct(array $data): self
    {
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = static::generateSlug($data['name']);
        }

        return static::create($data);
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
            'short_description' => $this->short_description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'display_price' => $this->display_price,
            'discount_percentage' => $this->discount_percentage,
            'sku' => $this->sku,
            'stock_quantity' => $this->stock_quantity,
            'manage_stock' => $this->manage_stock,
            'in_stock' => $this->in_stock,
            'status' => $this->status,
            'featured' => $this->featured,
            'images' => $this->images,
            'primary_image' => $this->primary_image,
            'attributes' => $this->attributes,
            'weight' => $this->weight,
            'formatted_weight' => $this->formatted_weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'formatted_dimensions' => $this->formatted_dimensions,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'is_on_sale' => $this->isOnSale(),
            'is_available' => $this->isAvailable(),
            'is_low_stock' => $this->isLowStock(),
            'is_out_of_stock' => $this->isOutOfStock(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get the product's SEO-friendly URL.
     */
    public function getUrlAttribute(): string
    {
        return "/products/{$this->slug}";
    }

    /**
     * Get the product's breadcrumb data.
     */
    public function getBreadcrumbsAttribute(): array
    {
        return [
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Products', 'url' => '/products'],
            ['name' => $this->name, 'url' => $this->url],
        ];
    }
}
