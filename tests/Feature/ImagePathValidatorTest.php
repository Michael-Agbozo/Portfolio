<?php

namespace Tests\Feature;

use App\Support\ImagePathValidator;
use Tests\TestCase;

class ImagePathValidatorTest extends TestCase
{
    public function test_image_paths_must_be_http_urls_or_safe_storage_paths(): void
    {
        $this->assertTrue(ImagePathValidator::isValid('https://example.com/image.jpg'));
        $this->assertTrue(ImagePathValidator::isValid('http://example.com/image.jpg'));
        $this->assertTrue(ImagePathValidator::isValid('/storage/projects/image.jpg'));

        $this->assertFalse(ImagePathValidator::isValid('ftp://example.com/image.jpg'));
        $this->assertFalse(ImagePathValidator::isValid('javascript:alert(1)'));
        $this->assertFalse(ImagePathValidator::isValid('/storage/../.env'));
    }
}
