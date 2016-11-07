<?php
namespace App\Model\Table;

use Cake\ORM\Table;

use Cake\Datasource\ConnectionManager;

class FightersTable extends Table
{
        public function getBestFighter(){
        $connection = ConnectionManager::get('default');
       return $results = $connection->execute('SELECT * FROM fighters ORDER BY level DESC LIMIT 1')->fetchAll('assoc');
    }
}