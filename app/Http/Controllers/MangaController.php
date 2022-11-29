<?php

namespace App\Http\Controllers;

use App\dao\ServiceDessinateur;
use App\dao\ServiceGenre;
use App\dao\ServiceScenariste;
use Illuminate\Support\Facades\Request;

Use App\Exceptions\MonException;
use App\metier\mangas;
Use App\metier\Genre;
Use App\metier\Dessinateur;
Use App\metier\Scenariste;
Use App\dao\ServiceManga;


class MangaController
{
    public function listerMangas() {
        try {

            $unMangas = new ServiceManga();
            $mesMangas = $unMangas->getListeMangas();
            foreach($mesMangas as $manga) {
                if(!file_exists(public_path().'/images/'.$manga->couverture)) {
                }
            }
            return view('vues/listerMangas', compact('mesMangas'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

    public function ajoutManga() {
        try {
            $unGenre = new ServiceGenre();
            $mesGenres = $unGenre->getListeGenres();
            $unScenariste = new ServiceScenariste;
            $mesScenaristes = $unScenariste->getListeScenaristes();
            $unDessinateur = new ServiceDessinateur;
            $mesDessinateurs = $unDessinateur->getListeDessinateurs();
            return view('vues.formMangaAjout', compact('mesGenres', 'mesScenaristes', 'mesDessinateurs'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues.error', compact('monErreur'));
        } catch (\Exception $ex) {
            $monErreur = $ex->getMessage();
            return view('vues.error', compact('monErreur'));
        }
    }

    public function postAjouterManga() {
        try {
            $code_d = Request::input('cbDessinateur');
            $prix = Request::input('prix');
            $id_scenariste = Request::input('cdScenariste');
            $titre = Request::input('titre');
            $couverture = Request::file('couverture');
            $code_ge = Request::input('cbGenres');

            if (isset($couverture)) {
                $imageName = $couverture->getClientOriginalName();
                Request::file('couverture')->move(public_path().'/assets/images/', $imageName);
            } else {
                $imageName='erreur.png';
            }
            $unManga= new ServiceManga();
            $unManga->ajoutManga($code_d, $prix, $titre, $imageName, $code_ge, $id_scenariste);
            return view('home');
        }catch (MonException $e){
            $monErreur = $e->getMessage();
            $unoErreur = 'une erreur s\'est produite';
            return view('home', compact('unoErreur'));
        }catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

    public function modification($id){
        try {
            $unServiceManga= new ServiceManga();
            $unManga= $unServiceManga->getManga($id);
            $unServiceGenre= new ServiceGenre();
            $mesGenres= $unServiceGenre->getListeGenres();
            $unServiceScenariste= new ServiceScenariste();
            $mesScenaristes= $unServiceScenariste->getListeScenaristes();
            $unServiceDessinateur= new ServiceDessinateur();
            $mesDessinateurs= $unServiceDessinateur->getListeDessinateurs();

            return view('vues/formModifmanga', compact('unManga', 'mesGenres', 'mesScenaristes', 'mesDessinateurs'));

        }catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }
    public function postModiferManga($id=null){
        try {
            $code= $id;
            $code_d= Request:: input('cbDessinateur');
            $prix= Request:: input('prix');
            $id_scenariste= Request:: input('cbScenariste');
            $titre= Request:: input('titre');
            $couverture= Request:: input('couverture');
            $code_ge= Request:: input('cbGenres');

            $unServiceManga= new ServiceManga();
            $unServiceManga->modificationManga($code,$code_d, $prix, $titre, $couverture, $code_ge, $id_scenariste);
            $mesMangas= $unServiceManga->getListeMangas();
            return view('vues/listerMangas', compact('mesMangas'));

        }catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

    public function listerGenre(){
        try {
            $unGenre= new ServiceGenre();
            $mesGenre=$unGenre->getListeGenres();
            return view('vues/formChoixMangaGenre', compact('mesGenre'));
        }catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

    public function listerMangasGenre() {
        try {

            $unMangas = new ServiceManga();
            $idGenre = Request::input('cbGenres');
            $mesMangas=$unMangas->getListeMangasGenre($idGenre);
            return view('vues/listerMangas', compact('mesMangas'));
        }catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

}
