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

    public function recoverPassword(){
        $password;
        $subject="Your Web Arena password recovery";
        $content="Your Web Arena Password is:".$password;

        mail($_POST['email'], $subject ,$content);
        $this->Flash->success('Password sent to your mail account');
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
       $j=$fighter->coordinate_x;
       $i=$fighter->coordinate_y;
        if($matrix[$i+1][$j]==FIGHTER)$matrix[$i+1][$j]=ATTACK;
        else $matrix[$i+1][$j]=UP;
        if($matrix[$i][$j+1]==FIGHTER)$matrix[$i][$j+1]=ATTACK;
        else $matrix[$i][$j+1]=RIGHT;
        if($matrix[$i-1][$j]==FIGHTER)$matrix[$i-1][$j]=ATTACK;
        else $matrix[$i-1][$j]=DOWN;
        if($matrix[$i][$j-1]==FIGHTER)$matrix[$i][$j-1]=ATTACK;
        else $matrix[$i][$j-1]=LEFT;
         
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

public function logout() {
    session_start();
     $this->Session->destroy();
    $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
}
    

    public function login()
    {
        // pr( $this->Auth->User('user_id'));
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
                $_SESSION['valid'] = true;
                $_SESSION['user'] = $user;
                $this->redirect(array('controller' => 'Arenas', 'action' => 'sight'));
            }else {
                 $this->Flash->error('Incorrect Login');
            }
        }

    }


}