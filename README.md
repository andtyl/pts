Get operator name of swedish phone number via PTS API
------------------------------------------------------

# Install

Install via Composer

```json
{
    "require": {
        "andtyl/pts": "~1.0"
    }   
}
```

# Example

```php
$pts = new PTS\PTS
var_dump($pts->getOperatorByNumber('0700404040'));
```

# Links

http://e-tjanster.pts.se/
