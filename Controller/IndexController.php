<?php
namespace Controller;

use Library\Controller;
use Library\Request;
use Library\Router;
use Library\Session;
use Model\ContactForm;
use Model\FeedBackModel;

class IndexController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('index');
    }


    public function contactAction(Request $request)
    {
        $form = new ContactForm($request);

        if ($request->isPost()) {
            if ($form->isValid()) {
                $feedbackModel = new FeedBackModel();
                $datetime = (new \DateTime())->format('Y-m-d H:i:s');

                // mail()

                $feedbackModel->save(array(
                    'username' => $form->username,
                    'email' => $form->email,
                    'message' => $form->message,
                    'created' => $datetime
                ));
                Session::setFlash('Success');
                
                Router::redirect('/contact-us');
            }

            Session::setFlash('Error');
        }

        $args = array(
            'form' => $form
        );
        return $this->render('contact', $args);
    }
}