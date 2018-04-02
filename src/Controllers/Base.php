<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 10/21/17
 * Time: 18:22
 */

namespace Controllers;

use Interop\Container\ContainerInterface;
use Slim\Flash\Messages;
use SlimSession\Helper;

class Base
{
    protected $container;
    protected $view;
    /**
     * @var Messages
     */
    protected $flash;

    /**
     * @var Helper
     */
    protected $session;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get('renderer');
        $this->flash = $container->get('flash');
        $this->session = $container->get('session');
    }
}