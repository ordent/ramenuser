<?php
namespace Ordent\Ramenuser\Resources\Controller;
use Ordent\Ramenplatform\Resources\Controller\ResourceController;
use Ordent\Ramenuser\Resources\Model\RoleModel;

class UserController extends ResourceController
{
  public function __construct(){
    parent::__construct(app(config('ramenuser.usermodel')));
  }

  public function assign($id, $id_role){
    $user = $this->model->when(is_numeric($id),
      function($builder) use($id) {
        try{
          return $builder->findOrFail($id);
        }catch(ModelNotFoundException $e){
          return $this->response->makeResponse(404, "users not found");
        }
      },
      function($builder) use ($id){
        $result = $builder->where('slug', $id)->get()->first();
        if($result){
          return $result;
        }else{
          return $this->response->makeResponse(404, "users not found");
        }
      });

      $role = RoleModel::when(is_numeric($id_role),
        function($builder) use ($id_role){
          try{
            return $builder->findOrFail($id_role);
          }catch(ModelNotFoundException $e){
            return $this->response->makeResponse(404, "roles not found");
          }
        },
        function($builder) use ($id_role){
          $result = $builder->where('slug', $id_role)->get()->first();
          if($result){
            return $result;
          }else{
            return $this->response->makeResponse(404, "roles not found");
          }
        }
      );

      $user->assignRole($role);

    return $this->response->makeResponse(200, "user roles assigned successfuly", $user, $user->getTransformer());
  }

  public function detach($id, $id_role){
    $user = $this->model->when(is_numeric($id),
      function($builder) use($id) {
        try{
          return $builder->findOrFail($id);
        }catch(ModelNotFoundException $e){
          return $this->response->makeResponse(404, "user not found");
        }
      },
      function($builder) use ($id){
        $result = $builder->where('slug', $id)->get();
        if($result){
          return $result;
        }else{
          return $this->response->makeResponse(404, "user not found");
        }
      });

      $role = RoleModel::when(is_numeric($id_role),
        function($builder) use ($id_role){
          try{
            return $builder->findOrFail($id_role);
          }catch(ModelNotFoundException $e){
            return $this->response->makeResponse(404, "roles not found");
          }
        },
        function($builder) use ($id_role){
          $result = $builder->where('slug', $id_role)->get();
          if($result){
            return $result;
          }else{
            return $this->response->makeResponse(404, "roles not found");
          }
        }
      );

    $user->revokeRole($role);

    return $this->response->makeResponse(200, "user roles assigned successfuly", $role, $role->getTransformer());
  }

  public function check($id, $id_role){
    $user = $this->model->when(is_numeric($id),
      function($builder) use($id) {
        try{
          return $builder->findOrFail($id);
        }catch(ModelNotFoundException $e){
          return $this->response->makeResponse(404, "users not found");
        }
      },
      function($builder) use ($id){
        $result = $builder->where('slug', $id)->get()->first();
        if($result){
          return $result;
        }else{
          return $this->response->makeResponse(404, "users not found");
        }
      });

      $role = RoleModel::when(is_numeric($id_role),
        function($builder) use ($id_role){
          try{
            return $builder->findOrFail($id_role);
          }catch(ModelNotFoundException $e){
            return $this->response->makeResponse(404, "roles not found");
          }
        },
        function($builder) use ($id_role){
          $result = $builder->where('slug', $id_role)->get()->first();
          if($result){
            return $result;
          }else{
            return $this->response->makeResponse(404, "roles not found");
          }
        }
      );

      $check = $user->hasRole($role->slug);
      $user->hasRole = $check;

      return $this->response->makeResponse(200, "results of role checking", $user, $user->getTransformer());
  }

}
