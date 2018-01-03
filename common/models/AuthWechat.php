<?php

namespace common\models;

use common\models\interfaces\InterfaceUserAuth;

class AuthWechat extends AbstractAuthUser implements InterfaceUserAuth
{
    const AUTH_TYPE = "wechat";

    public function setAuthData($authInfo)
    {
        $this->setAttributes([
            'open_id'                 => $authInfo['openid'],
            'access_token'            => $authInfo['access_token'],
            'refresh_token'           => $authInfo['refresh_token'],
            'access_token_expire_at'  => time() + intval($authInfo['expire_at']),
            'refresh_token_expire_at' => time() + 29 * 24 * 60 * 60,
        ]);
    }

}
