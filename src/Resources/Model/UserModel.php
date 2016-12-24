<?php namespace Ordent\Ramenuser\Resources\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Ordent\Ramenplatform\Contracts\Model\ResourceModelInterface;
use Ordent\Ramenplatform\Resources\Traits\ResourceModelTrait;
use Kodeine\Acl\Traits\HasRole;

class UserModel extends Authenticatable implements ResourceModelInterface
{
  use ResourceModelTrait, HasApiTokens, Notifiable, HasRole;
  protected $table = "users";
  /**
   * attributes of a model
   * @var array of attributes name on string
   */
  protected $attributes = [
    "username"   => "",
    "password"   => "",
    "first_name" => "",
    "last_name"  => "",
    "email"      => ""
  ];
  protected $fillable = [];
  protected $hidden = ["password"];
  /**
   * casting of a attributes to native types, useful for native types, like integer, boolean, JsonSerializable
   * @var ["attributes"=>"type"]
   */
  protected $casts = [];
  /**
   * casting of a date attributes
   * @var ["attributes1", "attributes2"]
   */
  protected $dates = [];

  /**
   * original state of an attributes
   * @var ["isActive" => 1]
   */
  protected $original = [
    "username"   => "",
    "password"   => "",
    "first_name" => "",
    "last_name"  => "",
    "email"      => ""
  ];

  /**
   * set the transformer file of the model
   * @var string
   */
  protected $transformers = "Ordent\Ramenuser\Resources\Transformer\UserTransformer";

  /**
   * set the rules of an attributes
   * @var [type]
   */
  protected $rules = [
      "store" => [
        "username" => "required|unique:users",
        "email"    => "required|email|unique:users",
        "password" => "required|confirmed"
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

  public function __construct(){
    // if fillable attributes is empty, auto add fillable based on attributes array.
    if(count($this->fillable) == 0){
      foreach($this->attributes as $key => $attr){
        array_push($this->fillable, $key);
      }
    }
  }

  public function setPasswordAttribute($value){
    $this->attributes['password'] = Hash::make($value);
  }
  public function roles(){
    return $this->belongsToMany(config('ramenuser.rolemodel'), 'role_user', 'role_id', 'user_id')->withTimestamps();
  }
}
