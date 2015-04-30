<?php

namespace WebLinks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ApiController {

	/**
     * API links controller.
     *
     * @param Application $app Silex application
     *
     * @return All links in JSON format
     */
    public function getLinksAction(Application $app) {
    	$links = $app['dao.link']->findAll();
	    // Convert an array of objects ($links) into an array of associative arrays ($responseData)
	    $responseData = array();
	    foreach ($links as $link) {
	        $responseData[] = array(
	            'id' => $link->getId(),
	            'title' => $link->getTitle(),
	            'url' => $link->getUrl()
	        );
	    }
	    // Create and return a JSON response
	    return $app->json($responseData);
    }

    /**
     * API link details controller.
     *
     * @param integer $id Link id
     * @param Application $app Silex application
     *
     * @return Links details in JSON format
     */
    public function getLinkAction($id, Application $app) {
        $link = $app['dao.link']->find($id);
	    $user = $link->getUser();
	    // Convert an object ($link) into an associative array ($responseData)
	    $responseData = array(
	        'id' => $link->getId(),
	        'title' => $link->getTitle(),
	        'url' => $link->getUrl(),
	        'user' => array(
	            'id' => $user->getId(),
	            'username' => $user->getUsername()
	        )
	    );
	    // Create and return a JSON response
	    return $app->json($responseData);
    }
}