<?php

namespace App\Service;

class Overkill
{
    public function check($form)
    {
        if (!$form['attachments'][0]['file']->getData()) {
            return 11;
        }

        if (!filter_var($form['email']->getData(), FILTER_VALIDATE_EMAIL)) {
            return 12;
        }

        return true;
    }
}
