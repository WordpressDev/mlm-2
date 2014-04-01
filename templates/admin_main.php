<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <title><?=$this->title?></title>
</head>
<body>
<? if (isset($_SESSION['admin'])): ?>
    <? require_once(ROOT."/templates/admin_menu.php"); ?>
<? endif ?>
<? require_once(ROOT."/app/views/{$viewName}"); ?>
</body>
</html>