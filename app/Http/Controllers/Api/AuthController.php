<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Helper\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Inscrire un utilisateur.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'role' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($user) {
                return ResponseHelper::success(message: "L'utilisateur a bien été stocké dans notre base de données !", data: $user->toArray(), statusCode: 200);
            }

            return ResponseHelper::error(message: "Essayez à nouveau, erreur !", statusCode: 400);

        } catch (Exception $e) {
            \Log::error('Impossible de s\'inscrire : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(message: "Essayez à nouveau l'inscription, erreur ! " . $e->getMessage(), statusCode: 500);
        }
    }

    /**
     * Fonction pour la connexion.
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ResponseHelper::error(message: 'Adresse email ou mot de passe invalide', statusCode: 400);
            }

            // Sinon si les informations sont correctes on génère le token
            $user = Auth::user();
            $token = $user->createToken('Token de mon API')->plainTextToken;

            return ResponseHelper::success(message: "Connexion réussie", data: ['token' => $token], statusCode: 200);

        } catch (Exception $e) {
            \Log::error('Impossible de se connecter: ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(message: "Essayez à nouveau de vous connecter, erreur ! " . $e->getMessage(), statusCode: 500);
        }
    }

    /**
     * Données de l'utilisateur connecté.
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        try {
            $user = Auth::user();
            if ($user) {
                return ResponseHelper::success(message: 'Profil de l\'utilisateur récupéré avec succès!', data: $user->toArray(), statusCode: 200);
            }

            return ResponseHelper::error(message: "Utilisateur non trouvé", statusCode: 404);

        } catch (Exception $e) {
            \Log::error('Impossible de trouver les données de l\'utilisateur: ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(message: "Erreur de récupération du profil utilisateur: " . $e->getMessage(), statusCode: 500);
        }
    }

  /**
   * function : Déconnexion de l'utilisateur
   * @param NA
   * @return JSONResponse
   */

   public function userLogout()
    {

        try {
            $user = Auth::user();
            if ($user) {
                $user->currentAccesToken()->delete();
                return ResponseHelper::success(message: 'Déconnexion avec succes!', data: $user->toArray(), statusCode: 200);
            }

            return ResponseHelper::error(message: "Déconnexion impossible token invalid", statusCode: 404);

        } catch (Exception $e) {
            \Log::error('Impossible de se deconnecter ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(message: "Erreur de déconnexion du profil utilisateur: " . $e->getMessage(), statusCode: 500);
        }
    }
}
