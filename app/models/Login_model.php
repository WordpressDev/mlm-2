<?
class Login_model extends Model
{
    public function getUserByPhoneAndPassword($phone, $md5_password)
    {
        $sql = $this->db->parse('
            SELECT * FROM `users` WHERE `phone` = ?i AND `password` = ?s AND `active` = 1 LIMIT 1
        ', $phone, $md5_password);
        $res = $this->db->getRow($sql);

        return $res;
    }
}