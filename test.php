<?php
$pattern = '/{%(.*?)%}/';
$code    = <<<_CODE
a;lsdfja
a
sdf
a
{%blockshow %}
sdf
{% blockshow%}
ad
{% blockshow %}
f
_CODE;


preg_match($pattern, $code, $match);

print_r($match);
