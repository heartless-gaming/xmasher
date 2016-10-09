<?php

namespace Xmasher\Controllers;

use Slim\Views\Twig as View;

class UploadController extends Controller
{
  private $form_field_name = 'uploadimage';

  private function mt_rand_str ($l, $c = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
      for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
      return $s;
  }

  public function getUpload($request, $response)
  {
    return $response->withRedirect($this->container->router->pathFor('home'));
  }

  public function postUpload($request, $response)
  {
    $storage_path = $this->container['settings']['image']['storage_path'];
    $storage = new \Upload\Storage\FileSystem($storage_path);
    $file = new \Upload\File($this->form_field_name, $storage);
    $autorised_fileformat = $this->container['settings']['image']['format'];
    $max_image_size = $this->container['settings']['image']['maxsize'];
    $seed = $this->mt_rand_str(6);

    // Renaming the received file
    $new_filename = $seed;
    $file->setName($new_filename);
    // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
    $file->addValidations(array(
        new \Upload\Validation\Mimetype($autorised_fileformat),
        new \Upload\Validation\Size($max_image_size)
    ));

    // Access data about the file that has been uploaded
    $data = array(
        'name'       => $file->getNameWithExtension(),
        'extension'  => $file->getExtension(),
        'mime'       => $file->getMimetype(),
        'size'       => $file->getSize(),
        'md5'        => $file->getMd5(),
        'dimensions' => $file->getDimensions()
    );

    try {
      $file->upload();

      // $this->flash->addMessage('imagename', $file->getNameWithExtension());
      $this->flash->addMessage('imagename', $file->getNameWithExtension());
      return $response->withRedirect($this->router->pathFor('home'));

    } catch (\Exception $e) {
      $this->flash->addMessage('uploaderrors', $file->getErrors());
      return $response->withRedirect($this->router->pathFor('home'));
    }

  }
}
