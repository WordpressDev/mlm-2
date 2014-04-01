<?
class Register_controller extends Controller
{
    public function main()
    {
        if (isset($_SESSION['user']))
            Functions::redirect();
        if (isset($_GET['id']))
            $this->view['sponsor'] = $this->cutPhone($_GET['id']);
    }

    private function cutPhone($id)
    {
        return $id;
    }
}