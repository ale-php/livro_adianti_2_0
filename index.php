<?php
require_once 'init.php';

new TSession;

ob_start();

if(TSession::getValue('user_login')){

$theme = 'Agenda';

}else{

$theme = 'Login';

}

$content  = file_get_contents("app/templates/{$theme}/layout.html");
$content  = str_replace('{LIBRARIES}', file_get_contents("app/templates/{$theme}/libraries.html"), $content);
$content  = str_replace('{class}', isset($_REQUEST['class']) ? $_REQUEST['class'] : '', $content);
$content  = str_replace('{template}', $theme, $content);
$css      = TPage::getLoadedCSS();
$js       = TPage::getLoadedJS();
$content  = str_replace('{HEAD}', $css.$js, $content);

echo $content;

if (isset($_REQUEST['class']))
{
    $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : NULL;
    AdiantiCoreApplication::loadPage($_REQUEST['class'], $method, $_REQUEST);
}
else{
  AdiantiCoreApplication::loadPage('Home');
}