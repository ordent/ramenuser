<?php namespace Ordent\Ramenuser\Resources\Controller;

use Ordent\Ramenplatform\Resources\Controller\ResourceController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ordent\Ramenuser\Resources\Model\UserModel;
class RoleController extends ResourceController
{
  public function __construct(){
    parent::__construct(app(config('ramenuser.rolemodel')));
  }

  public function assign($id, $id_user){
    $role = $this->model->when(is_numeric($id),
      function($builder) use($id) {
        try{
          return $builder->findOrFail($id);
        }catch(ModelNotFoundException $e){
          return $this->response->makeResponse(404, "roles not found");
        }
      },
      function($builder) use ($id){
        $result = $builder->where('slug', $id)->get()->first();
        if($result){
          return $result;
        }else{
          return $this->response->makeResponse(404, "roles not found");
        }
      });

      $user = UserModel::when(is_numeric($id_user),
        function($builder) use ($id_user){
          try{
            return $builder->findOrFail($id_user);
          }catch(ModelNotFoundException $e){
            return $this->response->makeResponse(404, "users not found");
          }
        },
        function($builder) use ($id_user){
          $result = $builder->where('slug', $id_user)->get()->first();
          if($result){
            return $result;
          }else{
            return $this->response->makeResponse(404, "users not found");
          }
        }
      );

      $user->assignRole($role);

    return $this->response->makeResponse(200, "user roles assigned successfuly", $role, $role->getTransformer());
  }

  public function detach($id, $id_user){
    $role = $this->model->when(is_numeric($id),
      function($builder) use($id) {
        try{
          return $builder->findOrFail($id);
        }catch(ModelNotFoundException $e){
          return $this->response->makeResponse(404, "roles not found");
        }
      },
      function($builder) use ($id){
        $result = $builder->where('slug', $id)->get();
        if($result){
          return $result;
        }else{
          return $this->response->makeResponse(404, "roles not found");
        }
      });

      $user = UserModel::when(is_numeric($id_user),
        function($builder) use ($id_user){
          try{
            return $builder->findOrFail($id_user);
          }catch(ModelNotFoundException $e){
            return $this->response->makeResponse(404, "users not found");
          }
        },
        function($builder) use ($id_user){
          $result = $builder->where('slug', $id_user)->get();
          if($result){
            return $result;
          }else{
            return $this->response->makeResponse(404, "users not found");
          }
        }
      );

    $user->revokeRole($role);

    return $this->response->makeResponse(200, "user roles assigned successfuly", $role, $role->getTransformer());
  }

  public function check($id, $ids){
    $role = $this->model->when(is_numeric($id),
      function($builder) use($id) {
        try{
          return $builder->findOrFail($id);
        }catch(ModelNotFoundException $e){
          return $this->response->makeResponse(404, "roles not found");
        }
      },
      function($builder) use ($id){
        $result = $builder->where('slug', $id)->get()->first();
        if($result){
          return $result;
        }else{
          return $this->response->makeResponse(404, "roles not found");
        }
      });

      $user = UserModel::when(is_numeric($ids),
        function($builder) use ($ids){
          try{
            return $builder->findOrFail($ids);
          }catch(ModelNotFoundException $e){
            return $this->response->makeResponse(404, "users not found");
          }
        },
        function($builder) use ($ids){
          $result = $builder->where('slug', $ids)->get()->first();
          if($result){
            return $result;
          }else{
            return $this->response->makeResponse(404, "users not found");
          }
        }
      );

      $check = $user->hasRole($role->slug);
      $user->hasRole = $check;
      return $this->response->makeResponse(200, "results of role checking." , $user);
  }
}
