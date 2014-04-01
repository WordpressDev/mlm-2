<?
class Admin_model extends Model
{
    public function deleteNews($id)
    {
        $sql = $this->db->parse('DELETE FROM `news` WHERE `id` = ?i LIMIT 1', $id);
        $res = $this->db->query($sql);

        return $res;
    }

    public function editNews($id, array $data)
    {
        $sql = $this->db->parse('
            UPDATE `news` SET `title` = ?s, `text` = ?t WHERE `id` = ?i LIMIT 1
        ', $data['title'], $data['text'], $id);
        $res = $this->db->query($sql);

        return $res;
    }
    
    public function addNews(array $data)
    {
        $sql = $this->db->parse('
            INSERT INTO `news` (`title`, `text`) VALUES (?s, ?t)
        ', $data['title'], $data['text']);
        $res = $this->db->query($sql);

        return $res;
    }
    
    public function getFaqs()
    {
        $sql = $this->db->parse('SELECT * FROM `faq` ORDER BY `id`');
        $res = $this->db->getAll($sql);
        
        return $res;
    }

    public function deleteFaq($id)
    {
        $sql = $this->db->parse('DELETE FROM `faq` WHERE `id` = ?i OR `question_id` = ?i LIMIT 2', $id, $id);
        $res = $this->db->query($sql);

        return $res;
    }

    public function editQuestion($id, $text)
    {
        $sql = $this->db->parse('
            UPDATE `faq` SET `text` = ?s WHERE `id` = ?i LIMIT 1
        ', $text, $id);
        $res = $this->db->query($sql);

        return $res;
    }

    public function editAnswer($auestionId, $text)
    {
        $sql = $this->db->parse('
            UPDATE `faq` SET `text` = ?s WHERE `question_id` = ?i LIMIT 1
        ', $text, $auestionId);
        $res = $this->db->query($sql);

        return $res;
    }

    public function addQuestion($text)
    {
        $sql = $this->db->parse('INSERT INTO `faq` (`text`) VALUES (?s)', $text);
        $res = $this->db->query($sql);

        return $this->lastInsertedId();
    }

    public function addAnswer($questionId, $text)
    {
        $sql = $this->db->parse('
            INSERT INTO `faq` (`text`, `question_id`) VALUES (?s, ?i)
        ', $text, $questionId);
        $res = $this->db->query($sql);

        return $res;
    }
    
    public function getPage($pageName)
    {
        $sql = $this->db->parse('SELECT * FROM `static` WHERE ');
        
        $res = $this->db->getAll($sql);
        
        return $res;
    }
    
    public function getStatics()
    {
        $sql = $this->db->parse('SELECT * FROM `static` ORDER BY `id`');
        $res = $this->db->getAll($sql);
        
        return $res;
    }

    public function deleteStatic($id)
    {
        $sql = $this->db->parse('DELETE FROM `static` WHERE `id` = ?i LIMIT 1', $id);
        $res = $this->db->query($sql);

        return $res;
    }

    public function editStatic($id, array $data)
    {
        $sql = $this->db->parse('
            UPDATE `static` SET `name` = ?s, `url` = ?s, `text` = ?t WHERE `id` = ?i LIMIT 1
        ', $data['name'], $data['url'], $data['text'], $id);
        $res = $this->db->query($sql);

        return $res;
    }

    public function addStatic(array $data)
    {
        $sql = $this->db->parse('
            INSERT INTO `static` (`name`, `url`, `text`) VALUES (?s, ?s, ?t)
        ', $data['name'], $data['url'], $data['text']);
        $res = $this->db->query($sql);

        return $res;
    }

    public function checkAdmin($login, $md5_password)
    {
        $sql = $this->db->parse('
            SELECT * FROM `admins` WHERE `login` = ?s AND `password` = ?s LIMIT 1
        ', $login, $md5_password);
        $res = $this->db->getRow($sql);

        return $res;
    }
}