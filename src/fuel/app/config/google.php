<?php

return array(
    'google' => array(
        'service_account' => array(
            'client_id' => '<ServiceAccount ClientID>',
            'mail_addr' => '<ServiceAccount MailAddr>',
            'key_file' => file_get_contents(APPPATH . 'google-client.p12')
        )
    )
);

/* End of file google.php */