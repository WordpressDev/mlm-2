<?
class News_model extends Model
{
    public function getAllNews()
    {
        $sql = $this->db->parse('SELECT * FROM `news` ORDER BY `id`');
        $res = $this->db->getAll($sql);

        return $res;
    }

    public function getOneArticle($id)
    {
        $sql = $this->db->parse('SELECT * FROM `news` WHERE `id` = ?i LIMIT 1', $id);
        $res = $this->db->getRow($sql);

        return $res;
    }

    public function getWatchedNews($userId)
    {
        $sql = $this->db->parse('SELECT `news_id` FROM `watched_news` WHERE `user_id` = ?i ORDER BY `news_id`', $userId);
        $res = $this->db->getCol($sql);

        return $res;
    }

    public function addWatchedNews($userId, array $watched)
    {
        $sql = $this->db->parse('INSERT INTO `watched_news` (`user_id`, `news_id`) VALUES');

        for ($i=0; $i<count($watched); $i++)
        {
            $sqlParts[] = $this->db->parse(' (?i, ?i)', $userId, $watched[$i]);
        }

        $sqlPart = implode(',', $sqlParts);
        $sql .= $sqlPart;
        $res = $this->db->query($sql);
        
        return $res;
    }
}