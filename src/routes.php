<?php

use Illuminate\Http\Request;

\RApi::version('v1', function($api){
      $api->get('users', '\Ordent\Ramenuser\Resources\Controller\UserController@index');
      $api->get('users/{id}', '\Ordent\Ramenuser\Resources\Controller\UserController@show');
      $api->post('users', '\Ordent\Ramenuser\Resources\Controller\UserController@store');
      $api->put('users/{id}', '\Ordent\Ramenuser\Resources\Controller\UserController@update');
      $api->delete('users/{id}', '\Ordent\Ramenuser\Resources\Controller\UserController@delete');

      $api->post('users/{id}/roles/{id_user}', '\Ordent\Ramenuser\Resources\Controller\UserController@assign');
      $api->post('users/{id}/detach/{id_user}', '\Ordent\Ramenuser\Resources\Controller\UserController@detach');
      $api->get('users/{id}/check/{ids}','\Ordent\Ramenuser\Resources\Controller\UserController@check');

      $api->get('roles', '\Ordent\Ramenuser\Resources\Controller\RoleController@index');
      $api->post('roles', '\Ordent\Ramenuser\Resources\Controller\RoleController@store');
      $api->get('roles/{id}', '\Ordent\Ramenuser\Resources\Controller\RoleController@show');
      $api->put('roles/{id}', '\Ordent\Ramenuser\Resources\Controller\RoleController@update');
      $api->delete('roles/{id}', '\Ordent\Ramenuser\Resources\Controller\RoleController@delete');

      $api->post('roles/{id}/users/{id_user}', '\Ordent\Ramenuser\Resources\Controller\RoleController@assign');
      $api->post('roles/{id}/detach/{id_user}', '\Ordent\Ramenuser\Resources\Controller\RoleController@detach');
      $api->get('roles/{id}/check/{ids}','\Ordent\Ramenuser\Resources\Controller\RoleController@check');

});
