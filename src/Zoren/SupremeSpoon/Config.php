<?php
namespace Zoren\SupremeSpoon;

class Config
{
  /**
   * @var array
   */
  protected $values = [];
  
  /**
   * @param array $values
   */
  public function __construct(array $values = [])
  {
    $this->values = array_merge($this->getDefaults(), $values);
  }
  
  /**
   * @param string $name
   * @param mixed $default
   * @return mixed
   */
  public function get($name, $default = null)
  {
    if (!isset($this->values[$name])) {
      return $default;
    }
    
    return $this->values[$name];
  }
  
  /**
   * @return array
   */
  protected function getDefaults()
  {
    return [
      "database" => [
        "host" => "localhost",
        "name" => "mlss",
        "user" => "mlss_user",
        "pass" => "mlss_pass"
      ],
      "subreddit" => "funny"
    ];
  }
}
