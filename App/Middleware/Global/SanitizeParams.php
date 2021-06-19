<?php

namespace App\Middleware\Global;

use App\Middleware\Contract\MiddlewareInterface;

class SanitizeParams implements MiddlewareInterface
{
    public function handle()
    {
        $this->sanitizeGetParams();
        $this->sanitizePostParams();
    }
    public function sanitizeGetParams()
    {
        foreach ($_GET as $key => $value) {
            $_GET[$key] = xss_clean($value);
        }
    }
    public function sanitizePostParams()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = xss_clean($value);
        }
    }
}
