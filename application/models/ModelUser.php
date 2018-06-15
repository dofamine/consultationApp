<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 06.05.2018
 * Time: 16:46
 */
use Entity\User;
class ModelUser extends Model
{
    private static $instance = null;

    public static function instance()
    {
        return self::$instance === null ?
            self::$instance = new self():
            self::$instance;
    }
    protected function __construct()
    {
        parent::__construct();
    }

    public function getAll():array
    {
        return User::fromAssocies($this->db->users->getAllWhere());
    }

    public function getById(int $id): User
    {
        $user = new User();
        $user->fromAssoc($this->db->users->getElementById($id));
        return $user;
    }
    
    public function addProfileId(int $id)
    {
        $this->db->users->updateById($id,["profile_id"=>$id]);
    }
}