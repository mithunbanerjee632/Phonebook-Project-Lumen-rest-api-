<?php

namespace App\Providers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

         //user login korar por j encoded string pabe seta request er madhhome dhorbe and  token expired na hole string decode hobe ebong user() obj create hobe and seshe authenticate.php er handle() method er madhhome next procedure e jabe.orthat j route e authenticate apply kora seta access korte parbe and next procedure e jabe..And decode expired hole unauthorized hobe ..//

        $this->app['auth']->viaRequest('api', function ($request) {

            $token = $request->input('access_token');
            $key = env('TOKEN_KEY');
            
           
            try{
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return new User();  
            }catch(\Exception $e){
                return null;
            }
            // if ($request->input('api_token')) {
            //     return User::where('api_token', $request->input('api_token'))->first();
            // }
        });
    }
}
