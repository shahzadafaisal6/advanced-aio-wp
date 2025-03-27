# Autoloader Implementation

## Class Map Generator
```php
protected function generate_classmap() {
    return [
        'Core\\Bootstrap' => '/core/class-bootstrap.php',
        'Modules\\Text\\OpenAI' => '/modules/text/class-openai.php'
    ];
}
```

## Usage
```php
$loader = new \AdvancedAIO_WP\Core\Autoloader();
$loader->register();
```
