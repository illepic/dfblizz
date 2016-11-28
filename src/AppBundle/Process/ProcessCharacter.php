<?php

namespace AppBundle\Process;

class ProcessCharacter
{
    public function __construct()
    {

    }

    public function process(Array $data)
    {
        // Retrieve just active talents
        // It APPEARS that the first spec is always selected. If not, use this
        // jumble to search for active. Otherwise, we'll just use first place
        //$active_talents_key = array_search(TRUE, array_column($data['talents'], 'selected'));
        $data['spec'] = $data['talents'][0]['spec'];

        // For now, destroy the talents key to save a lot memory
        unset($data['talents']);

        return $data;
    }
}
