<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image;
use DB;

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
       });  

       $img->save(public_path('uploads/test/2.jpg'));  
    }


    public function qr1()
    {
  		QrCode::size(500)->format('svg')->generate('Make me into a QrCode!', public_path('uploads/test/1.svg'));
    }


    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image'
        ]);
        
        $upload = $request->file('upload');
        $ts = date('m-j-Y H-i-s', strtotime(now()));
        $filename =  $ts . '.jpg';
        $upload->move(public_path('/uploads/images/'), $filename);

        $img = Image::make(public_path('uploads/test/'. $filename));  
        $timestamp = date('F j, Y H:i:s', strtotime(now()));
        $img->text($timestamp, 50, 120, function($font) {  
            $font->file(public_path('fonts/RobotoMonoBold.ttf'));  
            $font->size(80);
            $font->color('#ffa500');
            $font->align('left');
        });  

       $img->save(public_path('uploads/images/' . $filename));  

       DB::table('upload')->insert([
        'filename' => $filename
       ]);

       return redirect()->back()->with('success', 'Uploaded');
    }


    public function days()
    {
      return date('t');
    }


    public function range($id)
    {
      $item = \App\AuditItem::find($id);

      $r1 = explode(",", $item->time_range);
      $r1 = "09:00-10:00,11:00-12:00,";

        $range = explode(",", $r1);

        $data = [];

        foreach($range as $r) {
            if($r != "") {
                $time = explode("-", $r);
                $from = explode(":", $time[0]);
                $to = explode(":", $time[1]);

                $data[] = [
                    $from[0], // From Hour
                    $from[1], // From Minute
                    $to[0], // To Hour
                    $to[1] // To Minute
                ];
            }
        }

        return $data;
    }
}
