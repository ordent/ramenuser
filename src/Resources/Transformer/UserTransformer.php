<?php namespace Ordent\Ramenuser\Resources\Transformer;

use Ordent\Ramenplatform\Resources\Transformer\ResourceTransformer;
use Ordent\Ramenplatform\Contracts\Model\ResourceModelInterface;

class UserTransformer extends ResourceTransformer{
    protected $availableIncludes = [
      "roles"
    ];
    //passing contracts so model can pass as long as it implement the contracts
    public function transform(ResourceModelInterface $model){
        $results = $model->getTransformedData();
        if($model->roles->count() > 0){
          $results["roles"] = $model->roles;
        }
        return $results;
    }

    public function includeRoles(ResourceModelInterface $model){
        $results = $model->roles;
        $transformer = new ResourceTransformer();
        if($results->count()>0){
          $transformer = $results->get(0)->getTransformer();
        }
        return $this->collection($results, $transformer);
    }
}
