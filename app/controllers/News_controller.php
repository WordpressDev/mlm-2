<?
class News_controller extends Controller
{
    public function main()
    {
        $newsId = (int) $this->routes[1];

        if ($_SESSION['user']['fresh_news'] > 0)
        {
            $news = $this->model->getAllNews();
            $watchedNews =  $this->model->getWatchedNews($_SESSION['user']['id']);

            for ($i=0; $i<count($news); $i++)
            {
                $watched = false;

                for ($j=0; $j<count($watchedNews); $j++)
                {
                    if ($news[$i]['id'] == $watchedNews['id'])
                    {
                        $watched = true;
                        break;
                    }
                }

                if (!$watched)
                    $unwatchedNewsId[] = $news[$i]['id'];
            }

            if (!empty($unwatchedNewsId))
            {
                $this->model->addWatchedNews($_SESSION['user']['id'], $unwatchedNewsId);
                $_SESSION['user']['fresh_news'] = 0;
            }
        }

        $news = $news ? $news : $this->model->getAllNews();

        if ($newsId)
             return $this->showOneNew($newsId);
        $this->view['news'] = $news;
    }

    private function showOneNew($newsId)
    {
        $oneArticle = $this->model->getOneArticle($newsId);

        if (!empty($oneArticle))
        {
            $this->view['one'] = $oneArticle;
        } else
            Router::page404();
    }
}