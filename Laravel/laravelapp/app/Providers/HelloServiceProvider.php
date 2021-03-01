<?php

namespace App\Providers;

use App\Http\Validators\HelloValidator;
use Illuminate\support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class HelloServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    $validator = $this->app['validator'];
    $validator->resolver(function($translator, $data, $rules, $messages) {
      return new HelloValidator($translator, $data, $rules, $messages);
    });
  }
}
