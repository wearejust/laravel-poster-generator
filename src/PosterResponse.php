<?php

namespace Just\PosterGenerator;


use JonnyW\PhantomJs\Http\Response;
use Symfony\Component\HttpFoundation\File\File;

class PosterResponse
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var File
     */
    private $file;

    /**
     * @param Response $response
     * @param File $file
     */
    public function __construct(Response $response, File $file)
    {
        $this->response = $response;
        $this->file = $file;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }
}
