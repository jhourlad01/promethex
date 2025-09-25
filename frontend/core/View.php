<?php

namespace Framework;

class View
{
    private static string $viewPath = 'src/views/';
    private static string $layoutPath = 'src/layouts/';
    private static array $sharedData = [];
    private static ?string $defaultLayout = 'layout';
    private static array $layoutMap = [];

    public static function setViewPath(string $path): void
    {
        self::$viewPath = rtrim($path, '/') . '/';
    }

    public static function getViewPath(): string
    {
        return self::$viewPath;
    }

    public static function setLayoutPath(string $path): void
    {
        self::$layoutPath = rtrim($path, '/') . '/';
    }

    public static function getLayoutPath(): string
    {
        return self::$layoutPath;
    }

    public static function make(string $template, array $data = [], string $layout = null): string
    {
        if (!app()->hasFeature('templates')) {
            throw new \RuntimeException('Template feature is not enabled');
        }

        // Merge shared data
        $data = array_merge(self::$sharedData, $data);

        // Extract data to variables
        extract($data);
        
        // Start output buffering for view content
        ob_start();
        
        $viewPath = self::$viewPath . $template . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View template '{$template}' not found");
        }
        
        include $viewPath;
        $content = ob_get_clean();
        
        // Determine layout to use
        $layoutToUse = self::determineLayout($template, $layout);
        
        // If no layout specified, return content directly
        if (!$layoutToUse) {
            return $content;
        }
        
        // Include layout with content
        $layoutPath = self::$layoutPath . $layoutToUse . '.php';
        if (!file_exists($layoutPath)) {
            throw new \RuntimeException("Layout template '{$layoutToUse}' not found at {$layoutPath}");
        }
        
        // Start output buffering for final layout
        ob_start();
        include $layoutPath;
        return ob_get_clean();
    }

    private static function determineLayout(string $template, ?string $explicitLayout): ?string
    {
        // 1. Explicit layout takes priority
        if ($explicitLayout !== null) {
            return $explicitLayout;
        }
        
        // 2. Check if template has a specific layout mapping
        if (isset(self::$layoutMap[$template])) {
            return self::$layoutMap[$template];
        }
        
        // 3. Use default layout
        return self::$defaultLayout;
    }

    public static function share(string $key, $value): void
    {
        self::$sharedData[$key] = $value;
    }

    public static function shareMultiple(array $data): void
    {
        self::$sharedData = array_merge(self::$sharedData, $data);
    }

    public static function exists(string $template): bool
    {
        $viewPath = self::$viewPath . $template . '.php';
        return file_exists($viewPath);
    }

    public static function render(string $template, array $data = [], string $layout = null): Response
    {
        $content = self::make($template, $data, $layout);
        return new Response($content);
    }

    public static function withLayout(string $template, array $data = [], string $layout = null): Response
    {
        return self::render($template, $data, $layout);
    }

    public static function setDefaultLayout(string $layout): void
    {
        self::$defaultLayout = $layout;
    }

    public static function setLayoutForTemplate(string $template, string $layout): void
    {
        self::$layoutMap[$template] = $layout;
    }

    public static function setLayoutMap(array $layoutMap): void
    {
        self::$layoutMap = array_merge(self::$layoutMap, $layoutMap);
    }

    public static function withoutLayout(string $template, array $data = []): Response
    {
        return self::render($template, $data, null);
    }
    
    /**
     * Include a partial view - supports both global and page-specific partials
     * Usage:
     * - partial('breadcrumb', $data) - looks in partials/breadcrumb.php
     * - partial('product', 'gallery', $data) - looks in product/partials/gallery.php
     */
    public static function partial(string $partial, $dataOrPage = [], $partialNameOrData = null): string
    {
        // Determine if this is a page-specific partial or global partial
        if ($partialNameOrData !== null && is_array($partialNameOrData) && is_string($dataOrPage)) {
            // This is a page-specific partial with data: partial('product', 'gallery', $data)
            $page = $partial;
            $partial = $dataOrPage;
            $data = $partialNameOrData;
        } elseif ($partialNameOrData !== null && is_string($partialNameOrData)) {
            // This is a page-specific partial without data: partial('product', 'gallery')
            $page = $partial;
            $partial = $partialNameOrData;
            $data = [];
        } elseif ($partialNameOrData === null && is_string($dataOrPage) && !is_array($dataOrPage)) {
            // This is a page-specific partial with 2 params: partial('home', 'hero')
            $page = $partial;
            $partial = $dataOrPage;
            $data = [];
        } else {
            // This is a global partial: partial('breadcrumb', $data)
            $page = null;
            $data = is_array($dataOrPage) ? $dataOrPage : [];
        }
        
        // Merge shared data
        $data = array_merge(self::$sharedData, $data);
        
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Determine the partial path
        if ($page !== null) {
            // Page-specific partial
            $partialPath = self::$viewPath . $page . '/partials/' . $partial . '.php';
            if (!file_exists($partialPath)) {
                throw new \RuntimeException("Page partial '{$page}/{$partial}' not found at {$partialPath}");
            }
        } else {
            // Global partial
            $partialPath = self::$viewPath . 'partials/' . $partial . '.php';
            if (!file_exists($partialPath)) {
                throw new \RuntimeException("Partial view '{$partial}' not found at {$partialPath}");
            }
        }
        
        include $partialPath;
        return ob_get_clean();
    }
}
