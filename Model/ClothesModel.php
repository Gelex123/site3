<?php
namespace Model;

use Library\Button;
use Library\DbConnection;
use Library\NotFoundException;
use Library\Request;


class ClothesModel
{
    public function find($id)
    {
        $db = DbConnection::getInstance()->getPdo();
        $sth = $db->prepare('SELECT * FROM clothes where id = :number');
        $sth->execute(array('number'=>$id));
        $clothess = $sth->fetch(\PDO::FETCH_ASSOC);
        if (!$clothess){
            throw new NotFoundException('Clothes not found');}
        return $clothess;
    }

    /**
        * @return mixed
        * @throws NotFoundException
        */
    public function findAll()
    {
        $db = DbConnection::getInstance()->getPdo();
        $sql = "
        select c.title, c.id, c.price, c.status, group_concat(m.name) as manufacturer
        from clothes c join clothes_manufacturer cm on c.id = cm.clothes_id
        join manufacturer m on cm.manufacturer_id = m.id
        group by c.id";
        $sth = $db->query($sql);
        $clothess = $sth->fetchAll(\PDO::FETCH_ASSOC);

        if (!$clothess){
            throw new NotFoundException('Clothes not found');}
        return $clothess;
    }
    public function findAllForPages()
    {
        $db = DbConnection::getInstance()->getPdo();
        $lim = self::page() . 0 - 10;
        $lim2 = 10;
        $sql = "
        select c.title, c.id, c.price, c.status, group_concat(m.name) as manufacturer
        from clothes c join clothes_manufacturer cm on c.id = cm.clothes_id
        join manufacturer m on cm.manufacturer_id = m.id
        group by c.id limit " . $lim  . "," . $lim2;
        $sth = $db->query($sql);
        $clothess = $sth->fetchAll(\PDO::FETCH_ASSOC);

        if (!$clothess){
            throw new NotFoundException('Clothes not found');}
        return $clothess;

    }

    public function update(array $clothes)
    {
        $db = DbConnection::getInstance()->getPdo();
        $sql = 'UPDATE clothes SET title = :title, price = :price, description = :description, style_id = :style_id, 
        status = :status where id = :id';
        $s = $db->prepare($sql);
        $s->execute($clothes);

    }

    static function count()
    {
        $db = DbConnection::getInstance()->getPdo();
        $sql = 'select count(*) from clothes';
        $c = $db->query($sql);
        $count = $c->fetch(\PDO::FETCH_ASSOC);

        if (!$count){
            throw new \Exception('Page not found');
        }
        return $count;
    }

    static function page()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        return $page;
    }
}