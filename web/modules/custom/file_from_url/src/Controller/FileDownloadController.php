<?php

namespace Drupal\file_from_url\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


/**
 * Class FiledownloadController.
 */
class FileDownloadController extends ControllerBase
{

    /**
     * Action.
     *
     * @return string
     *   Return Hello string.
     */
    public function action()
    {
        $fid = \Drupal::state()->get('file_from_url_fid');
        $file = $this->entityTypeManager()->getStorage('file')->load($fid['0']);
        $url = $file->get('uri')->getValue()['0']['value'];
        //kint($url);
        $file_content = file_get_contents($url);
        $response = new Response();
        $response->setContent($file_content);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file->label()
        );

        $response->headers->set('Content-Disposition', $disposition);

        return  $response;

    }
}
