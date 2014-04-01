<?
class Static_controller extends Controller
{
    public function main()
    {
        $pageURL = $this->routes[1];

        if (!$pageURL)
            Router::page404();

        $pageData = $this->model->getStaticPage($pageURL);

        if (!$pageData)
            Router::page404();

        $this->view['data'] = $pageData;
    }
}