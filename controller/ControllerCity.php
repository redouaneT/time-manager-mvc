<?php
RequirePage::requireModel('Model');
RequirePage::requireModel('ModelCity');

class ControllerCity
{
    public function selectByForeignKey()
    {
        $cities = new ModelCity;
        $select =  $cities->selectByForeignKey($_GET['id'], 'ASC', $_GET['script']);
        return $select;
    }
}
