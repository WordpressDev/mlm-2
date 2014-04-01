<?
class ActivateUser_model extends Model
{
    public function getUserByPhone($phone)
    {
        $sql = $this->db->parse('SELECT * FROM `users` WHERE `phone` = ?i LIMIT 1', $phone);
        $res = $this->db->getRow($sql);

        return $res;
    }

    public function checkCode($userId, $code)
    {
        $sql = $this->db->parse('
            SELECT * FROM `activation_codes` WHERE `user_id` = ?i AND `code` = ?i LIMIT 1
        ', $userId, $code);
        $res = $this->db->getRow($sql);

        return $res;
    }

    public function activateUser($userId)
    {
        $sql = $this->db->parse('UPDATE `users` SET `active` = 1 WHERE `id` = ?i LIMIT 1', $userId);
        $res = $this->db->query($sql);

        return $res;
    }

    public function deleteCode($userId, $code)
    {
        $sql = $this->db->parse('
            DELETE FROM `activation_codes` WHERE `user_id` = ?i AND `code` = ?i LIMIT 1
        ', $userId, $code);
        $res = $this->db->query($sql);

        return $res;
    }

    public function getCode($userId)
    {
        $sql = $this->db->parse('
            SELECT `code` FROM `activation_codes` WHERE `user_id` = ?i LIMIT 1
        ', $userId);
        $res = $this->db->getOne($sql);

        return $res;
    }
}