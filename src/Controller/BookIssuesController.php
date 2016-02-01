<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BookIssues Controller
 *
 * @property \App\Model\Table\BookIssuesTable $BookIssues
 */
class BookIssuesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->success['data'] = $this->BookIssues->find('all');
        $this->sendJSONResponse($this->success);
    }

    /**
     * View method
     *
     * @param string|null $id Book Issue id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bookIssue = $this->BookIssues->get($id, [
            'contain' => ['User']
        ]);
        $this->success['data'] = $bookIssue;
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
            $bookIssue = $this->BookIssues->newEntity($data);
            if ($this->BookIssues->save($bookIssue)) {
                $this->success['message'] = 'The book issue has been saved.';
                $this->sendJSONResponse($this->success);
            } else {
                $this->success['message'] = 'The book issue could not be saved. Please, try again.';
                $this->sendJSONResponse($this->failure);
            }
        }
        $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Edit method
     *
     * @param string|null $id Book Issue id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bookIssue = $this->BookIssues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'put'])) {
            $bookIssue = $this->BookIssues->newEntity($bookIssue, $this->request->data);
            if ($this->BookIssues->save($bookIssue)) {
                $this->success['message'] = 'The book issue has been saved.';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'The book issue could not be saved. Please, try again.';
                $this->sendJSONResponse($this->failure);
            }
        }
      $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Delete method
     *
     * @param string|null $id Book Issue id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bookIssue = $this->BookIssues->get($id);
        if ($this->BookIssues->delete($bookIssue)) {
            $data = $this->success['message'] = 'The book issue has been deleted.';
            $this->sendJSONResponse($this->success);
        } else {
            $this->failure['message'] = 'The book issue could not be deleted. Please, try again.';
        }
    }
}
