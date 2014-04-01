<?
class Faq_model extends Model
{
    public function getFaqs()
    {
        $sql = $this->db->parse('SELECT * FROM `faq` ORDER BY `id`');
        $res = $this->db->getAll($sql);
        
        return $res;
    }
}