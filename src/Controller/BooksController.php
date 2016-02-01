<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 */
class BooksController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->success['data'] = $this->Books->find()
                ->contain(array('Genres', 'Authors'))
                ->all();
        $this->sendJSONResponse($this->success);
    }

    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $book = $this->Books->get($id, [
            'contain' => ['Genres', 'Authors']
        ]);
        $this->success['data'] = $book;
        $this->sendJSONResponse($this->success);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $data = $this->request->data;
        if ($data) {
            throw new BadRequestException('Empty request received');
        }
        if ($this->request->is('post')) {
            $book = $this->Books->newEntity($data);
            if ($this->Books->save($book)) {
                $this->success['message'] = 'The book has been saved.';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'The book could not be saved. Please, try again.';
                $this->sendJSONResponse($this->failure);
            }
        }
        $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $book = $this->Books->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->data);
            if ($this->Books->save($book)) {
                $this->success['message'] = 'The book has been saved.';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'The book could not be saved. Please, try again.';
            }
        }
        $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
            $this->success['message'] = 'The book has been deleted.';
            $this->sendJSONResponse($this->success);
        } else {
            $this->failure['message'] = 'The book could not be deleted. Please, try again.';
            $this->sendJSONResponse($this->failure);
        }
    }

}
