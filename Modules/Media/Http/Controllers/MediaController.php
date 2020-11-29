<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Platform\Core\Http\Controllers\AppBaseController;
use GuzzleHttp\Client;

session_start();

class MediaController extends AppBaseController
{
    public function index()
    {
        $client = new Client(['base_uri' => 'http://192.168.1.5']);

        $multipart = [
            [
                'name' => 'client_id',
                'contents' => 'kmZJxR7vbRAhCtRkhKOgOyZmjcryktR1jQTUR2lf'
            ],
            [
                'name' => 'client_secret',
                'contents' => '0Mr1NRvWYlHdQl7P6bBcWQ3izaIq7B5eNTlThZMydTU9iwjP2MTAH4GqD6iHLrDb62rPCsIqBEtFIcEccg4w91CwMObfN9gALCZF5nJ40x8Thsp2LLoF0doZNrrG3eiINBUDvpvxoyo1OtVOHJ4MFJldSWcjpyQwGS7xECdkEkDpLRX7qWoaEyxZ4J1GHtBZNaVN0wk1ahPSbkw4WbDoPSqbBjwyUVY4wBxsCVzmVLPaQPDPIgo0pgdhcjKxVg'
            ],
            [
                'name' => 'grant_type',
                'contents' => 'client_credentials'
            ],
        ];

        $response = $client->request('POST', '/xibo-cms/web/api/authorize/access_token', [
            'multipart' => $multipart
        ]);

        $contents = $response->getBody();
        $content = json_decode($contents, true);

        $token = $content["access_token"];

        $_SESSION["token"] = $token;

        return view('media::index');
    }

    public function data()
    {
        $media = Media::all();

        return $media;
        
    //     $client = new Client(['base_uri' => 'http://192.168.1.5']);

    //     $headers = [
    //         'Authorization' => 'Bearer ' . $_SESSION["token"],
    //         'Accept' => 'application/json'
    //     ];

    //     $response = $client->request('GET', '/xibo-cms/web/api/display', [
    //         'headers' => $headers
    //     ]);

    //     $contents = $response->getBody();
    //     $content = json_decode($contents, true);

    //     return $content;
    // }

    // public function main()
    // {
    //     // return response()->json(["status" => "ok"]);

    //     // $panel = Panel::all();

    //     // return $panel;

    //     $panel = Panel::all();

    //     return $panel;
    }

    public function addmedia(Request $request)
    {
        $file = request('file');

        $fileExtension = $file->getClientOriginalName();

        $extensionOnly = explode(".", $fileExtension);

        $fileName = request('fileName');

        // if ($fileNameByUser === 'lemon') {
        //     return response()->json(["status" => "failed", "data" => $fileNameByUser]);
        // } else {
        //     return response()->json(["status" => "ok", "data" => $fileNameByUser]);
        // }

        $imagePath = $file->storeAs('public/uploads', $fileName . '.' . end($extensionOnly));

        $client = new Client(['base_uri' => 'http://192.168.1.5']);

        $headers = [
            'Authorization' => 'Bearer ' . $_SESSION["token"],
            'Accept' => 'application/json'
        ];

        $multipart = [
            [
                'name' => 'name',
                'contents' => $fileName
            ],
            [
                'name' => 'files',
                'contents' => fopen('C:/Users/thena/Desktop/laravel_bap/storage/app/' . $imagePath, 'r')
            ]
        ];

        $response = $client->request('POST', '/xibo-cms/web/api/library', [
            'headers' => $headers,
            'multipart' => $multipart
        ]);

        $contents = $response->getBody();
        $content = json_decode($contents, true);

        if (isset($content["files"][0]["error"])) {
            return response()->json([
                "status" => "failed",
                "messages" => $content["files"][0]["error"]
            ]);
            exit();
        }

        $form_data = array(
            'media_id' => '',
            'name' => $fileName,
            'stored_as' => '',
            'file_name' => $fileName . '.' . end($extensionOnly),
            'file_path' => $imagePath,
            'retired' => '',
            'size' => '',
            'type' => '',
            'tags' => '',
            'duration' => '',
        );

        if ( !isset($content["files"][0]["error"])) {
            $media = Media::create($form_data);

            $medias = $media->getAttributes();

            $mediaId = Media::find($medias["id"]);

            if($mediaId) {
                $mediaId->media_id = $content["files"][0]["mediaId"];
                $mediaId->retired = $content["files"][0]["retired"];
                $mediaId->stored_as = $content["files"][0]["storedas"];
                $mediaId->size = $content["files"][0]["size"];
                $mediaId->type = $content["files"][0]["type"];
                $mediaId->duration = $content["files"][0]["duration"];
                $mediaId->save();
            }
        }

        return response()->json(["status" => "ok"]);
    }

    // public function edit($id)
    // {
    //     $panel = Panel::where('media_id', $id)->firstOrFail();

    //     return $panel;
    // }

    // public function editstore(Request $request)
    // {
    //     $newfilename = $request->name;

    //     $media_id = $request->media_id["image_name"];

    //     $media_id_real = $request->media_id["media_id"];

    //     // $media_type = explode('.', $media_id);

    //     // $media_type_real = $media_type[1];

    //     $client = new Client(['base_uri' => 'http://192.168.1.5']);

    //     $headers = [
    //         'Authorization' => 'Bearer ' . $_SESSION["token"],
    //         'Content-Type' => 'application/x-www-form-urlencoded'
    //     ];

    //     $formparams = [
    //         'name' => $newfilename . '.jpg',
    //         'duration' => '10',
    //         'retired' => '0',
    //         'tags' => '0',
    //         'updateInLayouts' => '0'
    //     ];

    //     $response = $client->request('PUT', '/xibo-cms/web/api/library/' . $media_id_real , [
    //         'headers' => $headers,
    //         'form_params' => $formparams
    //     ]);

    //     $status = $response->getStatusCode();

    //     if ($status === 200) {
    //         $panelimagename = Panel::where('media_id', $media_id_real)->firstOrFail();

    //         if($panelimagename) {    
    //             $panelimagename->image_name = $newfilename . '.jpg';
    //             $panelimagename->save();
    //         }
    //     }

    //     return response()->json(["status" => "ok"]);
    // }

    // public function delete($id)
    // {
    //     $panel = Panel::where('media_id', $id)->firstOrFail();

    //     $client = new Client();

    //     $url = 'http://192.168.1.5/xibo-cms/web/api/library/' . $panel->media_id;

    //     $response = $client->delete($url, [
    //         'headers'  => [
    //             'Authorization' => 'Bearer ' . $_SESSION["token"],
    //             'Accept' => 'application/json'
    //         ]
    //     ]);

    //     if ($response->getStatusCode() === 204) {
    //         $panel->delete();
    //     }

    //     return response()->json(["status" => "ok"]);
    // }
}