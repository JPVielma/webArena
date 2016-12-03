<?php
namespace App\Controller;
use App\Controller\AppController;
use Facebook; 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\GraphUser;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Cake\Routing\Router;

define("EMPTY", 0);
define("FIGHTER", 1);
define ("ATTACK", 2);

define ("LEFT", 10);
define ("UP", 11);
define ("DOWN", 12);
define ("RIGHT", 13);

class ArenasController  extends AppController
{
    public $uses = array('Player', 'Fighter', 'Event', 'Surrounding');
    


    public function index()
    {

    }

    public function diary()
    {
        //Affichage des évènements en commençant par le plus récent
       $this->set('raw',$this->Event->find('all',array('order'=>array('id DESC'))));
    }

   public function fighter()
   {
        //$this->Session->delete('objects');
        //Récupération de l'id du player connecté
        $playerId = $this->Session->read('Connected');
        //Récupération des fighters créés par le joueur
        $this->set('characters',$this->Fighter->find('list', array('conditions' => array('player_id' => $playerId))));
        //Si un formulaire a été envoyé
        if ($this->request->is('post'))
        {
            if(!empty($this->data['Register']))
            {
                $this->Fighter->create('Fighter');
                $this->Fighter->save($this->request->data);
                $this->Fighter->createPerso($this->data['Register']['Your Username'], $playerId);
                        
                //On sauvegarde la création de fighter
                $x = $this->Fighter->field('coordinate_x');
                $y = $this->Fighter->field('coordinate_y');
                $fighter = $this->Fighter->field('name');
                $this->Event->save(array('name' => 'Entrée de '.$fighter, 'date' =>  date("Y-m-d H:i:s"), 'coordinate_x' => $x, 'coordinate_y' => $y));
            }
        }
    }

    public function deleteFighter($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fighter = $this->Fighters->get($id);
        if ($this->Fighters->delete($fighter)) {
            $this->Flash->success(__('The fighter has been eliminated.'));
        } else {
            // $this->Flash->error(__('The fighter could not be deleted. Please, try again.'));
        }

        $this->redirect(array('controller' => 'Arenas', 'action' => 'sight'));
    }

    
public function attack($id1, $id2)
{
    $this->loadModel('Fighters');
    $fighter1 = $this->Fighters->get($id1);
    $fighter2 = $this->Fighters->get($id2);
    if ((10 + $fighter2->level - $fighter1->level) > rand(0, 20)){
            $this->Flash->success($id1 ."hits ". $id2 . " successfully !");
            $fighter1->xp++;
            $fighter2->current_health-=$fighter1->skill_strength;
            if ($fighter2->current_health==0) $this->deleteFighter($fighter2);
            $this->Fighters->save($fighter1);
            $this->Fighters->save($fighter2);
    }
    else $this->Flash->error($id1 ."hits ". $id2 . " and misses !");

    $this->redirect(array('controller' => 'Arenas', 'action' => 'sight'));
}

 public function sight()
    {
        for ($i=0; $i<10; $i++){
            for ($j=0; $j<15; $j++){
                $matrix[$i][$j]=0;
            }
        }
        $this->loadModel('Fighters');
        $fighters = $this->Fighters->find();
       
        foreach ($fighters as $row){
            $matrix[$row->coordinate_y][$row->coordinate_x]=FIGHTER;
            $players[$row->coordinate_y.$row->coordinate_x]=$row;
            if ($row->id==1) $fighter=$row;
        }
       
        for ($i=0; $i<10; $i++){
            for ($j=0; $j<15; $j++){
               if ($matrix[$i][$j]!=0){
                if ($j==$fighter->coordinate_x && $i==$fighter->coordinate_y){
                    if($matrix[$i+1][$j]==FIGHTER)$matrix[$i+1][$j]=ATTACK;
                    else $matrix[$i+1][$j]=UP;
                    if($matrix[$i][$j+1]==FIGHTER)$matrix[$i][$j+1]=ATTACK;
                    else $matrix[$i][$j+1]=RIGHT;
                    if($matrix[$i-1][$j]==FIGHTER)$matrix[$i-1][$j]=ATTACK;
                    else $matrix[$i-1][$j]=DOWN;
                    if($matrix[$i][$j-1]==FIGHTER)$matrix[$i][$j-1]=ATTACK;
                    else $matrix[$i][$j-1]=LEFT;
         
                    }
                }
            }
        }
        $this->set("players", $players);
        $this->set("matrix", $matrix);
        $this->set("fighters", $fighters);
        $this->set("fighter", $fighter);
    }

