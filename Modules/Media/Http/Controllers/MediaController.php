<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Entities\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Platform\Core\Http\Controllers\AppBaseController;
use GuzzleHttp\Client;

class MediaController extends AppBaseController
{
    public function index()
    {
        $client = new Client(['base_uri' => 'http://192.168.44.127']);

        $multipart = [
            [
                'name' => 'client_id',
                'contents' => 'ZLR24lN2Ztf1HfaPQwKmNy4zVMw8J1F7oc8xRyz6'
            ],
            [
                'name' => 'client_secret',
                'contents' => '3opgkjtvFQKaXmDfGbWKC7WWV0778SFgdGf82n6gUbJEdfSbRgyknwF35iDIWDkOgmKNr9y7KrP6UOkoMMGB24zU9MfTTji8ka3dDAorfHYAHfg7eb0mBrbtopcmeK5oRJNjYGKJHbFPw5diPiru8gOFUdkhMjFMbCB6rYBWPIOO41rkvR29uM31i8782O3eVKjQXPfiVA67zEhW7noAvE0KQO3Qr0wwpSg34IHBtlM9FpTZF1C9NQ3phwCz7f'
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

    // public function data()
    // {
    //     $client = new Client(['base_uri' => 'http://192.168.44.127']);

    //     $headers = [
    //         'Authorization' => 'Bearer ' . $_SESSION["token"],
    //         'Accept' => 'application/json'
    //     ];

    //     $response = $client->request('GET', '/xibo-cms/web/api/library?length=20', [
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
    // }

    // public function addmedia(Request $request)
    // {
    //     $file = request('file');
    //     $imageNameByUser = request('imageName');

    //     $fileName = $file->getClientOriginalName();

    //     $imagePath = $file->storeAs('public/uploads', $fileName);

    //     $imageName = explode("/", $imagePath);

    //     $client = new Client(['base_uri' => 'http://192.168.44.127']);

    //     $headers = [
    //         'Authorization' => 'Bearer ' . $_SESSION["token"],
    //         'Accept' => 'application/json'
    //     ];

    //     $multipart = [
    //         [
    //             'name' => 'name',
    //             'contents' => $imageNameByUser
    //         ],
    //         [
    //             'name' => 'files',
    //             'contents' => fopen('C:/Users/thena/Desktop/laravel_bap_vue/storage/app/' . $imagePath, 'r')
    //         ]
    //     ];

    //     $response = $client->request('POST', '/xibo-cms/web/api/library', [
    //         'headers' => $headers,
    //         'multipart' => $multipart
    //     ]);

    //     $contents = $response->getBody();
    //     $content = json_decode($contents, true);

    //     if (isset($content["files"][0]["error"])) {
    //         return response()->json([
    //             "status" => "failed",
    //             "messages" => $content["files"][0]["error"]
    //         ]);
    //         exit();
    //     }

    //     $form_data = array(
    //         'image_database_name' => $imageName[2],
    //         'image_name' => $imageNameByUser,
    //         'image_path' => $imagePath,
    //         'media_id' => '',
    //         'retired' => '',
    //         'size' => '',
    //         'type' => '',
    //         'duration' => '',
    //     );
        
    //     if ( !isset($content["files"][0]["error"])) {
    //         $panel = Panel::create($form_data);

    //         $panels = $panel->getAttributes();

    //         $panelmediaid = Panel::find($panels["id"]);

    //         if($panelmediaid) {
    //             $panelmediaid->media_id = $content["files"][0]["mediaId"];
    //             $panelmediaid->retired = $content["files"][0]["retired"];
    //             $panelmediaid->size = $content["files"][0]["size"];
    //             $panelmediaid->type = $content["files"][0]["type"];
    //             $panelmediaid->duration = $content["files"][0]["duration"];
    //             $panelmediaid->save();
    //         }
    //     }

    //     return response()->json(["status" => "ok"]);
    // }

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

    //     $client = new Client(['base_uri' => 'http://192.168.44.127']);

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

    //     $url = 'http://192.168.44.127/xibo-cms/web/api/library/' . $panel->media_id;

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
