<?php

namespace App\Http\Controllers;

Use App\dao\ServiceManga;
use App\dao\ServiceDessinateur;
use App\dao\ServiceGenre;
use App\dao\ServiceScenariste;
use Illuminate\Support\Facades\Request;

Use App\Exceptions\MonException;
use App\metier\mangas;
Use App\metier\Genre;
Use App\metier\Dessinateur;
Use App\metier\Scenariste;

class GenreController
{
    public function listerMangasGenreAjax($id){
        try{
            $unServiceManga= new ServiceManga();
            $rep = $unServiceManga->getListeMangasGenreAjax($id);
            return $rep;
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (\Exception $ex) {
            $monErreur = $ex->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

}
