<?
class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = SafeMySQL::getInstance();
    }

    protected function lastInsertedId()
    {
        return $this->db->insertId();
    }

    public function getProjectIndex($userId, $projectId)
    {
        $sql = $this->db->parse('SELECT COUNT(`id`) FROM `briefs` WHERE `id` < ?i AND `user_id` = ?i', $projectId, $userId);
        $res = $this->db->getOne($sql) + 1;

        return $res;
    }

    public function getPermission($userId, $projectId)
    {
        $sql = $this->db->parse('
            SELECT `briefs`.`id`
            FROM `briefs` INNER JOIN `users` ON `briefs`.`user_id` = `users`.`id`
            WHERE `users`.`id` = ?i AND `briefs`.`id` = ?i AND `briefs`.`active` = 1
            LIMIT 1
        ', $userId, $projectId);
        $res = $this->db->getOne($sql);

        return $res;
    }
}