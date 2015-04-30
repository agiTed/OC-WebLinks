<?php

namespace WebLinks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;
use WebLinks\Form\Type\LinkType;

class UserController {

	/**
     * Add link controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addLinkAction(Request $request, Application $app) {
        $link = new Link();
		$linkForm = $app['form.factory']->create(new LinkType(), $link);
		$linkForm->handleRequest($request);
		if ($linkForm->isSubmitted() && $linkForm->isValid()) {
	        $user = $app['security']->getToken()->getUser();
	        $link->setUser($user);
			$app['dao.link']->save($link);
			$app['session']->getFlashBag()->add('success', 'Your link was succesfully added.');
		}
	    return $app['twig']->render('link_form.html.twig', array(
	    	'title' => 'New Link',
	    	'linkForm' => $linkForm->createView()
	    ));
    }
}