<?
abstract class Controller
{
    protected $module;
    protected $model;
    protected $view;
    protected $routes;
    public $title;

    public function set(ControllerSetter $obj)
    {
        $this->module = $obj->module;
        $this->model = $obj->model;
        $this->routes = $obj->routes;
        $this->view = $obj->view;
    }

    abstract public function main();

    public function getData()
    {
        $array['view'] = $this->view;

        return $array;
    }
    
    public function builtIntoTemplate()
    {
        $viewName = $this->module.'.php';
        $data = $this->getData();
        $view = $data['view'];

        if ($this->module == 'Admin')
            require_once(ROOT."/templates/admin_main.php");
        else
            require_once(ROOT."/templates/main.php");
    }

    public function generateTitle()
    {
        $this->title = '';
    }

    public function transformData($data)
    {
        $data['phone'] = str_replace('+', '', $data['phone']);

        return $data;
    }

    protected function transformFaqs(array $data)
    {
        for ($i=0; $i<count($data); $i++)
        {
            $questionId = $data[$i]['question_id'];
            $id = $data[$i]['id'];

            if ($questionId == 0)
                $result[$id]['question'] = $data[$i];
            else
                $result[$questionId]['answer'] = $data[$i];
        }

        rsort($result);
        return $result;
    }

}
 