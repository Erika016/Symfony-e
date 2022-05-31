<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

  /**
     * @Route("/defaul")
     */
class DefaulController
{
    /**
     * @Route("", name="app_defaul")
     */
    public function index(): Response
    {
        return new  Response("INDEX");
    }

    /**
     * @Route("/test")
     */
    public function test(): Response
    {
        return new Response("test");
    }

    /**
     * @Route("/test1/{parametro}")
     */
    public function test1($parametro = 'valor por defecto'): Response
    {
        return new Response($parametro);
    }

    /**
     * @Route("/test2")
     */
    public function test2(Request $request): Response
    {
        $param1 = $request->query->get('param1');
        return new Response($param1);
        // para pintar algo se define en el buscardor ?param1=(lo que quieras) http://localhost/symfony/prueba1/public/index.php/test2?param1=valor
    }

    /**
     * @Route("/form", methods={"POST", "PUT"})
     */
    public function form(Request $request): Response

    
    {
        $data = $request->request->all();
        /** @var UploadedFile $file */
        $file = $request->files->get('file1');
        $content = $file->getContent();
        // MUESTA EL JSON EN PANTALLA
        // return new JsonResponse([
        //     'result' => 'ok',
        //     'data' => $data,
        //     'filename' => $file->getClientOriginalName(),
        //     'content' => base64_encode($content)
        // ]);
        
        // DESCARGA EL FORM EN LA BARRA DE DESCARGA
        return new Response($content, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=""' . $file->getClientOriginalName(). '"'
        ]);
    }

    /**
     * @Route("/suma")
     */
    public function suma(Request $request): Response
    {
        $n1 = $request->query->get('n1');
        $n2 = $request->query->get('n2');
        return new Response($n1 + $n2);
    }

    /**
     * @Route("/{operacion}/operacion")
     */
    public function operacion(Request $request, $operacion): Response
    {

        $n1 = $request->query->get('n1');
        $n2 = $request->query->get('n2');

        if (!is_numeric($n1) || !is_numeric($n2)) {
            return new Response('Error');
        }
        switch ($operacion) {
            case 'suma':
                $resultado = $n1 + $n2;
                break;
            case 'resta':
                $resultado = $n1 - $n2;
                break;
            case 'producto':
                $resultado = $n1 * $n2;
                break;
            case 'division':
                $resultado = $n1 / $n2;
                break;
        }

        return new Response($resultado);
    }

    /**
     * @Route("/test3/json", methods={"GET"})
     */
    public function test3(Request $request): Response
    {

        return new JsonResponse([
            'query' => $request->query->all(),
            'headers' => $request->headers->all(),
            'server' => $request->server->all(),
            'cookies' => $request->cookies->all()
        ]);
    }
    /**
     * @Route("/test3/json", methods={"POST"})
     */
    public function test3post(Request $request): Response
    {

        $data = $request->toArray();
        return  new JsonResponse([
            'result' => 'ok',
            'data' => $data
        ]);
    }
}