    public function move($idFighter, $direction){
        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($idFighter);

        switch($direction){
            case UP:
                 $y=$fighter->coordinate_y;
                 $fighter->coordinate_y=$y+1;
                break;
            case DOWN:
                $y=$fighter->coordinate_y;
                $fighter->coordinate_y=$y-1;
                break;
            case LEFT:
                $x=$fighter->coordinate_x;
                $fighter->coordinate_x=$x-1;
                break;
            case RIGHT:
                $x=$fighter->coordinate_x;
                $fighter->coordinate_x=$x+1;
                break;
        }
        $this->Fighters->save($fighter);
        $this->redirect(array('controller' => 'Arenas', 'action' => 'sight'));
    }
// public function sight($fighterId)
// { 
//     // $playerId = $this->Session->read('Connected');  //retrieve player Id
//     // $id = $this->Fighter->find('list', array('conditions' => array('id' => $fighterId, 'player_id' => $playerId))); 
//     // if(empty($id)) {
//     //     die('Wrong Fighter');
//     // }

//     // if ($this->request->is('post'))       
//     // {
//     //     if(!empty($this->data ['Fightermove'])) 
//     //     {
//     //         $this->Fighter->doMove($fighterId, $this->data['Fightermove']['direction']);
//     //     }
//     //     else {
//     //         if($this->Fighter->doAttack($fighterId, $this->data['Fighterattack']['direction'])) $this->Session->setFlash('Vous avez attaqué un ennemi!');
//     //         else $this->Session->setFlash('Raté!');
//     //     }
//     // }



// }

public function avatar()
{   
    $this->loadModel('Program');
    $playerId = $this->Session->read('Connected'); 
    $this->set('perso',$this->Fighter->find('all', array('conditions' => array('player_id' => $playerId))));
}

public function arena($fighterid)
{
    App::uses('String', 'Utility');

    $his = $this->Fighter->findById($fighterid);
    $all = $this->Fighter->find('all');
    $others = $this->Fighter->find('all', array('conditions' => array('Fighter.id !=' => $fighterid)));

    $classes = array();
    $names = array();
    $x= $his['Fighter']['coordinate_x'] - 1;
    $this->set('x',$x);
    $y= 10 - $his['Fighter']['coordinate_y'];
    $this->set('y',$y);
    $classes[$x][$y]='tabvueperso';
    $names[$x][$y]=$his['Fighter']['name'];
    $ids[$x][$y] = $his['Fighter']['id'];
    $vue = $his['Fighter']['skill_sight'];
    $this->set('vue', $vue);
    foreach ($others as $key => $other)
    {
        $x= $other['Fighter']['coordinate_x'] - 1;
        $y= 10 - $other['Fighter']['coordinate_y'];
        $player = $other['Fighter']['player_id'];
        if($player == $this->Session->read('Connected')) $classes[$x][$y] = 'tabvuefriendly';
        else $classes[$x][$y]='tabvueennemi';
        $names[$x][$y]=$other['Fighter']['name'];
        $ids[$x][$y]=$other['Fighter']['id'];
    }
    $x= $his['Fighter']['coordinate_x'] - 1;
    $y= 10 - $his['Fighter']['coordinate_y'];
    foreach(range(0,9) as $a)
    {
        $r2 = rand(0,14);
        foreach(range(0,14) as $b)
        {
            $c = $b - $x;
            $d = $a - $y;
            if($c < 0) $c = -$c;
            if($d < 0) $d = -$d;
            if($c > $vue || $d > $vue)
            {
                $names[$b][$a] = 'x';
                $classes[$b][$a] = 'tabvueoos';
            }
            if(!isset($classes[$b][$a]) && ($c < $vue || $d < $vue))
            {
                {
                    $classes[$b][$a] = 'tabvuevide';
                    $names[$b][$a] = 'o';
                }
            }
        }
    }


/*  if(!$this->Session->check('objects'))
    {
        $co = 0;
        foreach(range(0,9) as $s)
        {
            $r1 = rand(0,14);

            while(isset($ids[$r1][$a]))
            {
                $r1 = rand(0,14);
            }
            $dat = $this->Surrounding->find('all');
            if($co % 10 == 0)
            {
                $this->Surrounding->save(array('id' => $a.$r1, 'type' => 'column', 'coordinate_x' => $s++, 'coordinate_y' => 10-$t));
                $classes[$a][$r1] = 'tabvuecolonne';
                $names[$a][$r1] = 'c';
            }
    $co++;
    }
    $i = String::uuid();
    $this->Session->write('objects', $i);
}

$dat = $this->Surrounding->find('all');

foreach ($dat as $d)
{
    $classes[$d['Surrounding']['coordinate_x']--][10-$d['Surrounding']['coordinate_y']] = 'tabvuecolonne';
    $names[$d['Surrounding']['coordinate_x']--][10-$d['Surrounding']['coordinate_y']] = 'c';
}*/

    
    $this->set('classes', $classes);
    $this->set('names', $names);
    $this->set('ids', $ids);
    $this->set('curfighter', $fighterid);
  }

