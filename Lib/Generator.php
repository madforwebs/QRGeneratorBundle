<?php

namespace Fudbuc\QRGeneratorBundle\Lib;



use Fudbuc\ToolsBundle\Lib\Tools;

require_once __DIR__.'/phpqrcode/phpqrcode.php';



/**
 * Genera directivas SSI de include virtual
 * http://en.wikipedia.org/wiki/Server_Side_Includes
 */
class Generator
{
    /**
     *
     * @var EntityManager 
     */
    protected $em;

    private $router;

    private $memcached;

    private $document_root;

    private $public_root;

    public function __construct( $entityManager, $router, $memcached)
    {
        $this->em = $entityManager;
        $this->router = $router;
        $this->memcached = $memcached;
        return $this;
    }


    public function createQR( $url, $pathQr ,$type = 'recipe')
    {
        $PNG_TEMP_DIR = $pathQr.'/';
        if($type == 'recipe'){

        }else if($type == 'profile'){
                $PNG_TEMP_DIR .= 'profiles_photo/';
        }
        $matrixPointSize = min(max((int) 4, 1), 10);
        $errorCorrectionLevel = 'L';
        $filename = 'QR/' . $url . '.png';

        if (!file_exists($PNG_TEMP_DIR . $filename)) {
            if($type == 'recipe'){
                $referer = $this->router->generate('recipe_show', array('nameCod' => $url), true);
            }else if($type == 'profile'){
                $referer = $this->router->generate('user_profile_show', array('username' => $url), true);
            }
            \QRcode::png($referer, $PNG_TEMP_DIR . $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        }
    }
}
