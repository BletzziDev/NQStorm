<?php
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});
$app = new Application();
if($app->getView(""))
{
    $app->renderView("home",[]);
    return;
}else
{
    $app->sendHttpError(404);
    return;
}