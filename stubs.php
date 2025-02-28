<?php

namespace Automattic\WooCommerce\Utilities 
{
    abstract class FeaturesUtil 
    {
        public static function declare_compatibility(string $feature, string $file, bool $compatible): void {}
    }
}

namespace 
{
    // @phpstan-ignore-next-line
    class CWG_Instock_Logger 
    {
        public function __construct(string $type, string $message) {}
        public function record_log(): void {}
    }

    // @phpstan-ignore-next-line
    class CWG_Instock_API 
    {
        public function mail_sent_status(int $id): bool {return true;}
        public function mail_not_sent_status(int $id): bool {return false;}
    }
}

