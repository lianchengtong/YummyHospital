<?php
namespace application\base;

class AuthController extends BaseController
{
    public $layoutSnip    = "main";
    use TraitNeedLogin;
}