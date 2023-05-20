<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb6d9c98d2eeb8769fe8e6af6f3070424
{
    public static $classMap = array (
        'Comet\\Angry\\Session' => __DIR__ . '/../..' . '/dbs/session.php',
        'Comet\\Angry\\User' => __DIR__ . '/../..' . '/dbs/user.php',
        'Comet\\App\\Api\\Main' => __DIR__ . '/../..' . '/app/api/main.php',
        'Comet\\App\\Api\\Sakam' => __DIR__ . '/../..' . '/app/api/sakam.php',
        'Comet\\App\\Bot\\Main' => __DIR__ . '/../..' . '/app/bot/main.php',
        'Comet\\App\\Web\\Aparat' => __DIR__ . '/../..' . '/app/web/aparat.php',
        'Comet\\App\\Web\\Auth' => __DIR__ . '/../..' . '/app/web/auth.php',
        'Comet\\App\\Web\\Config' => __DIR__ . '/../..' . '/app/web/config.php',
        'Comet\\App\\Web\\Convert' => __DIR__ . '/../..' . '/app/web/convert.php',
        'Comet\\App\\Web\\Dashbord' => __DIR__ . '/../..' . '/app/web/dashbord.php',
        'Comet\\App\\Web\\Home' => __DIR__ . '/../..' . '/app/web/home.php',
        'Comet\\App\\Web\\Instagram' => __DIR__ . '/../..' . '/app/web/instagram.php',
        'Comet\\App\\Web\\Telegram' => __DIR__ . '/../..' . '/app/web/telegram.php',
        'Comet\\App\\Web\\Upload' => __DIR__ . '/../..' . '/app/web/upload.php',
        'Comet\\App\\Web\\Youtube' => __DIR__ . '/../..' . '/app/web/youtube.php',
        'Comet\\Atom\\Angry\\Model' => __DIR__ . '/../..' . '/atom/angry/model.php',
        'Comet\\Atom\\Angry\\Mysql' => __DIR__ . '/../..' . '/atom/angry/mysql.php',
        'Comet\\Atom\\Angry\\Query' => __DIR__ . '/../..' . '/atom/angry/query.php',
        'Comet\\Atom\\Angry\\Schema' => __DIR__ . '/../..' . '/atom/angry/schema.php',
        'Comet\\Atom\\Chest\\App' => __DIR__ . '/../..' . '/atom/chest/app.php',
        'Comet\\Atom\\Chest\\Bash' => __DIR__ . '/../..' . '/atom/chest/bash.php',
        'Comet\\Atom\\Chest\\Cloud' => __DIR__ . '/../..' . '/atom/chest/cloud.php',
        'Comet\\Atom\\Chest\\Cog' => __DIR__ . '/../..' . '/atom/chest/cog.php',
        'Comet\\Atom\\Chest\\Curl' => __DIR__ . '/../..' . '/atom/chest/curl.php',
        'Comet\\Atom\\Chest\\Facade' => __DIR__ . '/../..' . '/atom/chest/facade.php',
        'Comet\\Atom\\Chest\\File' => __DIR__ . '/../..' . '/atom/chest/file.php',
        'Comet\\Atom\\Chest\\Gram' => __DIR__ . '/../..' . '/atom/chest/gram.php',
        'Comet\\Atom\\Chest\\Lesa' => __DIR__ . '/../..' . '/atom/chest/lesa.php',
        'Comet\\Atom\\Chest\\Reqs' => __DIR__ . '/../..' . '/atom/chest/reqs.php',
        'Comet\\Atom\\Chest\\Resp' => __DIR__ . '/../..' . '/atom/chest/resp.php',
        'Comet\\Atom\\Chest\\Session' => __DIR__ . '/../..' . '/atom/chest/session.php',
        'Comet\\Atom\\Chest\\View' => __DIR__ . '/../..' . '/atom/chest/view.php',
        'Comet\\Atom\\Reply\\Rebase' => __DIR__ . '/../..' . '/atom/reply/rebase.php',
        'Comet\\Atom\\Reply\\Reglass' => __DIR__ . '/../..' . '/atom/reply/reglass.php',
        'Comet\\Atom\\Reply\\ReglassPer' => __DIR__ . '/../..' . '/atom/reply/reglass_per.php',
        'Comet\\Atom\\Reply\\Reline' => __DIR__ . '/../..' . '/atom/reply/reline.php',
        'Comet\\Atom\\Route\\Api' => __DIR__ . '/../..' . '/atom/route/api.php',
        'Comet\\Atom\\Route\\Bot' => __DIR__ . '/../..' . '/atom/route/bot.php',
        'Comet\\Atom\\Route\\Web' => __DIR__ . '/../..' . '/atom/route/web.php',
        'Comet\\Face\\Atom\\Angry\\Schema' => __DIR__ . '/../..' . '/face/edbdeccfe.php',
        'Comet\\Face\\Atom\\Route\\Bot' => __DIR__ . '/../..' . '/face/dcdbddccd.php',
        'Comet\\Face\\Atom\\Route\\Web' => __DIR__ . '/../..' . '/face/cceedcbca.php',
        'Comet\\View\\Bot\\Main' => __DIR__ . '/../..' . '/view/bot/main.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitb6d9c98d2eeb8769fe8e6af6f3070424::$classMap;

        }, null, ClassLoader::class);
    }
}
