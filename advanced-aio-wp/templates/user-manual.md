# User Manual

## Getting Started
1. **Installation**:  
   ```bash
   wp plugin install advanced-aio-wp.zip --activate
   ```

2. **Configuration**:  
   Navigate to `Settings → AI Suite` and enter your API keys.

## Shortcodes
### Text Generation
```html
[aio_text_generator context="blog-post"]
```

### Image Generator
```html
[aio_image_generator style="photorealistic"]
```

## Troubleshooting
| Error Code | Solution                          |
|------------|-----------------------------------|
| 403        | Check license key validity        |
| 429        | Reduce request frequency          |
| 500        | Enable fallback mode in settings  |
