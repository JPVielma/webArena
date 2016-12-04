<?php
namespace App\Controller;
use App\Controller\AppController;
use Facebook; 
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Event\EventManager;

define("EMPTY", 0);
define("FIGHTER", 1);
define ("ATTACK", 2);

define ("BORDERX", 15);
define ("BORDERY", 10);


define ("LEFT", 10);
define ("UP", 11);
define ("DOWN", 12);
define ("RIGHT", 13);

class ArenasController  extends AppController
{   
    public function index()
    {
        
    }

    public function recoverPassword(){
        $password;
        $subject="Your Web Arena password recovery";
        $content="Your Web Arena Password is:".$password;

        mail($_POST['email'], $subject ,$content);
        $this->Flash->success('Password sent to your mail account');
        $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));

    }
        public function register()
    {
        $this->loadModel('Players');
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

    public function diary()
    {
        $this->loadModel('Events');
        $events = $this->paginate($this->Events);
        $this->set(compact('events'));
        $this->set('_serialize', ['events']);
    }

   public function fighter()
   {
        //$this->Session->delete('objects');
        //Getting the Id of the connected fighter
        $playerId = $this->Session->read('Connected');
        //getting fighters created by the user
        $this->set('characters',$this->Fighter->find('list', array('conditions' => array('player_id' => $playerId))));
        //if the form has beeen sent
        if ($this->request->is('post'))
        {
            if(!empty($this->data['Register']))
            {
                $this->Fighter->create('Fighter');
                $this->Fighter->save($this->request->data);
                $this->Fighter->createPerso($this->data['Register']['Your Username'], $playerId);
                        
                $x = $this->Fighter->field('coordinate_x');
                $y = $this->Fighter->field('coordinate_y');
                $fighter = $this->Fighter->field('name');
            }
        }
    }

    public function deleteFighter($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fighter = $this->Fighters->get($id);
        $this->addEvent(date("Y-m-d H:i:s"), $fighter->name.' has dieded ', $fighter->coordinate_x,$fighter->coordinate_y);
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
    $this->loadModel('Events');
    $fighter1 = $this->Fighters->get($id1);
    $fighter2 = $this->Fighters->get($id2);
    if ((10 + $fighter2->level - $fighter1->level) > rand(0, 20)){
            $this->Flash->success($fighter1->name ." hits ". $fighter2->name . " successfully !");
            $this->addEvent(date("Y-m-d H:i:s"), $fighter1->name.' attacked successfully '.$fighter2->name, $fighter1->coordinate_x,$fighter1->coordinate_y);
            $fighter1->xp++;
            // Every 4 xp, lvl up
            if ($fighter1->xp % 4 == 0) {
                $fighter1->level++;
            }
            $fighter2->current_health-=$fighter1->skill_strength;
            $this->Fighters->save($fighter2);
            $this->Fighters->save($fighter1);
            if ($fighter2->current_health==0) {
                $this->deleteFighter($fighter2->id);
                $fighter1->xp += $fighter2->level;
                $this->Fighters->save($fighter1);
            }
    }
    else $this->Flash->error($fighter1->name ." hits ". $fighter2->name . " and misses !");
    $this->addEvent(date("Y-m-d H:i:s"), $fighter1->name.' missed '.$fighter2->name, $fighter1->coordinate_x,$fighter1->coordinate_y);
    $this->redirect(array('controller' => 'Arenas', 'action' => 'sight'));
}

 public function sight()
{
        if(isset($_SESSION['valid'])){
            $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
        }
        for ($i=0; $i<=BORDERY; $i++){
            for ($j=0; $j<BORDERX; $j++){
                $matrix[$i][$j]=0;
                $surroundings[$i][$j]=0;
            }
        }
        $this->loadModel('Fighters');
        $fighters = $this->Fighters->find();
       
        foreach ($fighters as $row){
            $matrix[$row->coordinate_y][$row->coordinate_x]=FIGHTER;
            $players[$row->coordinate_y.$row->coordinate_x]=$row;
            if ($row->id==1) $fighter=$row;
        }

       $x_fighter=$fighter->coordinate_x;
       $y_fighter=$fighter->coordinate_y;

        if($matrix[$y_fighter+1][$x_fighter]==FIGHTER)$matrix[$y_fighter+1][$x_fighter]=ATTACK;
        else if($y_fighter+1<BORDERY)$matrix[$y_fighter+1][$x_fighter]=UP;
        if($matrix[$y_fighter][$x_fighter+1]==FIGHTER)$matrix[$y_fighter][$x_fighter+1]=ATTACK;
        else if($x_fighter+1<BORDERX) $matrix[$y_fighter][$x_fighter+1]=RIGHT;
        if($matrix[$y_fighter-1][$x_fighter]==FIGHTER)$matrix[$y_fighter-1][$x_fighter]=ATTACK;
        else if($y_fighter-1>=0) $matrix[$y_fighter-1][$x_fighter]=DOWN;
        if($matrix[$y_fighter][$x_fighter-1]==FIGHTER)$matrix[$y_fighter][$x_fighter-1]=ATTACK;
        else if (($x_fighter-1)>0)$matrix[$y_fighter][$x_fighter-1]=LEFT;

        $sight=($fighter->skill_sight)+1;
        $count=0;
        for ($i=0; $i<$sight; $i++){
            for ($j=0; $j<$sight-$i; $j++){
                $surroundings[$y_fighter+$i][$x_fighter+$j]=1;
                $surroundings[$y_fighter+$i][$x_fighter-$j]=1;
                $surroundings[$y_fighter-$i][$x_fighter+$j]=1;
                $surroundings[$y_fighter-$i][$x_fighter-$j]=1;
            }
        }

        $this->set("surroundings", $surroundings); 
        $this->set("players", $players);
        $this->set("matrix", $matrix);
        $this->set("fighters", $fighters);
        $this->set("fighter", $fighter);

        $this->set("FIGHTER", FIGHTER); 
        $this->set("UP", UP); 
        $this->set("DOWN", DOWN); 
        $this->set("LEFT", LEFT); 
        $this->set("RIGHT", RIGHT); 
        $this->set("BORDERY", BORDERY); 
        $this->set("BORDERX", BORDERX); 

}

    public function move($idFighter, $direction){
        $this->loadModel('Fighters');
        $fighter = $this->Fighters->get($idFighter);

        switch($direction){
            case UP:
                 $y=$fighter->coordinate_y;
                 $fighter->coordinate_y=$y+1;
                 $this->addEvent(date("Y-m-d H:i:s"), $fighter->name.' moved North ', $fighter->coordinate_x,$fighter->coordinate_y);
                break;
            case DOWN:
                $y=$fighter->coordinate_y;
                $fighter->coordinate_y=$y-1;
                $this->addEvent(date("Y-m-d H:i:s"), $fighter->name.' moved South ', $fighter->coordinate_x,$fighter->coordinate_y);
                break;
            case LEFT:
                $x=$fighter->coordinate_x;
                $fighter->coordinate_x=$x-1;
                $this->addEvent(date("Y-m-d H:i:s"), $fighter->name.' moved East ', $fighter->coordinate_x,$fighter->coordinate_y);
                break;
            case RIGHT:
                $x=$fighter->coordinate_x;
                $fighter->coordinate_x=$x+1;
                $this->addEvent(date("Y-m-d H:i:s"), $fighter->name.' moved West ', $fighter->coordinate_x,$fighter->coordinate_y);
                break;
        }
        $this->Fighters->save($fighter);
        $this->redirect(array('controller' => 'Arenas', 'action' => 'sight'));
    }

public function logout() {
    session_start();
     $this->request->session()->destroy();
    $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
}
    

    public function login()
    {
        $session = $this->request->session();

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
        
        //     $user = $this->Auth->identify();
        //     if($user){
        //         $this->Auth->setUser($user);
        //         return $this->redirect(['Arenas' => 'index']);
        //     }
        //      $this->Flash->error('Incorrect Login');
        // }
            $this->loadModel('Players');
            $user= $this->Players->get(1);
            //     ->where(['email' => "'".$_POST['email']."'", 'password' => "'".$_POST['password']."'"])
            //     ->first();
            // debug($user->title);
                // pr($user->username);
            if ($user) {
                $session->write('valid', true);
                $session->write('username', $user->email);
                $session->write('id', $user->id);
                $this->redirect(array('controller' => 'Arenas', 'action' => 'index'));
            }else {
                 $this->Flash->error('Incorrect Login');
            }
        }

    }

        public function addEvent($time, $action, $pos_x, $pos_y)
        {
            $Event = \Cake\ORM\TableRegistry::get('Events');
            $newEvent = $Event->newEntity();
            $newEvent->date = $time;
            $newEvent->name = $action;
            $newEvent->coordinate_x = $pos_x;
            $newEvent->coordinate_y = $pos_y;
            $Event->save($newEvent);
        }
}