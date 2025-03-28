# Technical Specifications

## System Requirements
- PHP 7.4+ (8.1+ recommended)
- Redis 6.2+
- WordPress 6.4+

## Database Schema
```sql
CREATE TABLE wp_aio_cache (
  cache_key VARCHAR(255) PRIMARY KEY,
  cache_value LONGTEXT,
  expires DATETIME
);
```

## Rate Limits
| Module       | Requests/Hour |
|--------------|---------------|
| Text         | 5,000         |
| Image        | 2,000         |
| Video        | 500           |
