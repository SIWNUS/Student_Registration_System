<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit95c254a07b74d02ae7f211e2a1f25962
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit95c254a07b74d02ae7f211e2a1f25962::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit95c254a07b74d02ae7f211e2a1f25962::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit95c254a07b74d02ae7f211e2a1f25962::$classMap;

        }, null, ClassLoader::class);
    }
}
