<?php

namespace Just\PosterGenerator;

use Exception;
use JonnyW\PhantomJs\Client as PhantomJS;
use Illuminate\Contracts\Filesystem\Filesystem as Files;
use Illuminate\Contracts\Config\Repository as ConfigInterface;
use JonnyW\PhantomJs\Http\PdfRequest;
use JonnyW\PhantomJs\Http\RequestInterface;
use Symfony\Component\HttpFoundation\File\File;

class PosterGenerator
{
    /**
     * @var ConfigInterface
     */
    private $config;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Files
     */
    private $files;

    /**
     * @param ConfigInterface $config
     * @param Filesystem      $filesystem
     * @param Files           $files
     */
    public function __construct(ConfigInterface $config, Filesystem $filesystem, Files $files)
    {
        $this->config     = $config;
        $this->filesystem = $filesystem;
        $this->files      = $files;
    }

    /**
     * @param PosterInterface $poster
     * @param string          $extension
     * @return PosterResponse
     */
    public function generateImage(PosterInterface $poster, $extension = 'jpg')
    {
        $phantom = $this->getPhantomJS();
        $file    = $this->getNewFile($extension);
        $request = $this->buildBaseRequest($phantom, $poster, $file);

        list($width, $height) = $poster->getViewportSize();
        $request->setViewportSize($width, $height);

        return $this->sendPhantomRequest($phantom, $request, $file);
    }


    /**
     * @param PosterInterface $poster
     * @return PosterResponse
     * @throws Exception
     */
    public function generatePDF(PosterInterface $poster)
    {
        $phantom = $this->getPhantomJS();
        $file    = $this->getNewFile('pdf');
        $request = $this->buildBaseRequest($phantom, $poster, $file);
        $request->setFormat('A4');

        return $this->sendPhantomRequest($phantom, $request, $file);
    }

    /**
     * @param PhantomJS       $phantom
     * @param PosterInterface $poster
     * @param File            $file
     * @return PdfRequest|RequestInterface
     * @throws Exception
     * @throws \JonnyW\PhantomJs\Exception\NotWritableException
     */
    private function buildBaseRequest(PhantomJS $phantom, PosterInterface $poster, File $file)
    {
        $route = route('package.postergenerator');

        switch ($file->getExtension()) {
            case 'jpg':
            case 'png':
                $request = $phantom->getMessageFactory()->createCaptureRequest($route);
                break;
            case 'pdf':
                $request = $phantom->getMessageFactory()->createPdfRequest($route);
                break;
            default:
                throw new Exception('Cannot make capture of [%s]', $file->getExtension());
                break;
        }

        $request->setMethod(RequestInterface::METHOD_POST);
        $request->setRequestData(array_merge(['template' => $poster->getTemplatePath()], $poster->getProperties()));
        $request->setHeaders(['X-API-POSTER-KEY' => $this->config->get('poster.middleware_token')]);

        $request->setOutputFile($file->getPathname());

        return $request;
    }

    /**
     * @return PhantomJS
     */
    private function getPhantomJS()
    {
        $path = 'bin' . DIRECTORY_SEPARATOR . 'phantomjs';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $path .= '.exe';

        $phantom = PhantomJS::getInstance();
        $phantom->getEngine()->setPath(base_path($path));

        return $phantom;
    }

    /**
     * @param $phantom
     * @param $request
     * @param $file
     * @return PosterResponse
     */
    private function sendPhantomRequest($phantom, $request, $file)
    {
        $preResponse = $phantom->getMessageFactory()->createResponse();
        $response    = $phantom->send($request, $preResponse);

        $this->filesystem->put($file);

        if (file_exists($file->getPathName())) {
            unlink($file->getPathName());
        }

        return new PosterResponse($response, $file);
    }

    /**
     * @param $extension
     * @return File
     */
    private function getNewFile($extension)
    {
        $path = sprintf('%s/%s.%s', $this->config->get('poster.tempDirectory'), str_random(), $extension);
        return new File($path, false);
    }
}
