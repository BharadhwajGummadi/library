<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Genres Controller
 *
 * @property \App\Model\Table\GenresTable $Genres
 */
class GenresController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->success['data'] = $this->Genres->find('all');
        $this->sendJSONResponse($this->success);
    }

    /**
     * View method
     *
     * @param string|null $id Genre id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $genre = $this->Genres->get($id, [
            'contain' => ['Books']
        ]);
        $this->success['data'] = $genre;
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
            $genre = $this->Genres->newEntity($data);
            if ($this->Genres->save($genre)) {
                $this->success['message'] = 'The genre has been saved';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'The genre could not be saved. Please, try again.';
                $this->sendJSONResponse($this->failure);
            }
        }
        $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Edit method
     *
     * @param string|null $id Genre id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $genre = $this->Genres->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'put'])) {
            $genre = $this->Genres->patchEntity($genre, $this->request->data);
            if ($this->Genres->save($genre)) {
                $this->success['data'] = 'The genre has been saved.';
                $this->sendJSONResponse($this->success);
            } else {
                $this->failure['message'] = 'The genre couldn\'t saved. Please, try again.';
                $this->sendJSONResponse($this->failure);
            }
        }
       $this->sendJSONResponse($this->badRequest);
    }

    /**
     * Delete method
     *
     * @param string|null $id Genre id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $genre = $this->Genres->get($id);
        if ($this->Genres->delete($genre)) {
            $this->success['message'] = 'The genre has been deleted.';
            $this->sendJSONResponse($this->success);
        } else {
            $this->failure['message'] = 'The genre could not be deleted. Please, try again.';
            $this->sendJSONResponse($this->failure);
        }
    }
}
