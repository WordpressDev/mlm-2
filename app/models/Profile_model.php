<?
class Profile_model extends Model
{
    public function updateUser($userId, array $data)
    {
        $sql = $this->db->parse('
            UPDATE `users` SET
                `name` = ?s,
                `email` = ?s,
                `city` = ?s,
                `about` = ?s
        ', $data['name'], $data['email'], $data['city'], $data['about']);

        if ($data['md5_password'])
            $sql .= $this->db->parse(', `password` =  ?s', $data['md5_password']);
        if ($data['avatar'])
            $sql .= $this->db->parse(', `avatar` =  ?s', $data['avatar']);

        $sql .= $this->db->parse(' WHERE `id` = ?i LIMIT 1', $userId);
        $res = $this->db->query($sql);

        return $res;
    }

    public function getUserById($userId)
    {
        $sql = $this->db->parse('SELECT * FROM `users` WHERE `id` = ?i LIMIT 1', $userId);
        $res = $this->db->getRow($sql);

        return $res;
    }
}