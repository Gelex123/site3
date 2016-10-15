<?php
namespace Model;
use Library\DbConnection;
use Library\NotFoundException;
class StyleModel
{

    public function findAll()
    {
        $db = DbConnection::getInstance()->getPdo();
        $sth = $db->query("select * from style order by name");
        $styles = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (!$styles){
            throw new NotFoundException('Styles not found');}
        return $styles;
        
        
    }
}