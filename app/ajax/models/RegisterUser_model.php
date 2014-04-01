<?
class RegisterUser_model extends Model
{
    public function registerUser(array $data)
    {
        $sql = $this->db->parse('
            INSERT INTO `users`
            (`phone`, `password`, `name`, `email`, `sponsor_id`)
            VALUES
            (?i, ?s, ?s, ?s, ?s)
        ', $data['phone'], md5($data['password']), $data['name'], $data['email'], $data['sponsor_id']);
        $res = $this->db->query($sql);

        return $this->lastInsertedId();
    }

    public function getSponsorId($id)
    {
        $sql = $this->db->parse('SELECT `id` FROM `users` WHERE `id` = ?i LIMIT 1', $id);
        $res = $this->db->getOne($sql);

        return $res;
    }

    public function checkCodeUnique($code)
    {
        $sql = $this->db->parse('
            SELECT `user_id` FROM `activation_codes` WHERE `code` = ?i LIMIT 1
        ', $code);
        $res = $this->db->getOne($sql);

        if ($res)
            return false;

        return true;
    }

    public function saveConfirmCode($userId, $code)
    {
        $sql = $this->db->parse('
            INSERT INTO `activation_codes` (`user_id`, `code`) VALUES (?i, ?i)
            ON DUPLICATE KEY UPDATE `code` = VALUES(`code`)
        ', $userId, $code);
        $res = $this->db->query($sql);

        return $res;
    }
}