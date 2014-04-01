<?
class Admin_controller extends Controller
{
    public function main()
    {
        $action = $this->routes[1];

        if ($action != 'login' && empty($_SESSION['admin']) )
            Functions::redirect('admin/login');

        if (!$action)
            $action = 'index';

        $actionName = $action.'Action';

        if ($action && method_exists($this, $actionName))
            return $this->$actionName();
    }
    
    private function indexAction()
    {
        $this->view['template_name'] = 'index';
    }

    private function newsAction()
    {
        if ($this->routes[2] == 'delete' && $newsId = $this->routes[3])
        {
            $this->model->deleteNews($newsId);
            Functions::redirect('admin/news');
        } elseif ($this->routes[2] == 'edit' && $newsId = $this->routes[3]) {
            $this->model->editNews($newsId, array(
                'text' => $_POST['text'],
                'title' => $_POST['title'],
            ));
            Functions::redirect('admin/news');
        } elseif ($this->routes[2] == 'new'){
            $this->model->addNews(array(
                'text' => $_POST['text'],
                'title' => $_POST['title'],
            ));
            Functions::redirect('admin/news');
        } else {
            $newsModel = new News_model();
            $news = $newsModel->getAllNews();

            $this->view['template_name'] = 'news';
            $this->view['news'] = $news;
        }
    }
    
    private function faqAction()
    {
        if ($this->routes[2] == 'delete' && $faqId = $this->routes[3])
        {
            $this->model->deleteFaq($faqId);
            Functions::redirect('admin/faq');
        } elseif ($this->routes[2] == 'edit' && $faqId = $this->routes[3]) {
            $this->model->editQuestion($faqId, $_POST['question']);
            $this->model->editAnswer($faqId, $_POST['answer']);
            Functions::redirect('admin/faq');
        } elseif ($this->routes[2] == 'new'){
            $questionId = $this->model->addQuestion($_POST['question']);
            $this->model->addAnswer($questionId, $_POST['answer']);
            Functions::redirect('admin/faq');
        } else {
            $faqs = $this->model->getFaqs();
            $faqs = $this->transformFaqs($faqs);

            $this->view['template_name'] = 'faq';
            $this->view['data'] = $faqs;
        }
    }
    
    private function staticAction()
    {
        if ($this->routes[2] == 'delete' && $staticId = $this->routes[3])
        {
            $this->model->deleteStatic($staticId);
            Functions::redirect('admin/static');
        } elseif ($this->routes[2] == 'edit' && $staticId = $this->routes[3]) {
            $this->model->editStatic($staticId, array (
                'name' => $_POST['name'],
                'url' => $_POST['url'],
                'text' => $_POST['text'],
            ));
            Functions::redirect('admin/static');
        } elseif ($this->routes[2] == 'new') {
            $this->model->addStatic(array (
                'name' => $_POST['name'],
                'url' => $_POST['url'],
                'text' => $_POST['text'],
            ));
            Functions::redirect('admin/static');
        } else {
            $statics = $this->model->getStatics();

            $this->view['template_name'] = 'static';
            $this->view['data'] = $statics;
        }
    }
    
    private function loginAction()
    {
        if ($_POST['login'] && $_POST['password'])
        {
            $admin = $this->model->checkAdmin($_POST['login'], md5($_POST['password']));

            if (empty($admin))
                $error = 'Неверный логин или пароль!';
            else {
                $_SESSION['admin'] = $admin;
                Functions::redirect('admin');
            }
        }
        $this->view['template_name'] = 'login';
        $this->view['error'] = $error;
    }
}