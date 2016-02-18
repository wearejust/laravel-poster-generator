<?php

namespace Just\PosterGenerator;

interface PosterInterface
{
    /**
     * @return array
     */
    public function getProperties();

    /**
     * @return string
     */
    public function getTemplatePath();

    /**
     * @return array
     */
    public function getViewportSize();
}