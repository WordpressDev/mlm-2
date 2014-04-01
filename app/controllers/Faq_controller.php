<?
class Faq_controller extends Controller
{
    public function main()
    {
        $data = $this->model->getFaqs();

        if ($data)
            $data = $this->transformFaqs($data);

        $this->view['data'] = $data;
    }
}