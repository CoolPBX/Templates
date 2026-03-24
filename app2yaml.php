<?php
$short = "";
$long = ['file:','directory:','type:', 'debug'];
$o = getopt($short, $long);

if (isset($o['debug']))
    var_dump($o);

if (isset($o['file']) && isset($o['directory']))
    die('the parameters --file or --directory can not coexist.'.PHP_EOL);

if (!isset($o['type']))
    die('you must specify --type with one of the following options: vendors, permissions, settings, menu.'.PHP_EOL);

if (isset($o['file'])){
    $x = 0;
    require_once($o['file']);

    if (isset($o['debug'])){
        print_r($apps);
        print_r($vendors);
    }
}
elseif(isset($o['directory'])){
    $files = glob($o['directory'].'/{core,app}/*/app_config.php', \GLOB_BRACE);
    if (isset($o['debug']))
        var_dump($files);

    $x = 0;
    foreach ($files as $file){
        require_once($file);
        $x++;
    }

    $files = glob($o['directory'].'/{core,app}/*/app_menu.php', \GLOB_BRACE);
    if (isset($o['debug']))
        var_dump($files);

    $x = 0;
    foreach ($files as $file){
        require_once($file);
        $x++;
    }

    if (isset($o['debug'])){
        print_r($apps);
        print_r($vendors);
    }
}
else
    die('--file or --directory are missing.'.PHP_EOL);

$yaml = '';
switch ($o['type']){
    case 'vendors':
        if (isset($vendors) && is_array($vendors)){
            $yaml = yaml_emit($vendors);
        }
        break;
    case 'permissions':
        $permissions = [];
        if (isset($apps[0]) && is_array($apps[0])){
            foreach ($apps as $app){
                if (is_array($app['permissions']))
                    foreach ($app['permissions'] as $permission)
                        $permissions[] = $permission;
            }
        }

        if (isset($o['debug']))
            print_r($permissions);

        $yaml = yaml_emit($permissions);
        break;
    case 'settings':
        $settings = [];
        if (isset($apps[0]) && is_array($apps[0])){
            foreach ($apps as $app){
                if (is_array($app['default_settings']))
                    foreach ($app['default_settings'] as $setting)
                        $settings[] = $setting;
            }
        }

        if (isset($o['debug']))
            print_r($settings);

        $yaml = yaml_emit($settings);
        break;
    case 'menu':
        $menus = [];
        if (isset($apps[0]) && is_array($apps[0])){
            foreach ($apps as $app){
                if (is_array($app['menu']))
                    foreach ($app['menu'] as $menu)
                        $menus[] = $menu;
            }
        }

        if (isset($o['debug']))
            print_r($menus);

        $yaml = yaml_emit($menus);
        break;
    default:
        die('you must specify --type with one of the following options: vendors, permissions, settings, menu.'.PHP_EOL);
}

echo $yaml;
