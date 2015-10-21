<?php
require_once 'init.php';


$uri = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

new TSession;

if(TSession::getValue('user_login')) {
    $template = 'theme1'; // caso ja estiver logado
}else{
    $template = 'theme1'; // caso não esteja
}


$content  = file_get_contents("app/templates/{$template}/layout.html");
//$content  = TApplicationTranslator::translateTemplate($content);
$content  = str_replace('{LIBRARIES}', file_get_contents("app/templates/{$template}/libraries.html"), $content);
$content  = str_replace('{URI}', $uri, $content);
$content  = str_replace('{class}', isset($_REQUEST['class']) ? $_REQUEST['class'] : '', $content);
$content  = str_replace('{template}', $template, $content);
$css      = TPage::getLoadedCSS();
$js       = TPage::getLoadedJS();
$content  = str_replace('{HEAD}', $css.$js, $content);

if (isset($_REQUEST['class']))
{



        $url = http_build_query($_REQUEST);
        $content = str_replace('//#javascript_placeholder#', "__adianti_load_page('engine.php?{$url}');", $content);


}else{

    $url = 'class=Home';

    $content = str_replace('//#javascript_placeholder#', "__adianti_load_page('engine.php?{$url}');", $content);

}
echo $content;
?>