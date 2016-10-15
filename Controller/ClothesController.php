<?php
namespace Controller;

use Library\Controller;
use Library\MetaHelper;
use Library\Pagination;
use Library\Request;
use Library\Button;
use Model\ClothesModel;
class clothesController extends Controller
{
    public function indexAction(Request $request)
    {

        $clothesModel = new ClothesModel();

        $pages = $clothesModel->page();

        $clothess = $clothesModel->findAllForPages();

        $count = ClothesModel::count();

        $pagination = new Pagination(array(
            'itemsCount' => $count["count(*)"],
            'itemsPerPage' => 10,
            'currentPage' => $pages));

        $args = array(
            'count' => $count,
            'pages' => $pages,
            'clothess' => $clothess,
            'pagination' => $pagination
        );

        return $this->render('index', $args);
    }

    public function showAction(Request $request)
    {
        $id = $request->get('id');

        $clothesModel = new ClothesModel();
        $clothes = $clothesModel->find($id);
        

        $args = array(
            'clothes' => $clothes,
        );
        return $this->render('show', $args);
    }
}