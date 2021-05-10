<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit38e210ef4cb9bb1c889b1f6326e41a08
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit38e210ef4cb9bb1c889b1f6326e41a08::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit38e210ef4cb9bb1c889b1f6326e41a08::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
