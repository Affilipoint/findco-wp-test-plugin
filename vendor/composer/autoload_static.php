<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5b40fb9db5f5dedfc023d4212ed1e40c
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Jamm\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Jamm\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/Classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5b40fb9db5f5dedfc023d4212ed1e40c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5b40fb9db5f5dedfc023d4212ed1e40c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5b40fb9db5f5dedfc023d4212ed1e40c::$classMap;

        }, null, ClassLoader::class);
    }
}
