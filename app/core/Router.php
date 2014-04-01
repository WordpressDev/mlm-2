<?
class Router
{
    public static function start($module=NULL, $data=NULL)
    {
        // Проверяем, ajax-ли это запрос.
        $ajaxRouting = ($_POST['type'] === 'ajax' || $_GET['type'] === 'ajax') ? true : NULL;

        // Разбиваем URI-запрос в массив
        $URLArray = parse_url($_SERVER['REQUEST_URI']);

        // В массив маршрутов заносим запрашиваемый путь и, если есть, get-параметры (те, которые идут после ? в URI)
        $routes = explode('/', $URLArray['path']);

        if ( !empty($URLArray['query']) )
            $routes['query'] = $URLArray['query'];

        // Убираем первую ячейку. Она всегда будет пустой
        array_shift($routes);

        if (!$module)
        {
            // Устанавливаем имя модуля и получаем имя контроллера исходя из имени модуля.
            if ($ajaxRouting)
                $module = $_POST['module'];
            else
                $module = $routes[0] ? $routes[0] : 'index';
        }

        if ($ajaxRouting && self::isAllowedAjaxPage($module) === false)
            return false;

        if (self::isAllowedPage($module) === false)
            return false;

        $module{0} = strtoupper($module{0});
        $controllerName = self::getControllerName($module);

        /* Пробуем подгрузить класс контроллера. Если нет такого, устанавливаем имся контроллера - Page404 и
         * отсылваем хэдер, что страница не найдена */
        if (Autoloader::loadClass($controllerName, $ajaxRouting) === false)
        {
            $module = 'Page404';
            $controllerName = self::getControllerName($module);
            Headers::notFound();
        }

        // Создаем контроллер и заносим в него информацию о модуле и маршрутах
        $controller = new $controllerName();

        $controller->set(
            new ControllerSetter(array(
                'module' => $module,
                'routes' => $routes,
                'ajax'   => $ajaxRouting
            ))
        );
        $controller->main();

        if ($ajaxRouting)
            return;

        // Генерируем title-страницы и подключаем шаблон с видом.
        $controller->generateTitle();
        $controller->builtIntoTemplate();
    }

    /**
     * @param void
     * @return void
     */
    public static function page404($message=NULL)
    {
        $data = $message ? array('message'=>$message) : NULL;
        Router::start('Page404', $data);
        die();
    }

    /**
     * @param $module string
     * @return string
     */
    public static function getControllerName($module)
    {
        $controllerName = $module.'_controller';
        $controllerName{0} = strtoupper($controllerName{0});

        return $controllerName;
    }

    private static function isAllowedPage($module)
    {
        if (isset($_SESSION['user']))
            return true;

        $protectedPages = Functions::getConfig('auth_pages');

        if (in_array($module, $protectedPages))
        {
            Functions::redirect('login');
            return false;
        }

        return true;
    }

    private static function isAllowedAjaxPage($module)
    {
        if (isset($_SESSION['user']))
            return true;

        $protectedPages = Functions::getConfig('auth_ajax_pages');

        if (in_array($module, $protectedPages))
        {
            Functions::redirect('login');
            return false;
        }

        return true;
    }
}
 