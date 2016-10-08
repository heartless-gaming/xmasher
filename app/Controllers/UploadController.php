<?php

namespace Xmasher\Controllers;

use Slim\Views\Twig as View;

class UploadController extends Controller
{

  public function getUpload($request, $response)
  {
    return $this->view->render($response, 'upload.twig');
  }

  public function postUpload($request, $response)
  {
    $this->flash->addMessage('test', 'test flash message');
    return $response->withRedirect($this->router->pathFor('upload'));
  }
}
