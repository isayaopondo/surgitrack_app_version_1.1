<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH . 'libraries/Requests.php');

class Dropbox
{
    public function __construct()
    {
    }

    public function access_drobox()
    {
        /*
          curl -X POST https://api.dropboxapi.com/2/auth/token/from_oauth1 \
          --header "Authorization: Bearer ExSgZAq2tAAAAAAAAAAAB8qxwK5p2KzkAT_3HLgMThp8rP3wvCShP74O075nrfo1" \
          --header "Content-Type: application/json" \
          --data "{\"oauth1_token\": \"qievr8hamyg6ndck\",\"oauth1_token_secret\": \"qomoftv0472git7\"}"
         */
    }

    public function create_dropbox_folder($folder_name)
    {

        Requests::register_autoloader();
        $response = Requests::post(DROPBOX_API . "files/create_folder_v2", array(
            "Authorization" => "Bearer " . DROPBOX_API_ACCESS_TOKEN,
            "Content-Type" => "application/json"
        ), json_encode(array(
            'path' => $folder_name,
            'autorename' => false
        )));
    }

    public function upload_dropbox_folder($folder_name, $filename)
    {
        Requests::register_autoloader();
        $response = Requests::post(DROPBOX_CONTENT . "files/upload", array(
            "Authorization" => "Bearer " . DROPBOX_API_ACCESS_TOKEN,
            "Content-Type" => "application/octet-stream",
            "Dropbox-API-Arg" => json_encode(array(
                'path' => $folder_name,
                'mode' => add,
                'autorename' => true,
                'mute' => false
            ))
        ), @OPNOTES_REPOSITORY . $filename);
    }

    public function upload_file_dropbox($folder_name, $filename)
    {
        //$folder_name = '/testfolder';
        // $filename = 'Opondo_FLDA1129823_TURBT_30_06_2017.pdf';
        $path_name = $folder_name . '/' . $filename;

        $path = OPNOTES_REPOSITORY . $filename;
        $fp = fopen($path, 'rb');
        $size = filesize($path);

        $url = DROPBOX_CONTENT . "files/upload";

        $header = array();
        $header[] = 'Content-type: application/octet-stream';
        $header[] = 'Authorization: Bearer ' . DROPBOX_API_ACCESS_TOKEN;
        $header[] = 'Dropbox-API-Arg:' . json_encode(array(
                'path' => $path_name,
                'mode' => "add",
                'autorename' => true,
                'mute' => false
            ));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        curl_setopt($ch, CURLOPT_INFILESIZE, $size);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}