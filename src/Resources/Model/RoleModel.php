<?php namespace Ordent\Ramenuser\Resources\Model;
use Kodeine\Acl\Models\Eloquent\Role;
use Ordent\Ramenplatform\Contracts\Model\ResourceModelInterface;
use Ordent\Ramenplatform\Resources\Traits\ResourceModelTrait;

class RoleModel extends Role implements ResourceModelInterface{
  use ResourceModelTrait;
  public $table = "roles";
  /**
   * attributes of a model
   * @var array of attributes name on string
   */
  protected $attributes = [
    "name"        => "",
    "slug"        => "",
    "description" => ""
  ];
  protected $fillable = [];
  /**
   * casting of a attributes to native types, useful for native types, like integer, boolean, JsonSerializable
   * @var ["attributes"=>"type"]
   */
  protected $casts = [

  ];
  /**
   * casting of a date attributes
   * @var ["attributes1", "attributes2"]
   */
  protected $dates = [

  ];

  /**
   * original state of an attributes
   * @var ["isActive" => 1]
   */
  protected $original = [
    "name"        => "",
    "slug"        => "",
    "description" => ""
  ];

  /**
   * set the transformer file of the model
   * @var string
   */
  protected $transformers = "Ordent\Ramenuser\Resources\Transformer\RoleTransformer";

  /**
   * set the rules of an attributes
   * @var [type]
   */
  protected $rules = [
      "store" => [
        "name" => "required|unique:roles"
      ],
      "update" => [],
      "delete" => []
  ];

  /**
   * list of scope to be used as filter for index operation
   * @var array
   */
  protected $indexFilters = ['pagination', 'sort'];

  /*
  * list of attribute that have files type.
  */
  protected $files = [];
  protected $uploadPath = "/uploads";

  public function setNameAttribute($value){
    $this->attributes["name"] = $value;
    $this->attributes["slug"] = str_slug($value);
  }

  public function __construct(){
    // if fillable attributes is empty, auto add fillable based on attributes array.
    if(count($this->fillable) == 0){
      foreach($this->attributes as $key => $attr){
        array_push($this->fillable, $key);
      }
    }
  }

  public function users(){
    return $this->belongsToMany(config('ramenuser.usermodel'), 'role_user', 'user_id', 'role_id')->withTimestamps();
  }
}
