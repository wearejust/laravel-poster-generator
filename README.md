# Laravel poster generator
<b>NOTE: Package is still in development, use it at your own cause</b>

This collection of classes will enable you to generate `posters` quickly using `PhantomJS`. It enables the developer to easiliy implement an poster in HTML/CSS/JavaScript and let PhantomJS capture this into a image or PDF.

## Installation
First please add the following in your `composer.json` file
```json
  "scripts": {
    "post-install-cmd": [
      "PhantomInstaller\\Installer::installPhantomJS"
    ],
    "post-update-cmd": [
      "PhantomInstaller\\Installer::installPhantomJS"
    ]
  },
```
And require the postergenerator in your project
```bash
composer require wearejust/laravel-postergenerator
```
```php
// app.php

  ...
  Just\PosterGenerator\Providers\PosterGeneratorServiceProvider::class
  ...
```
## Configuration
You can adjust the settings in the config file (`config/poster.php`). You can also publish the config file using the artisan publish command

## Usage
Firstly, create an poster object with the properties you need in your poster. This could things from `text` to `images`. It's important to implement the `Just\PosterGenerator\PosterInterface`, for example:

```php
<?php

namespace NameSpace\To\Your\Class;

use Just\PosterGenerator\PosterInterface;
use Symfony\Component\HttpFoundation\File\File;

class PosterX implements PosterInterface
{
    /**
     * @var File
     *
     */
    private $background;

    /**
     * @var string
     */
    private $text;

    /**
     * @param $background
     * @param $text
     */
    public function __construct(File $background, $text)
    {
        $this->background = $background;
        $this->text = $text;
    }

    /**
    * Returns a set of variables that are available to the view
    *
    * @return array
    */
    public function getProperties()
    {
        return [
            'background' => $this->getImage(),
            'text' => $this->getText()
        ];
    }

    /**
     * @return string
     */
    private function getText()
    {
        return strtoupper($this->text);
    }
  
    /**
     * @return string
     */
    private function getImage()
    {
        // Could you Croppa (https://github.com/BKWLD/croppa) to crop image and convert it to string (path)
        return Croppa::url($this->background->getFilename(), 595,842, ['resize']);
    }

    /**
     * Returns full path (blade) to your view. The arguments of 
     * getProperties() will be auto inserted 
     * in to this view
     * 
     * @return string
     */
    public function getTemplatePath()
    {
        return 'path.to.your.html.poster';
    }

    /**
     * Returns width/height of the poster
     *
     * @return array
     */
    public function getViewportSize()
    {
        return [595, 842];
    }
}
```
Now that you have your poster object, it's quite easy to generate it via the `Just\PosterGenerator\PosterGenerator` class
```php
<?php

$poster = new PosterX('Title' new File('test.jpg'));

// We could generate a PDF
$response = $this->generator->generatePDF($poster);

// Or we could generate an Image
$response = $this->generator->generateImage($poster, 'jpg');

// In the $response we have the original response (getResponse()) out of Phantom
// and an getFile() method to get the generated file.
if ($response->getResponse()->getStatus() === 200) {
    return [
        'status' => 'success',
        'url' => $response->getFile()->getFilename())
    ];
}

return [
    'status' => 'error'
];
```

