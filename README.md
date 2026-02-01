# Identicon

A lightweight PHP library for generating user avatars based on username.

## Installation

```bash
composer require lantern-lighthouse/identicon
```

## Usage

### Image Generating

```php
use Identicon\Identicon;

// Simple image generation
Identicon::generateFromString("Bub fix");

// Imgage generation with more parameters (..., image size, inner grid size/level of detail)
Identicon::generateFromString("Bub fix", 64, 2);
```

### Avatar Rendering

```php
// Generate 200x200 image with level of detail = 5
Identicon::outputImage("Bub fix");
```

## Requirements

- PHP 8.1 or higher

## License

GPL-3.0 License
