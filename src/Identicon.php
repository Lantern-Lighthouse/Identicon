<?php

namespace Identicon;

class Identicon
{
    /**
     * Generate rectangular avatar based on input text
     * 
     * @param string $string Username or something else to generate from 
     * @param int $size Length of a side
     * @param int $gridSize Density/detail of an avatar
     * @return bool|\GdImage|resource
     */
    public static function generateFromString(string $string, int $size = 200, int $gridSize = 5): bool|\GdImage|resource
    {
        $hash = md5($string);

        // Create image
        $image = imagecreate($size, $size);

        // Extract color from hash
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));

        // Allocate colors
        imagecolorallocate($image, 240, 240, 240);
        $foregroundColor = imagecolorallocate($image, $r, $g, $b);

        // Calculate cell size
        $cellSize = $size / $gridSize;

        // Generate pattern from hash
        for ($y = 0; $y < $gridSize; $y++) {
            for ($x = 0; $x < ceil($gridSize / 2); $x++) {
                $index = $y * ceil($gridSize / 2) + $x;
                $byte = hexdec(substr($hash, $index % 32, 1));

                if ($byte % 2 === 0) {
                    // Draw rectangle
                    $x1 = $x * $cellSize;
                    $y1 = $y * $cellSize;
                    $x2 = $x1 + $cellSize;
                    $y2 = $y1 + $cellSize;

                    imagefilledrectangle($image, $x1, $y1, $x2, $y2, $foregroundColor);

                    // Mirror horizontally
                    if ($x < floor($gridSize / 2)) {
                        $mirrorX = ($gridSize - 1 - $x) * $cellSize;
                        imagefilledrectangle($image, $mirrorX, $y1, $mirrorX + $cellSize, $y2, $foregroundColor);
                    }
                }
            }
        }

        return $image;
    }

    /**
     * Generate an avatar and display it
     * 
     * @param mixed $string Username or something else to generate the avatar from
     * @return void
     */
    public static function outputImage($string): void
    {
        $image = self::generateFromString($string);
        header('Content-Type: image/png');
        imagepng($image);
    }
}
