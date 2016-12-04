<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Fighters Controller
 *
 * @property \App\Model\Table\FightersTable $Fighters
 */
class FightersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $hasFighter=false;
        if($this->request->session()->read('valid')!=true){
            $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
        }
        $this->paginate = [
            'contain' => ['Players', 'Guilds']
        ];
        $fighters = $this->paginate($this->Fighters);

        $this->set("hasFighter", $hasFighter);
        $this->set(compact('fighters'));
        $this->set('_serialize', ['fighters']);
    }

    /**
     * View method
     *
     * @param string|null $id Fighter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($this->request->session()->read('valid')!=true){
            $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
        }
        $fighter = $this->Fighters->get($id, [
            'contain' => ['Players', 'Guilds', 'Messages', 'Tools']
        ]);

        $this->set('fighter', $fighter);
        $this->set('_serialize', ['fighter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if($this->request->session()->read('valid')!=true){
            $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
        }
        $fighter = $this->Fighters->newEntity();
        if ($this->request->is('post')) {
            //Generating new fighter with default values
            $this->request->data['Fighters']['player_id'] = $this->request->session()->read('id');
            $this->request->data['Fighters']['coordinate_x'] = rand(0,15);
            $this->request->data['Fighters']['coordinate_y'] = rand(0,10);
            $this->request->data['Fighters']['level'] = 1; 
            $this->request->data['Fighters']['xp'] = 0;
            $this->request->data['Fighters']['skill_sight'] = 1;
            $this->request->data['Fighters']['skill_strength'] = 1;
            $this->request->data['Fighters']['skill_health'] = 3;
            $this->request->data['Fighters']['current_health'] = 3;
            //Save new fighter
            $fighter = $this->Fighters->patchEntity($fighter, $this->request->data);
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('The fighter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The fighter could not be saved. Please, try again.'));
            }
        }
        $players = $this->Fighters->Players->find('list', ['limit' => 200]);
        $this->set(compact('fighter', 'players'));
        $this->set('_serialize', ['fighter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Fighter id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($this->request->session()->read('valid')!=true){
            $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
        }
        $fighter = $this->Fighters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fighter = $this->Fighters->patchEntity($fighter, $this->request->data);
            if ($this->Fighters->save($fighter)) {
                $this->Flash->success(__('The fighter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The fighter could not be saved. Please, try again.'));
            }
        }
        $players = $this->Fighters->Players->find('list', ['limit' => 200]);
        $guilds = $this->Fighters->Guilds->find('list', ['limit' => 200]);
        $this->set(compact('fighter', 'players', 'guilds'));
        $this->set('_serialize', ['fighter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Fighter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if($this->request->session()->read('valid')!=true){
            $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
        }
        $this->request->allowMethod(['post', 'delete']);
        $fighter = $this->Fighters->get($id);
        if ($this->Fighters->delete($fighter)) {
            $this->Flash->success(__('The fighter has been deleted.'));
        } else {
            $this->Flash->error(__('The fighter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
