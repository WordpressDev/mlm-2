<?
class ControllerSetter
{
    public $module;
    public $model;
    public $view;
    public $routes;

    public function __construct(array $settings)
    {
        $this->setModule($settings['module']);
        $this->createModel($settings['module'], $settings['ajax']);
        $this->setRoutes($settings['routes']);
    }

    private function setModule($module)
    {
        if ($module)
            $this->module = $module;
        else {
            try {
                throw new Exception('Не передано имя модуля');
            } catch (Exception $e) {
                echo $e->getMessage();
                echo '<pre>'; print_r($e->getTrace()); echo '</pre>'; // @todo Сделать нормальный вывод Trace
                die();
            }
        }
    }

    private function createModel($modelName, $ajaxRequest)
    {
        $modelName = $modelName.'_model';

        if ($ajaxRequest && Autoloader::loadClass($modelName, $ajaxRequest))
        {
            $this->model = new $modelName();

            return true;
        } elseif ( Autoloader::loadClass($modelName) ) {
            $this->model = new $modelName();

            return true;
        }

        return false;
    }

    private function setRoutes($routes)
    {
        if ($routes)
            $this->routes = $routes;
        else
            try {
                throw new Exception('Не передан массив маршрутов (routes)');
            } catch (Exception $e) {
                echo $e->getMessage();
                echo '<pre>'; print_r($e->getTrace()); echo '</pre>'; // @todo Сделать нормальный вывод Trace
                die();
            }

    }
}
 