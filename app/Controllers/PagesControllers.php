<?php

namespace App\Controllers;


use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesControllers extends AbstractController
{

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $this->render($response, 'pages/index.twig');
    }

    public function postIndex(RequestInterface $request, ResponseInterface $response)
    {
        $error = [
            'dns'=>false,
            'email'=>false,
            'serveur'=>false,
            'NDD'=>false
        ];

        $ovh = $this->ovh;
        //DNS
        try{
            $ovh->post('/domain/zone/'.trim($request->getParam('service')).'/changeContact',[
                'contactAdmin' => trim($request->getParam('nic')),
                'contactBilling' => trim($request->getParam('nic')),
                'contactTech' => trim($request->getParam('nic')),
            ]);
        }catch (ClientException $e){
            $error['dns'] = true;
        }

        //EMAIL
        try{
            $ovh->post('/email/domain/'.trim($request->getParam('service')).'/changeContact',[
                'contactAdmin' => trim($request->getParam('nic')),
                'contactBilling' => trim($request->getParam('nic')),
                'contactTech' => trim($request->getParam('nic')),
            ]);
        }catch (ClientException $e){
            $error['email'] = true;
        }
        //SERVEUR
        try{
            $ovh->post('/hosting/web/'.trim($request->getParam('service')).'/changeContact',[
                'contactAdmin' => trim($request->getParam('nic')),
                'contactBilling' => trim($request->getParam('nic')),
                'contactTech' => trim($request->getParam('nic')),
            ]);
        }catch (ClientException $e){
            $error['serveur'] = true;
        }
        //NDD
        try{
            $ovh->post('/domain/'.trim($request->getParam('service')).'/changeContact',[
                'contactAdmin' => trim($request->getParam('nic')),
                'contactBilling' => trim($request->getParam('nic')),
                'contactTech' => trim($request->getParam('nic')),
            ]);
        }catch (ClientException $e){
            $error['NDD'] = true;
        }

        $this->render($response, 'pages/index.twig', ['error'=>$error]);
    }

}