    public function doMove($fighterId,$xmove,$ymove)
    {
       //récupérer la position et fixer l'id de travail
        $this->set('cur',$fighterId);

        $this->Fighter->id = $fighterId;
        $x = $this->Fighter->field('coordinate_x');
        $y = $this->Fighter->field('coordinate_y');
        $vue = $this->Fighter->field('skill_sight');
        $this->Fighter->set('coordinate_y', $ymove);
        $this->Fighter->save();
        $y2 = $this->Fighter->field('coordinate_y');
        $yfin = 10-$y2;
        $xmove++;
        $this->Fighter->save(array('coordinate_x' => $xmove, 'coordinate_y' => $yfin));
                
        //Save event
        $fighter = $this->Fighter->field('name');
        $this->Event->save(array('name' => 'Déplacement de '.$fighter, 'date' =>  date("Y-m-d H:i:s"), 'coordinate_x' => $xmove, 'coordinate_y' => $yfin));
        $this->redirect(array('controller' => 'Arenas', 'action' => 'arena/'.$fighterId));
    }

public function doAttack($attacker, $attackee)
    {
        $this->Fighter->id = $attacker;
        $level = $this->Fighter->field('level');
        $strength = $this->Fighter->field('skill_strength');
        $xp = $this->Fighter->field('xp');
        $vue = $this->Fighter->field('skill_sight');
        $r = rand(1, 20);
        $og = $this->Fighter->findById($attackee);
                $fighter = $this->Fighter->field('name');
                $x_attack = $this->Fighter->field('coordinate_x');
                $y_attack = $this->Fighter->field('coordinate_y');
        if($og['Fighter']['name'])
        {
            if($r > (10 + $level - $og['Fighter']['level']))
            {
                $this->Fighter->save(array('xp' => $xp + 1));
                $this->Fighter->id = $og['Fighter']['id'];
                $this->Fighter->save(array(
                    'current_health' => $this->Fighter->field('current_health') - $strength));
                if($this->Fighter->field('current_health') <= 0){
                    $this->Fighter->delete($og['Fighter']['id']);
                                        
                                        //Save event
                                        $this->Event->save(array('name' => $fighter.' a tué '.$og['Fighter']['name'], 'date' =>  date("Y-m-d H:i:s"), 'coordinate_x' => $x_attack, 'coordinate_y' => $y_attack));
                }
                else {
                                
                                    //Save event
                                    $this->Event->save(array('name' => $fighter.' a attaqué '.$og['Fighter']['name'], 'date' =>  date("Y-m-d H:i:s"), 'coordinate_x' => $x_attack, 'coordinate_y' => $y_attack));
                                    }
            }
            else { 
                            $this->Event->save(array('name' => $fighter.' a raté '.$og['Fighter']['name'], 'date' =>  date("Y-m-d H:i:s"), 'coordinate_x' => $x_attack, 'coordinate_y' => $y_attack));
                        }                            
                    }

        $this->redirect(array('controller' => 'Arenas', 'action' => 'arena/'.$attacker));
    }

