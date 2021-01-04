<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHandler {
    /**
     * @param File $image
     * 
     * @return string
     */
    public static function store($images) {
        $code = 201;
        $links = [];
        $errors = [];

        foreach ($images as $key => $image) {
            try{
                $stored = Storage::put('public/images', $image, 'public');
                $link = Storage::url($stored);
                array_push($links, ['imagen' => $link]);
            }catch(\Exception $e){
                array_push($errors, ['image' => 'Can not store this file', 'file' => $image]);
            }
        }

        return [
            'links' => $links,
            'errors' => $errors,
        ];
    }
}