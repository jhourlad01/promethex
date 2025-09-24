<?php

/**
 * Product Images Download Script
 * Downloads product images from Unsplash to local storage
 */

$images = [
    'premium-headphones-1.jpg' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop',
    'premium-headphones-2.jpg' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=400&h=300&fit=crop',
    'smart-watch-1.jpg' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
    'smart-watch-2.jpg' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=400&h=300&fit=crop',
    'bluetooth-speaker-1.jpg' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop',
    'bluetooth-speaker-2.jpg' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400&h=300&fit=crop',
    'gaming-keyboard-1.jpg' => 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?w=400&h=300&fit=crop',
    'gaming-keyboard-2.jpg' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=300&fit=crop',
    'usb-hub-1.jpg' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop',
    'usb-hub-2.jpg' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=300&fit=crop',
    'gaming-mouse-1.jpg' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&h=300&fit=crop',
    'gaming-mouse-2.jpg' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=400&h=300&fit=crop',
];

$imagesDir = __DIR__ . '/../public/images/products';

echo "Downloading product images...\n";
echo "Target directory: {$imagesDir}\n\n";

// Create directory if it doesn't exist
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
    echo "Created directory: {$imagesDir}\n";
}

$downloaded = 0;
$skipped = 0;
$errors = 0;

foreach ($images as $filename => $url) {
    $filepath = $imagesDir . '/' . $filename;
    
    // Skip if file already exists
    if (file_exists($filepath)) {
        echo "⏭️  Skipped: {$filename} (already exists)\n";
        $skipped++;
        continue;
    }
    
    echo "⬇️  Downloading: {$filename}... ";
    
    // Download the image
    $imageData = @file_get_contents($url);
    
    if ($imageData === false) {
        echo "❌ Failed\n";
        $errors++;
        continue;
    }
    
    // Save the image
    $result = @file_put_contents($filepath, $imageData);
    
    if ($result === false) {
        echo "❌ Failed to save\n";
        $errors++;
        continue;
    }
    
    echo "✅ Success (" . number_format(strlen($imageData)) . " bytes)\n";
    $downloaded++;
}

echo "\n";
echo "📊 Download Summary:\n";
echo "   Downloaded: {$downloaded}\n";
echo "   Skipped: {$skipped}\n";
echo "   Errors: {$errors}\n";
echo "   Total: " . count($images) . "\n";

if ($downloaded > 0 || $skipped > 0) {
    echo "\n✅ Images are ready in: {$imagesDir}\n";
    echo "You can now update the ProductSeeder to use local images.\n";
}
