<?
class Static_model extends Model
{
    public function getStaticPage($pageURL)
    {
        $sql = $this->db->parse('SELECT * FROM `static` WHERE `url` = ?s LIMIT 1', $pageURL);
        $res = $this->db->getRow($sql);

        return $res;
    }
}