<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function generate(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'string',
            'lastname' => 'string',
            'color' => 'string',
            'bgcolor' => 'string',
            'size' => 'integer'
        ]);

        $input = $request->all();

        $size = 64;
        if (array_key_exists('size', $input)) $size = intval($input['size']);
        $firstName = 'John';
        if (array_key_exists('firstname', $input)) $firstName = $input['firstname'];
        $lastName = 'Doe';
        if (array_key_exists('lastname', $input)) $lastName = $input['lastname'];
        $color = 'CDCDCD';
        if (array_key_exists('color', $input)) $color = $input['color'];
        $bgColor = '797979';
        if (array_key_exists('bgcolor', $input)) $bgColor = $input['bgcolor'];

        $im = imagecreate($size, $size);

        $pathToFont = storage_path('app/Roboto-Regular.ttf');
        $background = imagecolorallocate($im, hexdec($bgColor[0] . $bgColor[1]), hexdec($bgColor[2] . $bgColor[3]), hexdec($bgColor[4] . $bgColor[5]));
        $fontColor = imagecolorallocate($im, hexdec($color[0] . $color[1]), hexdec($color[2] . $color[3]), hexdec($color[4] . $color[5]));

        // imagefilledellipse($im, $size / 2, $size / 2, $size, $size, $fontColor);

        imagettftext($im, $size / 2, 0, $size / 10, $size * 0.75, $fontColor, $pathToFont, $firstName[0] . $lastName[0]);

        imageantialias($im, true);

        ob_start();
        imagepng($im);
        $contents = ob_get_contents();
        ob_end_clean();

        return response($contents)->header('Content-type', 'image/png');
    }
}
