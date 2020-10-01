<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;

class VideoController extends Controller
    {
        public function createVideo() {
        return view('video.createVideo');
        }

        public function saveVideo(Request $request){

            // Validar formulario
            $validateData = $this->validate($request, [
                'title' => 'required|min:5',
                'description' => 'required',
                'video' => 'mimes:mp4'  
            ]);

            // Usamos el objeto Auth para traer al usuario
            $video = new Video();
            $user = \Auth::user();
            $video->user_id = $user->id;
            $video->title = $request->input('title');
            $video->description = $request->input('description');

            // Subida de la miniatura
            $image = $request->file('image');
            if( $image ) {
                $image_path = time().$image->getClientOriginalName();
                \Storage::disk('images')->put($image_path, \File::get($image));
                $video->image = $image_path;
            }

            // Subida del video
            $video_file = $request->file('video');
                if( $video_file ) {
                    $video_path = time().$video_file->getClientOriginalName();
                    \Storage::disk('videos')->put($video_path, \File::get($video_file));
                    $video->video_path = $video_path;
                }

            $video->save();

            return redirect()->route('home')->with(array(
                'message' => 'El video se ha subido correctamente!!'
            ));

        }


        public function getImage( $filename ) {
            $file = Storage::disk('images')->get($filename);
            return new Response($file, 200);
        }

        // ¿Qué le tenmos que pasar a este método por la url? - pues la id del video que queremos mostrar
        public function getVideoPage($video_id){
            // Tenemos que hacer un find a la base de datos para obtener todos los registros
            // Utilizando elocuent lo podemos hacer de la siguiente manera
            $video = Video::find($video_id);
            // Ahora vamos a renderizar la vista
            return view('video', array(
                'video' => $video
            ));
            // Solo falta crear la vista dentro de 
        }

    }