    public function levelUp($fighterId)
    {
        $this->Fighter->id = $fighterId;
        $xp = $this->Fighter->field('xp');
        $lvl = $this->Fighter->field('level');
        if(($xp -(4*$lvl)+4)>=4)
        {
            $this->Fighter->set('level',$lvl + 1);
                        
                        //Save event
                        $x_attack = $this->Fighter->field('coordinate_x');
                        $y_attack = $this->Fighter->field('coordinate_y');
                        $level = $lvl+1;
                        $fighter = $this->Fighter->field('name');
                        $this->Event->save(array('name' => $fighter.' est maintenant niveau '.$level, 'date' =>  date("Y-m-d H:i:s"), 'coordinate_x' => $x_attack, 'coordinate_y' => $y_attack));
        }

        if($this->request->is('post'))
        {
            $choice = $this->request->data['Skills']['choice'];
            if($choice == 'health'){
                $this->Fighter->set('skill_health', $this->Fighter->field('skill_health')+3);
                $this->Fighter->set('current_health', $this->Fighter->field('skill_health')+3);
            }
            if($choice == 'strength') $this->Fighter->set('skill_strength', $this->Fighter->field('skill_strength')+1);
            if($choice == 'sight') $this->Fighter->set('skill_sight', $this->Fighter->field('skill_sight')+1);
            $this->Fighter->save();
            $this->redirect(array('controller' => 'Arenas', 'action' => 'avatar'));
        }
        
            
    }

public function logout() {
    session_start();
     $this->Session->destroy();
    return $this->redirect($this->Auth->logout());
}
    

    public function login()
    {
        // pr( $this->Auth->User('user_id'));
        // session_start();
        // require_once __DIR__ . '/vendor/autoload.php';
        $fb = new Facebook\Facebook([
          'app_id' => '390888334577306',
          'app_secret' => 'c720dcf8f82343e3ee705b7b8fff3e34',
          'default_graph_version' => 'v2.4',
          ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // optional
            
        try {
            if (isset($_SESSION['facebook_access_token'])) {
                $accessToken = $_SESSION['facebook_access_token'];
            } else {
                $accessToken = $helper->getAccessToken();
            }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
         }
        if (isset($accessToken)) {
            if (isset($_SESSION['facebook_access_token'])) {
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {
                // getting short-lived access token
                $_SESSION['facebook_access_token'] = (string) $accessToken;
                // OAuth 2.0 client handler
                $oAuth2Client = $fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                // setting default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }
            // redirect the user back to the same page if it has "code" GET variable
            if (isset($_GET['code'])) {
                header('Location: ./');
            }
            // getting basic info about user
            try {
                $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
                $profile = $profile_request->getGraphNode()->asArray();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // redirecting user back to app login page
                header("Location: ./");
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            
            // printing $profile array on the screen which holds the basic info about user
            print_r($profile);
            // Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
        } else {
            // replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here

            $url= Router::url(['controller' => 'Arenas', 'action' => 'index'],true);
            $loginUrl = $helper->getLoginUrl($url, $permissions);

            $this->set('loginUrl', $loginUrl);
            // echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

        }

        if($this->request->is('post')){
            $user = $this->Auth->identify();
            if($user){
                $this->Auth->setUser($user);
                return $this->redirect(['Arenas' => 'index']);
            }
             $this->Flash->error('Incorrect Login');
        }

    }

    public function newPlayer()
    {
        $player = $this->Players->newEntity();
        if ($this->request->is('post')) {
            $player = $this->Players->patchEntity($player, $this->request->data);
            if ($this->Players->save($player)) {
                $this->Flash->success(__('The player has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The player could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('player'));
        $this->set('_serialize', ['player']);
    }
}