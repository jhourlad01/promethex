# Partial Views System

The Framework now supports a simplified partial views system with all components in a single global directory.

## Directory Structure

```
frontend/src/views/
├── partials/           # All reusable components
│   ├── breadcrumb.php
│   ├── categories-badges.php
│   ├── categories-grid.php
│   ├── category-breadcrumbs.php
│   ├── category-header.php
│   ├── category-products.php
│   ├── category-styles.php
│   ├── home-hero.php
│   ├── home-styles.php
│   ├── page-header.php
│   ├── product-breadcrumbs.php
│   ├── product-card.php
│   ├── product-gallery.php
│   └── products-grid.php
├── home/
│   └── index.php
├── category/
│   ├── index.php
│   └── show.php
├── product/
│   └── show.php
└── auth/
    └── index.php
```

## Usage

Use `\Framework\View::partial()` for all components:

```php
<?= \Framework\View::partial('home-hero') ?>
<?= \Framework\View::partial('home-styles') ?>
<?= \Framework\View::partial('category-breadcrumbs') ?>
<?= \Framework\View::partial('category-header') ?>
<?= \Framework\View::partial('categories-grid') ?>
<?= \Framework\View::partial('category-styles') ?>
<?= \Framework\View::partial('product-breadcrumbs') ?>
<?= \Framework\View::partial('product-gallery') ?>
<?= \Framework\View::partial('breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
<?= \Framework\View::partial('page-header', [
    'title' => 'Page Title',
    'subtitle' => 'Optional subtitle',
    'badge' => 'Optional badge text'
]) ?>
<?= \Framework\View::partial('categories-badges', ['categories' => $allCategories]) ?>
<?= \Framework\View::partial('products-grid', ['products' => $featuredProducts]) ?>
```

## Benefits

1. **Simplicity**: Single directory for all partials
2. **Reusability**: Components can be used across multiple pages
3. **Maintainability**: Changes to components update everywhere they're used
4. **Organization**: Clear naming convention with prefixes
5. **Consistency**: Standardized UI components
6. **Modularity**: Easy to add/remove page sections

## Naming Convention

- **Global components**: `breadcrumb.php`, `page-header.php`, `product-card.php`, etc.
- **Page-specific components**: `{page}-{component}.php` (e.g., `home-hero.php`, `category-header.php`)

## Creating New Partials

1. Create in `frontend/src/views/partials/`
2. Use descriptive names with prefixes for page-specific components
3. Pass data using the second parameter
4. Access data using `extract()` to make data available as variables

## Best Practices

1. Keep partials focused on single responsibilities
2. Use descriptive names for partials
3. Pass only necessary data to partials
4. Document complex partials with comments
5. Use consistent naming conventions with prefixes