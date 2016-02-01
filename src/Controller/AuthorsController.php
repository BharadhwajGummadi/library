<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Authors Controller
 *
 * @property \App\Model\Table\AuthorsTable $Authors
 */
class AuthorsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->success['data'] = $this->Authors->find('all');
        $this->sendJSONResponse($this->success);
    }

    /**
     * View method
     *
     * @param string|null $id Author id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => ['Books']
        ]);
        $this->success['data'] = $author;
        $this->sendJSONResponse($this->success);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {   
        $data = $this->request->data;
        
        if(empty($data)) {
            throw new BadRequestException('Empty request received');
        } 
        if ($this->request->is('post')) {
            $author = $this->Authors->newEntity($data);
            if ($this->Authors->save($author)) {
                $this->success['message'] = 'Author has been added successfully';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'Error while creating author.';
                $this->sendJSONResponse($this->failure);
            }
        }
       $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Edit method
     *
     * @param string|null $id Author id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'put'])) {
            $author = $this->Authors->patchEntity($author, $this->request->data);
            if ($this->Authors->save($author)) {
                $this->success['message'] = 'The author has been saved.';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'The author couldn\'t saved. Please, try again.';
                $this->sendJSONResponse($this->failure);
            }
        }
        $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Delete method
     *
     * @param string|null $id Author id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $author = $this->Authors->get($id);
        if ($this->Authors->delete($author)) {
            $this->success['message'] = 'The author has been deleted.';
            $this->sendJSONResponse($this->success);
        } else {
            $this->failure['The author couldn\'t be deleted. Please, try again.'];
            $this->sendJSONResponse($this->failure);
        }
    }
    
    /**
     * Description : This method is used to retrun all authors details.
     */
    public function getAuthors(){
        $this->autoRender = FALSE;
        $authors =  $this->Authors->find('all')
                                  ->select(array('Authors.id', 'Authors.first_name', 'Authors.last_name', 'Authors.date_of_birth'))
                                  ->all();
        if($authors->isEmpty){
            return json_encode('We couldn\'t find any author with these credentials.');
        }
        echo json_encode($authors);
    }
}
