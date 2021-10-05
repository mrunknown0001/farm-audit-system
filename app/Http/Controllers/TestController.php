<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TestController extends Controller
{
    //
    public function timestamp()
    {
       $img = Image::make(public_path('uploads/test/1.jpg'));  

       $timestamp = date('F j, Y H:i:s', strtotime(now()));

       $img->text($timestamp, 30, 30, function($font) {  

          $font->file(public_path('fonts/RobotoMonoBold.ttf'));  

          $font->size(15);  

          $font->color('#000000');  

          $font->align('left');  

          // $font->valign('bottom');  

          // $font->angle(90);  

      });  

       $img->save(public_path('uploads/test/2.jpg'));  
    }


    public function qr1()
    {
		QrCode::size(500)->format('svg')->generate('Make me into a QrCode!', public_path('uploads/test/1.svg'));
    }
}
