<?php
namespace App\Http\Composers;

use Illuminate\View\View;

class HelloComposer
{
  public function compose(View $view)
  {
    $view_message = 'this view is"'.$view->getName().'"!!';

    $view->with('view_message', $view_message);
  }
}