<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
class ImageController extends Controller
{
    public function create(Request $request){
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        $imageModel = new Image();
        $imageModel->CODACTUAL = $request->codactual;
        $imageModel->nombre = $imageName;
        $imageModel->save();

        return response()->json(['message' => 'Imagenes subida correctamente']);
    }
    else{
        return response()->json(['error' => 'No se ha proporcionado una imagen']);
    }
    
    }
    public function show($id){
        $imagenes = Image::where('CODACTUAL','=',$id)->get();
        return ['imagenes' => $imagenes];
        }
}
