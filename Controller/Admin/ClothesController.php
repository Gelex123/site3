<?php
namespace Controller\Admin;

use Library\Controller;
use Library\Request;
use Library\Router;
use Library\Session;
use Model\ClothesForm;
use Model\ClothesModel;
use Model\StyleModel;

class ClothesController extends Controller
{
    public function indexAction(Request $request)
    {
        if (!Session::has('user')){
            Router::redirect('/login');
        }

        $clothesModel = new ClothesModel();
        $clothess = $clothesModel->findAll();
        $args = array('clothess' => $clothess);

        return $this->render('index', $args);
    }

    public function editAction(Request $request)
    {
        $id = $request->get('id');

        $form = new ClothesForm($request);
        $model = new ClothesModel();
        $styleModel = new StyleModel();
        $styles = $styleModel->findAll();

        $clothes = $model->find($id);

        if ($request->isPost()){
            if ($form->isValid()){
                
                $model->update(array(
                    'id' => $id,
                    'title' => $form->title,
                    'price' => $form->price,
                    'description' => $form->description,
                    'style_id' => $form->style,
                    'status' => 1

                ));
                Session::setFlash('Saved');
                Router::redirect('/admin/clothes');
            }
            
            Session::setFlash('Fill the fields');
            
            
        } else {
            $form->setFromArray($clothes);
        }

        $args = array(
            'form' => $form,
            'styles' => $styles,
            'clothes' => $clothes
        );
        return$this->render('edit', $args);
    }
}