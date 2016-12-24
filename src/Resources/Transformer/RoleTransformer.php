<?php namespace Ordent\Ramenuser\Resources\Transformer;

use Ordent\Ramenplatform\Resources\Transformer\ResourceTransformer;
use Ordent\Ramenplatform\Contracts\Model\ResourceModelInterface;

class RoleTransformer extends ResourceTransformer{
    protected $availableIncludes = [
      "users"
    ];
    //passing contracts so model can pass as long as it implement the contracts
    public function transform(ResourceModelInterface $model){
        $results = $model->getTransformedData();
        if($model->users->count() > 0){
          $results["users"] = $model->users;
        }
        return $results;
    }

    public function includeUsers(ResourceModelInterface $model){
        $results = $model->users;
        $transformer = new ResourceTransformer();
        if($results->count()>0){
          $transformer = $results->get(0)->getTransformer();
        }
        return $this->collection($results, $transformer);
    }
}
