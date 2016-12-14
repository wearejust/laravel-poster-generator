<?php

namespace Just\PosterGenerator;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\HttpFoundation\File\File;

class Filesystem
{

    /**
     * @param FilesystemManager                       $filesystems
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(FilesystemManager $filesystems, ConfigRepository $config)
    {
        $this->filesystem = $filesystems;
        $this->config = $config;
    }

    /**
     * @param File $file
     * @return bool
     */
    public function put(File $file)
    {
        return $this->getDisk()->put($file->getBasename(), file_get_contents($file->getPathname()), 'public');
    }

    /**
     * @param $path
     * @return string
     */
    public function get($path)
    {
        return $this->getDisk()->get($path);
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getDisk()
    {
        return $this->filesystem->disk($this->config->get('poster.defaultFilesystem'));
    }

    public function client()
    {
        return $this->filesystem;
    }

}
