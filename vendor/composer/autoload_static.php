<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit02d9f138cf665a986fa878090f74e78d
{
    public static $files = array (
        '7e9bd612cc444b3eed788ebbe46263a0' => __DIR__ . '/..' . '/laminas/laminas-zendframework-bridge/src/autoload.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        '383eaff206634a77a1be54e64e6459c7' => __DIR__ . '/..' . '/sabre/uri/lib/functions.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '3569eecfeed3bcf0bad3c998a494ecb8' => __DIR__ . '/..' . '/sabre/xml/lib/Deserializer/functions.php',
        '93aa591bc4ca510c520999e34229ee79' => __DIR__ . '/..' . '/sabre/xml/lib/Serializer/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Contracts\\Service\\' => 26,
            'Symfony\\Contracts\\Cache\\' => 24,
            'Symfony\\Component\\Yaml\\' => 23,
            'Symfony\\Component\\VarExporter\\' => 30,
            'Symfony\\Component\\ExpressionLanguage\\' => 37,
            'Symfony\\Component\\Cache\\' => 24,
            'Sabre\\Xml\\' => 10,
            'Sabre\\Uri\\' => 10,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Container\\' => 14,
            'Psr\\Cache\\' => 10,
        ),
        'N' => 
        array (
            'Novaxis\\' => 8,
        ),
        'L' => 
        array (
            'Laminas\\ZendFrameworkBridge\\' => 28,
            'Laminas\\Stdlib\\' => 15,
            'Laminas\\Hydrator\\' => 17,
            'Laminas\\Config\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Contracts\\Service\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/service-contracts',
        ),
        'Symfony\\Contracts\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/cache-contracts',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Symfony\\Component\\VarExporter\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/var-exporter',
        ),
        'Symfony\\Component\\ExpressionLanguage\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/expression-language',
        ),
        'Symfony\\Component\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/cache',
        ),
        'Sabre\\Xml\\' => 
        array (
            0 => __DIR__ . '/..' . '/sabre/xml/lib',
        ),
        'Sabre\\Uri\\' => 
        array (
            0 => __DIR__ . '/..' . '/sabre/uri/lib',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Psr\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/cache/src',
        ),
        'Novaxis\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Laminas\\ZendFrameworkBridge\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-zendframework-bridge/src',
        ),
        'Laminas\\Stdlib\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-stdlib/src',
        ),
        'Laminas\\Hydrator\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-hydrator/src',
        ),
        'Laminas\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-config/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        '�' => __DIR__ . '/..' . '/symfony/cache/Traits/ValueWrapper.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit02d9f138cf665a986fa878090f74e78d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit02d9f138cf665a986fa878090f74e78d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit02d9f138cf665a986fa878090f74e78d::$classMap;

        }, null, ClassLoader::class);
    }
}
