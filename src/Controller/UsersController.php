<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->success['data'] = $this->Users->find('all');
        $this->sendJSONResponse($this->success);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->success['data'] = $user;
        $this->sendJSONResponse($this->success);
    }

    /**
     * 
     * @throws BadRequestException : When receive empty request
     */
    public function add()
    {   
        $data = $this->request->data;
        if(empty($data)) {
            throw new BadRequestException('Empty request received');
        } 
        
        if ($this->request->is('post')) {
            $user = $this->Users->newEntity($data);
            if ($this->Users->save($user)) {
                $this->success['message'] = 'User added successfully';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'Error while creating user.';
                $this->sendJSONResponse($this->failure);
            }
        }
        $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            
            if ($this->Users->save($user)) {
                $this->success['message'] = 'The user has been saved.';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'The user could not be saved. Please, try again.';
                $this->sendJSONResponse($this->success);
            }
        }
        $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->success['message'] = 'The user has been deleted.';
            $this->sendJSONResponse($this->success);
        } else {
            $this->failure['message'] = 'The user could not be deleted. Please, try again.'; 
            $this->sendJSONResponse($this->failure);
        }
    }
}
